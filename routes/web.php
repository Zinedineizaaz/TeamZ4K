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
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\XenditWebhookController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES (FULL VERSION - MERGED)
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
Route::get('/', fn() => view('pages.home'));
Route::get('/about', fn() => view('pages.about'));
Route::get('/our-team', fn() => view('pages.team'));
Route::get('/contact-us', fn() => view('pages.contact'));

// Halaman Program & Menu
Route::get('/program', [PageController::class, 'program'])->name('program');
Route::get('/menu', [PageController::class, 'menu'])->name('menu');

// HALAMAN EVENT KULINER
Route::get('/event-kuliner', [EventController::class, 'index'])->name('events.index');

// Rute Xendit Callback (Di luar auth middleware)
// Route::post('/xendit/callback', [XenditWebhookController::class, 'handleCallback']);

// =====================
// 2. KHUSUS LOGIN ADMIN
// =====================
// PERBAIKAN: Ditambahkan middleware('guest') agar yang sudah login tidak bisa akses
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])
    ->name('admin.login')
    ->middleware('guest');

Route::post('/admin/login', [LoginController::class, 'loginAdmin'])
    ->name('admin.login.submit')
    ->middleware('guest');


// =====================
// 3. AUTHENTICATION (Bawaan Laravel)
// =====================
Auth::routes();


// =====================
// 4. GROUP USER BIASA (Harus Login)
// =====================
Route::middleware(['auth'])->group(function () {
    // A. Dashboard User
    Route::get('/home', fn() => view('home'))->name('home');

    // B. Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');

    // C. GAME TEBAK KLAKAT
    Route::post('/lucky-klakat/play', [GameController::class, 'play'])->name('game.play');
    Route::get('/lucky-klakat', [GameController::class, 'index'])->name('game.index');

    // D. SISTEM PESANAN & PEMBAYARAN (XENDIT INTEGRATED)
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // Jalur untuk buka halaman bayar
    Route::get('/payment/{id}', [OrderController::class, 'showPayment'])->name('payment');

    // Jalur untuk proses verifikasi upload bukti (Manual Verify)
    Route::post('/payment/{id}/verify', [OrderController::class, 'pay'])->name('pay');

    // E. KERANJANG BELANJA (CART)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');

    // F. MENU FAVORIT (WISHLIST)
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});


// =====================
// 5. GROUP ADMIN & POLICE
// =====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/users', [AdminController::class, 'users'])->name('users');

    // A. Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/orders/export', [AdminController::class, 'exportOrders'])->name('orders.export');

    // B. CRUD Produk (Staff & Police)
    Route::resource('products', ProductController::class);

    Route::get('/game-history', [AdminController::class, 'gameHistory'])->name('game.history');

    // C. Kelola User / Pelanggan
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

// Rute yang membutuhkan login (Auth) - Tambahan Payment Xendit & Simulate
Route::middleware(['auth'])->group(function () {
    // Route Simulasi Pembayaran (Cheat)
    Route::post('/payment/{id}/simulate', [OrderController::class, 'simulatePaymentSuccess'])->name('payment.simulate');
    Route::get('/order/{id}/invoice', [OrderController::class, 'showInvoice'])->name('order.invoice');
    // 1. Rute menampilkan Form Pemesanan
    Route::get('/order/form/{id}', [XenditWebhookController::class, 'showOrderForm'])->name('order.form');

    // 2. Rute memproses Checkout
    Route::post('/xendit/pay', [XenditWebhookController::class, 'checkout'])->name('xendit.pay');

    // 3. Rute Halaman Sukses
    Route::get('/order/status', function () {
        return view('pages.payment_success');
    })->name('payment.success');
});

// =====================
// 6. FALLBACK (Halaman 404)
// =====================
Route::fallback(fn() => view('404'));