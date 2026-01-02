<?php

// 1. Muat Autoload Composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Inisialisasi Aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Pindahkan Path Storage ke /tmp (Satu-satunya folder writable di Vercel)
$app->useStoragePath('/tmp/storage');

// 4. Jalankan Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$response->send();
$kernel->terminate($request, $response);