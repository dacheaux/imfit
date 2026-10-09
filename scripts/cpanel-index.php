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
