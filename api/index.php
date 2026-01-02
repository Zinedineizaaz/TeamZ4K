<?php

// Pindahkan folder storage dan cache ke /tmp agar writable
$app = require __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath('/tmp/storage');
$app->setBootstrapContainerPath('/tmp/bootstrap');

// Pastikan folder yang dibutuhkan ada
if (!is_dir('/tmp/storage/framework/views')) {
    mkdir('/tmp/storage/framework/views', 0755, true);
}

require __DIR__ . '/../public/index.php';