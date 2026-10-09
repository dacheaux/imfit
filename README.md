# ImFit

ImFit - Ivanova Aplikacija

## Deploy (cPanel, no terminal)

The server layout in `/home/imfitrs` is:

- `fitapp/`: the Laravel app, with `.env`, `vendor/` and `storage/`
- `public_html/`: the web root, with the contents of `public/`, uploads in `public_html/images`, and the server's own `.htaccess`

Releases are zips built from a git commit with Git's zip writer (not Windows tar). A zip contains only the app code plus production `vendor/`: `app`, `bootstrap/app.php`, `bootstrap/cache/.gitignore`, `config`, `database`, `resources`, `routes`, `vendor`, `artisan`, `composer.json`, `composer.lock`, and `RELEASE.txt`. It never contains `.env`, `public/`, `public_html/`, or `storage/` contents.

### One-time setup

1. In cPanel MultiPHP Manager, set the domain to PHP 8.2 or newer.
2. In `fitapp/.env`, set `DEPLOY_TOKEN` to a long random string. Keep it secret: anyone with it can run migrations.
3. Copy `scripts/cpanel-index.php` over `/home/imfitrs/public_html/index.php` so `public_path()` points at `public_html` (uploads and QR codes). Repeat this copy only if that file changes.

### Every release

1. Commit everything, then build the zip on a dev machine with PHP 8.2+ and composer:

   ```powershell
   powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1
   ```

   This writes `dist/release-<date>-<commit>.zip`. Use `-Ref <tag or commit>` to build an older commit.
2. Back up first: export the database in phpMyAdmin, and compress `fitapp/` in File Manager (or keep the previous release zip).
3. In File Manager, delete `fitapp/vendor` and every `.php` file in `fitapp/bootstrap/cache`. Extracting does not delete files, so old vendor files would otherwise be mixed with the new ones.
4. Upload the zip **into `/home/imfitrs/fitapp`**, then Extract it there and overwrite.
5. Open `https://<domain>/_deploy/<DEPLOY_TOKEN>`. It runs `optimize:clear`, `migrate --force`, `storage:link` (if missing), `config:cache` and `view:cache`, and prints the output. The last line must be `Deploy finished OK.`
6. `fitapp/RELEASE.txt` shows which commit is deployed.

The deploy URL refuses to run when the `migrations` table is missing or empty. In that state `migrate` would load `database/schema/mysql-schema.dump`, which drops and recreates every table.

After changing `fitapp/.env`, open the deploy URL again, because the config is cached.

### Rollback

1. Repeat steps 3 and 4 with the previous release zip, then open the deploy URL.
2. If the bad release ran a migration, restore the database backup in phpMyAdmin.
