<#
.SYNOPSIS
    Builds a cPanel release zip from a git commit.

.DESCRIPTION
    Exports the commit with `git archive`, installs production composer
    dependencies into it, and packages two folders that are extracted in the
    cPanel home directory (/home/imfitrs):

        fitapp/       the Laravel app, including vendor/
        public_html/  the contents of public/, with an index.php that loads ../fitapp

    The server's .env, public_html/.htaccess, public_html/images and storage/
    contents are never part of the zip.

.EXAMPLE
    powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1
    powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1 -Ref v1.2.0
#>
param(
    [string]$Ref = 'HEAD'
)

$ErrorActionPreference = 'Stop'

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
$publicHtml = Join-Path $build 'public_html'
$tar = Join-Path $env:SystemRoot 'System32\tar.exe'

if (Test-Path $build) {
    Remove-Item $build -Recurse -Force
}
New-Item -ItemType Directory -Path $app | Out-Null
New-Item -ItemType Directory -Path $dist -Force | Out-Null

Write-Host "Exporting $Ref ($sha)..."
$archive = Join-Path $build 'source.tar'
Invoke-Native 'git archive' { git archive --format=tar -o $archive $Ref }
Invoke-Native 'Extracting source' { & $tar -xf $archive -C $app }
Remove-Item $archive

Write-Host 'Installing production composer dependencies...'
Invoke-Native 'composer install' {
    composer install --working-dir="$app" --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress
}

# Caches with absolute paths must be built on the server (via /_deploy/{token}).
foreach ($cache in 'config.php', 'routes-v7.php', 'routes.php', 'events.php') {
    $path = Join-Path $app "bootstrap\cache\$cache"
    if (Test-Path $path) {
        Remove-Item $path -Force
    }
}

# Empty storage skeleton; extracting never removes existing logs, sessions or uploads.
$storage = Join-Path $app 'storage'
foreach ($dir in 'framework', 'logs') {
    $path = Join-Path $storage $dir
    if (Test-Path $path) {
        Remove-Item $path -Recurse -Force
    }
}
foreach ($dir in 'framework\cache\data', 'framework\sessions', 'framework\views', 'logs') {
    $path = Join-Path $storage $dir
    New-Item -ItemType Directory -Path $path -Force | Out-Null
    Set-Content -Path (Join-Path $path '.gitignore') -Value "*`n!.gitignore" -NoNewline -Encoding ascii
}

Write-Host 'Moving public/ to public_html/...'
Move-Item (Join-Path $app 'public') $publicHtml

$indexPhp = @'
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// public_html sits next to the app folder in the cPanel home directory.
$appPath = __DIR__.'/../fitapp';

if (file_exists($maintenance = $appPath.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $appPath.'/vendor/autoload.php';

$app = require_once $appPath.'/bootstrap/app.php';

// Uploads and QR codes are written with public_path(), so it must point here.
$app->usePublicPath(__DIR__);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
'@
[IO.File]::WriteAllText((Join-Path $publicHtml 'index.php'), $indexPhp.Replace("`r`n", "`n"))

$releaseInfo = "ref: $Ref`ncommit: $fullSha`nbuilt: $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss zzz')`n"
[IO.File]::WriteAllText((Join-Path $app 'RELEASE.txt'), $releaseInfo)

Write-Host "Packaging $zipName..."
$zipPath = Join-Path $dist $zipName
Invoke-Native 'Creating zip' { & $tar -a -c -f $zipPath -C $build fitapp public_html }

Remove-Item $build -Recurse -Force

$sizeMb = [Math]::Round((Get-Item $zipPath).Length / 1MB, 1)
Write-Host "Done: dist\$zipName ($sizeMb MB)"
