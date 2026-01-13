<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    PageController, HomeController, AdminController, ProductController, 
    CartController, FavoriteController, OrderController, EventController, 
    GameController, XenditWebhookController
};
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES - 7 POIN UTAMA
|--------------------------------------------------------------------------
*/

// 1. PUBLIC & GOOGLE AUTH
Route::get('/', fn () => view('pages.home'));
Route::get('/about', fn () => view('pages.about'));
Route::get('/our-team', fn () => view('pages.team'));
Route::get('/contact-us', fn () => view('pages.contact'));
Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');
Route::get('/event-kuliner', [EventController::class, 'index'])->name('events.index');

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// 2. XENDIT CALLBACK (PUBLIC - DI LUAR AUTH)
Route::post('/xendit/callback', [XenditWebhookController::class, 'handleCallback']);

// 3. ADMIN LOGIN (KHUSUS FORM LOGIN STAFF)
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login')->middleware('guest');
Route::post('/admin/login', [LoginController::class, 'loginAdmin'])->name('admin.login.submit')->middleware('guest');

// 4. USER AUTH DEFAULT (LOGIN & REGISTER BIASA)
Auth::routes();

// 5. USER ACCESS (LOGIN REQUIRED)
Route::middleware(['auth'])->group(function () {
    // Profile & History
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    
    // Game
    Route::get('/lucky-klakat', [GameController::class, 'index'])->name('game.index');
    Route::post('/lucky-klakat/play', [GameController::class, 'play'])->name('game.play');

    // Checkout & Payment
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('payment');
    Route::post('/payment/{id}/simulate', [OrderController::class, 'simulatePaymentSuccess'])->name('payment.simulate');
    Route::get('/order/{id}/invoice', [OrderController::class, 'showInvoice'])->name('order.invoice');

    // Cart & Favorites
    Route::resource('cart', CartController::class);
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});

// 6. ADMIN & POLICE ACCESS
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    // Dashboard & Products
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');
    Route::get('/game-history', [AdminController::class, 'gameHistory'])->name('game.history');
    Route::get('/users', [AdminController::class, 'users'])->name('users');

    // Khusus Police / Superadmin
    Route::middleware(['police'])->group(function () {
        Route::get('/users/trash', [AdminController::class, 'trashUsers'])->name('users.trash');
        Route::get('/users/restore/{id}', [AdminController::class, 'restoreUser'])->name('users.restore');
        Route::get('/manage-admins', [AdminController::class, 'listAdmins'])->name('manage.admins');
        Route::delete('/users/delete/{id}', [AdminController::class, 'destroyUser'])->name('users.delete');
    });
});

// 7. FALLBACK (404)
Route::fallback(fn () => view('404'));