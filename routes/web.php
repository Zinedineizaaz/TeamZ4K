<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- DAFTAR CONTROLLER ---
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;        
use App\Http\Controllers\ProductController;      
use App\Http\Controllers\User\ProfileController; 
use App\Http\Controllers\Auth\LoginController;   
use App\Http\Controllers\Auth\GoogleController; // Jangan lupa import
/*
|--------------------------------------------------------------------------
| WEB ROUTES (FULL VERSION - FIXED DELETE)
|--------------------------------------------------------------------------
*/
// Route Login Google
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// =====================
// 1. HALAMAN PUBLIK
// =====================
Route::get('/', fn () => view('pages.home'));
Route::get('/about', fn () => view('pages.about'));
Route::get('/our-team', fn () => view('pages.team'));
Route::get('/contact-us', fn () => view('pages.contact'));
Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');


// =====================
// 2. KHUSUS LOGIN ADMIN
// =====================
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('admin.login.submit');


// =====================
// 3. AUTHENTICATION (Bawaan Laravel)
// =====================
Auth::routes();


// =====================
// 4. GROUP USER BIASA (Profile, Home)
// =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/home', fn () => view('home'))->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// =====================
// 5. GROUP ADMIN & POLICE (Dashboard & Manajemen)
// =====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // A. Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // B. CRUD Produk (Staff & Police)
    Route::resource('products', ProductController::class);

    // C. Kelola User / Pelanggan (Staff & Police)
    Route::get('/manage-users', [AdminController::class, 'listUsers'])->name('manage.users');

    // D. MENU KHUSUS POLICE / SUPERADMIN
    // Pastikan kamu punya middleware 'police' atau logic pengecekan role
    Route::middleware(['police'])->group(function () {
        
        // 1. Lihat daftar Admin lain
        Route::get('/manage-admins', [AdminController::class, 'listAdmins'])->name('manage.admins');
        
        // 2. HAPUS USER (INI YANG TADI HILANG/ERROR) 👇👇
        // Nama route ini akan menjadi 'admin.users.delete' karena ada prefix 'admin.' di atas
        Route::delete('/users/delete/{id}', [AdminController::class, 'destroyUser'])->name('users.delete');
        
    });

});


// =====================
// 6. FALLBACK (Halaman 404)
// =====================
Route::fallback(fn () => view('404'));