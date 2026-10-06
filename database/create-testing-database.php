<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

Illuminate\Support\Facades\DB::statement(
    'CREATE DATABASE IF NOT EXISTS fitapp_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
);

echo "fitapp_testing ready\n";
