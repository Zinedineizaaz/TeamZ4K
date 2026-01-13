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
use App\Http\Controllers\OrderController;
use App\Http\Controllers\XenditWebhookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES (FINAL - STABLE & ROLE SAFE)
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

Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');

Route::get('/event-kuliner', [EventController::class, 'index'])->name('events.index');

// Callback Xendit (PUBLIC)
Route::post('/xendit/callback', [XenditWebhookController::class, 'handleCallback']);


// =====================
// 2. LOGIN ADMIN (KHUSUS ADMIN, TIDAK GANGGU USER)
// =====================
Route::prefix('admin')->group(function () {

    // Halaman login admin (HANYA jika admin BELUM login)
    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])
        ->middleware('guest:admin')
        ->name('admin.login');

    // Proses login admin
    Route::post('/login', [LoginController::class, 'loginAdmin'])
        ->middleware('guest:admin')
        ->name('admin.login.submit');
});


// =====================
// 3. AUTH USER BIASA (DEFAULT LARAVEL)
// =====================
Auth::routes();



// =====================
// 4. GROUP USER BIASA (LOGIN REQUIRED)
// =====================
Route::middleware(['auth'])->group(function () {

    // Dashboard User
    Route::get('/home', fn () => view('home'))->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    // Game
    Route::get('/lucky-klakat', [GameController::class, 'index'])->name('game.index');
    Route::post('/lucky-klakat/play', [GameController::class, 'play'])->name('game.play');

    // Checkout & Payment
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('payment');
    Route::post('/payment/{id}/verify', [OrderController::class, 'pay'])->name('pay');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');

    // Favorite
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});


// =====================
// 5. GROUP ADMIN (ADMIN & SUPERADMIN ONLY)
// =====================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'is_admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Export
        Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');

        // Produk
        Route::resource('products', ProductController::class);

        // Game History
        Route::get('/game-history', [AdminController::class, 'gameHistory'])->name('game.history');

        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/manage-users', [AdminController::class, 'users'])->name('manage.users');
        Route::get('/manage-users/print', [AdminController::class, 'printUsers'])->name('users.print');

        // =====================
        // 6. KHUSUS POLICE / SUPERADMIN
        // =====================
        Route::middleware(['police'])->group(function () {
            Route::get('/users/trash', [AdminController::class, 'trashUsers'])->name('users.trash');
            Route::get('/users/restore/{id}', [AdminController::class, 'restoreUser'])->name('users.restore');
            Route::get('/manage-admins', [AdminController::class, 'listAdmins'])->name('manage.admins');
            Route::delete('/users/delete/{id}', [AdminController::class, 'destroyUser'])->name('users.delete');
        });
    });


// =====================
// 7. FALLBACK (404)
// =====================
Route::fallback(fn () => view('404'));
