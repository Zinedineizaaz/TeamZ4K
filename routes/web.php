<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;

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
Route::get('/program', [PageController::class, 'program'])->name('program');

// Halaman Our Team
Route::get('/our-team', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.team');
});

// Halaman Contact Us
Route::get('/contact-us', function () {
    // MEMANGGIL VIEW BARU
    return view('pages.contact');
});

// Grouping contoh untuk halaman admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        // MEMANGGIL VIEW BARU DI FOLDER ADMIN
        return view('admin.dashboard'); // dashboard.blade.php
    });
    Route::get('/users', function () {
        // MEMANGGIL VIEW BARU DI FOLDER ADMIN
        return view('admin.users'); // users.blade.php
    });
});

// Grouping untuk halaman Admin (Produk CRUD)
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Route resource untuk Product CRUD (ProductController)
    Route::resource('products', ProductController::class); // <-- CRUD Lengkap
    
    // Route bawaan Anda yang sebelumnya
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); 
    })->name('dashboard'); 
    
    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');
});

// Fallback kalau route tidak ditemukan
Route::fallback(function () {
    // MEMANGGIL VIEW 404
    return view('404');
});