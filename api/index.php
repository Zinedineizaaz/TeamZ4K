<?php

// 1. Panggil autoload dari Composer [Wajib]
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Konfigurasi folder writable di Vercel
$app->useStoragePath('/tmp/storage');

// Pastikan folder untuk view cache tersedia
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

// 4. Jalankan aplikasi melalui Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);