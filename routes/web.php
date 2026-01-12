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
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\OrderController; // <--- TAMBAHAN: Import OrderController

/*
|--------------------------------------------------------------------------
| WEB ROUTES (FULL VERSION - FIXED)
|--------------------------------------------------------------------------
*/

// =====================
// 0. AUTHENTICATION GOOGLE
// =====================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// =====================
// 1. HALAMAN PUBLIK
// =====================
Route::get('/', fn () => view('pages.home'));
Route::get('/about', fn () => view('pages.about'));
Route::get('/our-team', fn () => view('pages.team'));
Route::get('/contact-us', fn () => view('pages.contact'));

// Halaman Program
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
// 4. GROUP USER BIASA (Harus Login)
// =====================
Route::middleware(['auth'])->group(function () {
    // A. Dashboard User
    Route::get('/home', fn () => view('home'))->name('home');
    
    // B. Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    // C. GAME TEBAK KLAKAT
    Route::post('/lucky-klakat/play', [GameController::class, 'play'])->name('game.play');
    Route::get('/lucky-klakat', [GameController::class, 'index'])->name('game.index');

    // D. SISTEM PESANAN & PEMBAYARAN (BARU)
    // Jalur untuk buat pesanan
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    
    // Jalur untuk buka halaman bayar
    Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('payment');
    
    // Jalur untuk proses verifikasi upload bukti
    Route::post('/payment/{id}/verify', [OrderController::class, 'pay'])->name('pay');
});


// =====================
// 5. GROUP ADMIN & POLICE (Dashboard & Manajemen)
// =====================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // A. Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // B. CRUD Produk (Staff & Police)
    Route::resource('products', ProductController::class);
    
    Route::get('/game-history', [AdminController::class, 'gameHistory'])->name('game.history');

    // C. Kelola User / Pelanggan (Staff & Police)
    Route::get('/manage-users', [AdminController::class, 'users'])->name('manage.users');
    Route::get('/manage-users/print', [AdminController::class, 'printUsers'])->name('users.print');

    // D. MENU KHUSUS POLICE / SUPERADMIN
    Route::middleware(['police'])->group(function () {
        Route::get('/users/trash', [AdminController::class, 'trashUsers'])->name('users.trash');
        Route::get('/users/restore/{id}', [AdminController::class, 'restoreUser'])->name('users.restore');
        Route::get('/manage-admins', [AdminController::class, 'listAdmins'])->name('manage.admins');
        Route::delete('/users/delete/{id}', [AdminController::class, 'destroyUser'])->name('users.delete');
    });

});


// =====================
// 6. FALLBACK (Halaman 404)
// =====================
Route::fallback(fn () => view('404'));