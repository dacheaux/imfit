# ImFit

ImFit - Ivanova Aplikacija

## Deploy (cPanel, no terminal)

The server layout in `/home/imfitrs` is:

- `fitapp/`: the Laravel app, with `.env`, `vendor/` and `storage/`
- `public_html/`: the cPanel document root. Apache and `php artisan serve` serve this folder. `bootstrap/app.php` remaps `public_path()` here when the sibling folder exists, so uploads and `asset()` URLs resolve in `public_html`, not in `fitapp/public`.
- `fitapp/public/`: Laravel fallback stubs only (`index.php`, `robots.txt`, `no-image` placeholders). It is not the live web root.

Releases are zips built from a git commit with Git's zip writer (not Windows tar). A zip contains only the app code plus production `vendor/`: `app`, `bootstrap/app.php`, `bootstrap/cache/.gitignore`, `config`, `database`, `resources`, `routes`, `vendor`, `artisan`, `composer.json`, `composer.lock`, and `RELEASE.txt`. It never contains `.env`, `public/`, `public_html/`, or `storage/` contents.

### One-time setup

1. In cPanel MultiPHP Manager, set the domain to PHP 8.2 or newer.
2. In `fitapp/.env`, set `DEPLOY_TOKEN` to a long random string. Keep it secret: anyone with it can rebuild caches.
3. Copy `scripts/cpanel-index.php` over `/home/imfitrs/public_html/index.php` so Apache boots `../fitapp`. Repeat this copy only if that file changes. `public_path()` is set in `fitapp/bootstrap/app.php`.

Locally, from `fitapp/`, run `php artisan serve`. It uses the same `public_html` web root as production.

### Every release

1. Commit everything, then build the zip on a dev machine with PHP 8.2+ and composer:

   ```powershell
   powershell -ExecutionPolicy Bypass -File scripts/build-release.ps1
   ```

   This writes `dist/release-<date>-<commit>.zip`. Use `-Ref <tag or commit>` to build an older commit.
2. Back up first: export the database in phpMyAdmin, and compress `fitapp/` in File Manager (or keep the previous release zip).
3. In File Manager, delete `fitapp/vendor` and every `.php` file in `fitapp/bootstrap/cache`. Extracting does not delete files, so old vendor files would otherwise be mixed with the new ones.
4. Upload the zip **into `/home/imfitrs/fitapp`**, then Extract it there and overwrite.
5. Open `https://<domain>/_deploy/<DEPLOY_TOKEN>`. It runs `optimize:clear`, `storage:link` (if missing), `config:cache` and `view:cache`, and prints the output. The last line must be `Deploy finished OK.`
6. `fitapp/RELEASE.txt` shows which commit is deployed.

After changing `fitapp/.env`, open the deploy URL again, because the config is cached.

### Rollback

1. Repeat steps 3 and 4 with the previous release zip, then open the deploy URL.
2. If you also need the previous data, restore the database backup in phpMyAdmin.

## Images and assets

Keep live files in `public_html`. Do not merge user uploads into `fitapp/`.

| Kind | Location |
| --- | --- |
| Avatars, shop, blog, gallery, TinyMCE, QR codes | **`public_html` only** (`uploads/`, `gallery/photos/`, `upload-posts/`, `images/`) |
| Theme CSS/JS/images, admin assets | **`public_html` only** (`assets/`, `assets-admin/`, `img/`) |
| Placeholders (`uploads/no-image.jpg`, `uploads/products/no-image.jpg`) | git `fitapp/public` and `public_html` |
| cPanel leftovers (`.htaccess`, `cgi-bin/`, `error_log`) | `public_html` only |

Theme and user-generated files live only in `public_html`. Those trees under `fitapp/public` are gitignored. Do not copy `public_html/images`, `public_html/uploads`, or theme folders into git. Deploys do not overwrite `public_html`, so those files persist across releases. Feature tests do not upload files; FakeQrCode avoids writing QR PNGs into live `images/`.

The live header logo is `public_html/assets/images/logo.png` (barbell, “FITNESS FOR ALL”). Edit theme files in `public_html`. Release zips will not replace them. If the sibling `public_html` folder is missing, `public_path()` falls back to `fitapp/public` and the site would have no theme.
