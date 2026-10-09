<#
.SYNOPSIS
    Builds a cPanel release zip from a git commit.

.DESCRIPTION
    Exports the commit with `git archive --format=zip`, installs production
    composer dependencies, and packages a Laravel 10-style zip that is
    extracted inside /home/imfitrs/fitapp:

        app, bootstrap/app.php, bootstrap/cache/.gitignore, config, database,
        resources, routes, vendor, artisan, composer.json, composer.lock,
        RELEASE.txt

    public/, storage/, .env and public_html/ stay on the server and are not
    in the zip. The zip is written by Git (not Windows tar.exe) so cPanel
    does not treat it as a zip bomb.

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1
    powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1 -Ref v1.2.0
#>
param(
    [string]$Ref = 'HEAD'
)

$ErrorActionPreference = 'Stop'

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$root = Resolve-Path (Join-Path $PSScriptRoot '..')
Set-Location $root

function Invoke-Native {
    param([string]$Description, [scriptblock]$Command)
    & $Command
    if ($LASTEXITCODE -ne 0) {
        throw "$Description failed with exit code $LASTEXITCODE."
    }
}

$dirty = git status --porcelain
if ($dirty) {
    throw "Working tree has uncommitted changes. Commit or stash them first, so the zip matches a commit.`n$($dirty -join "`n")"
}

$sha = (git rev-parse --short $Ref).Trim()
if ($LASTEXITCODE -ne 0) {
    throw "Unknown git ref '$Ref'."
}
$fullSha = (git rev-parse $Ref).Trim()
$stamp = Get-Date -Format 'yyyyMMdd-HHmm'
$zipName = "release-$stamp-$sha.zip"

$build = Join-Path $root 'build'
$dist = Join-Path $root 'dist'
$app = Join-Path $build 'fitapp'
$sourceZip = Join-Path $build 'source.zip'
$zipPath = Join-Path $dist $zipName

if (Test-Path $build) {
    Remove-Item $build -Recurse -Force
}
New-Item -ItemType Directory -Path $app | Out-Null
New-Item -ItemType Directory -Path $dist -Force | Out-Null

Write-Host "Exporting $Ref ($sha)..."
Invoke-Native 'git archive' { git archive --format=zip -o $sourceZip $Ref }
[System.IO.Compression.ZipFile]::ExtractToDirectory($sourceZip, $app)
Remove-Item $sourceZip

Write-Host 'Installing production composer dependencies...'
Invoke-Native 'composer install' {
    composer install --working-dir="$app" --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress
}

# Cached PHP files contain absolute Windows paths; regenerate them on the server.
Get-ChildItem (Join-Path $app 'bootstrap\cache') -Filter '*.php' -ErrorAction SilentlyContinue |
    Remove-Item -Force

$keep = @(
    'app',
    'bootstrap',
    'config',
    'database',
    'resources',
    'routes',
    'vendor',
    'artisan',
    'composer.json',
    'composer.lock'
)
Get-ChildItem $app -Force | Where-Object { $keep -notcontains $_.Name } | ForEach-Object {
    Remove-Item $_.FullName -Recurse -Force
}

# storage/ and public/ stay on the server. bootstrap/cache keeps only .gitignore.
foreach ($extra in 'public', 'storage') {
    $path = Join-Path $app $extra
    if (Test-Path $path) {
        Remove-Item $path -Recurse -Force
    }
}

$releaseInfo = "ref: $Ref`ncommit: $fullSha`nbuilt: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss zzz')`n"
[IO.File]::WriteAllText((Join-Path $app 'RELEASE.txt'), $releaseInfo.Replace("`r`n", "`n"))

Write-Host "Packaging $zipName with git archive..."
Invoke-Native 'git init (staging)' { git -C $app init --quiet }
Invoke-Native 'git add (staging)' { git -C $app -c core.autocrlf=false add -A }
Invoke-Native 'git commit (staging)' {
    git -C $app `
        -c core.autocrlf=false `
        -c user.email=release@local `
        -c user.name=release `
        commit --quiet -m "release $sha"
}
Invoke-Native 'git archive zip' { git -C $app archive --format=zip -o $zipPath HEAD }

Remove-Item $build -Recurse -Force

Write-Host 'Inspecting zip...'
$archive = [System.IO.Compression.ZipFile]::OpenRead($zipPath)
try {
    $names = @($archive.Entries | ForEach-Object { $_.FullName.Replace('\', '/') })
    $backslash = @($archive.Entries | Where-Object { $_.FullName -match '\\' })
    if ($backslash.Count -gt 0) {
        throw "Zip has $($backslash.Count) backslash paths; Git zip should use forward slashes."
    }
    if ($names -notcontains 'vendor/autoload.php') {
        throw 'Zip is missing vendor/autoload.php.'
    }
    if ($names -notcontains 'artisan' -or $names -notcontains 'composer.lock') {
        throw 'Zip is missing artisan or composer.lock.'
    }
    $blocked = $names | Where-Object {
        $_ -match '(^|/)\.env($|\.)' -or
        $_ -match '^public(/|$)' -or
        $_ -match '^storage(/|$)' -or
        $_ -match '^vendor/phpunit/' -or
        $_ -match '^vendor/spatie/laravel-ignition/' -or
        $_ -match '^vendor/barryvdh/' -or
        $_ -match '^vendor/nunomaduro/collision/' -or
        $_ -match '^vendor/beyondcode/'
    }
    if ($blocked) {
        throw "Zip contains files that must stay out of a release:`n$($blocked -join "`n")"
    }
    $entryCount = $names.Count
    if ($entryCount -gt 12000) {
        throw "Zip has $entryCount entries; expected the Laravel 10 range (thousands, not 17k+)."
    }
} finally {
    $archive.Dispose()
}

$sizeMb = [Math]::Round((Get-Item $zipPath).Length / 1MB, 1)
Write-Host "Done: dist\$zipName ($sizeMb MB, $entryCount entries)"
