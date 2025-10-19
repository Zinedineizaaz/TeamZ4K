<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda mendaftarkan semua web routes.
|
*/

// Default route bawaan Laravel (menampilkan welcome.blade.php)
// Route::get('/', function () {
//     return view('welcome');
// });

// Redirect: jika akses "/start" maka diarahkan ke "/home"
Route::redirect('/start', '/home');

// Halaman utama
Route::get('/', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.home');
});

// Halaman About
Route::get('/about', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.about');
});

// Halaman Program
Route::get('/program', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.program'); // Pastikan Anda membuat file program.blade.php
});

// Halaman Our Team
Route::get('/our-team', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.team'); // Menggunakan nama file team.blade.php
});

// Halaman Contact Us
Route::get('/contact-us', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.contact'); // Pastikan Anda membuat file contact.blade.php
});

// Grouping contoh untuk halaman admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        // MEMANGGIL VIEW BARU DI FOLDER ADMIN
        return view('admin.dashboard'); // Pastikan Anda membuat admin/dashboard.blade.php
    });
    Route::get('/users', function () {
        // MEMANGGIL VIEW BARU DI FOLDER ADMIN
        return view('admin.users'); // Pastikan Anda membuat admin/users.blade.php
    });
});

// Fallback kalau route tidak ditemukan
Route::fallback(function () {
    // MEMANGGIL VIEW 404
    return view('404'); // Pastikan Anda membuat file 404.blade.php
});