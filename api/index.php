<?php

// 1. Muat Autoload Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi Aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Pindahkan Path Storage dan Cache ke /tmp (Writable)
$app->useStoragePath('/tmp/storage');

// Tambahkan baris ini untuk menangani error bootstrap/cache
$app->setBootstrapContainerPath('/tmp/bootstrap');

// 4. Buat folder yang diperlukan jika belum ada
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

// 5. Jalankan Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);