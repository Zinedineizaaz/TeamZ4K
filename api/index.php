<?php

// 1. Muat Autoload
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi Aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Konfigurasi Writable Path (Poin 3)
$app->useStoragePath('/tmp/storage');

// Pastikan direktori cache dan views ada di /tmp
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}
if (!is_dir('/tmp/storage/framework/cache')) {
    mkdir('/tmp/storage/framework/cache', 0755, true);
}
if (!is_dir('/tmp/storage/bootstrap/cache')) {
    mkdir('/tmp/storage/bootstrap/cache', 0755, true);
}

// 4. Jalankan Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);