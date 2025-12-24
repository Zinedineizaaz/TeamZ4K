<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController; // Penting: Import Controller Dashboard

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK (Bisa diakses siapa saja) ---
Route::get('/', function () {
    return view('pages.home');
});
Route::get('/about', function () {
    return view('pages.about');
});
Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/our-team', function () {
    return view('pages.team');
});
Route::get('/contact-us', function () {
    return view('pages.contact');
});
Route::get('/menu', [PageController::class, 'menu'])->name('pages.menu');

// --- 2. AUTHENTICATION ROUTES (Login, Register, Logout) ---
// Ini otomatis dibuat oleh Laravel UI
Auth::routes();

// --- 3. ADMIN GROUP (Wajib Login) ---
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // A. DASHBOARD (Admin & Police)
    // Menggunakan HomeController@index untuk mengirim data statistik (User, Produk, Stok)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // B. MANAJEMEN PRODUK (Admin & Police)
    // CRUD lengkap (Create, Read, Update, Delete)
    Route::resource('products', ProductController::class);

    // C. KHUSUS POLICE (SUPER ADMIN)
    // Rute di dalam sini HANYA bisa diakses oleh user dengan role 'superadmin'
    Route::middleware(['police'])->group(function () {
        
        Route::get('/users', function () { 
            // Ambil semua user, urutkan berdasarkan waktu login terbaru
            $admins = App\Models\User::orderBy('last_login_at', 'desc')->get();
            
            // Kirimkan data ke view admin/users.blade.php
            return view('admin.users', compact('admins')); 
        })->name('users');
        
    });
});

// --- 4. FALLBACK (Halaman 404 Custom) ---
Route::fallback(function () {
    return view('404'); 
});