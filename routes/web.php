<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;     // PENTING: Jangan lupa ini
use App\Http\Controllers\User\ProfileController; // PENTING: Jangan lupa ini
use App\Http\Controllers\Auth\LoginController;   // PENTING: Jangan lupa ini
use App\Http\Controllers\XenditController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES (FULL VERSION)
|--------------------------------------------------------------------------
*/

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
// Route ini ditaruh DI LUAR middleware 'auth' biar bisa diakses pas belum login
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
    
    // Halaman Home User setelah login
    Route::get('/home', fn () => view('home'))->name('home');

    // Halaman Edit Profile User
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// =====================
// 5. GROUP ADMIN & POLICE (Dashboard)
// =====================
// INI YANG HILANG TADI!! 👇👇
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // Dashboard Utama (Admin & Police)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // CRUD Produk (Admin & Police)
    Route::resource('products', ProductController::class);

    // Menu Khusus Police (Super Admin)
    Route::middleware(['police'])->group(function () {
        Route::get('/users', function () { 
            $admins = App\Models\User::orderBy('last_login_at', 'desc')->get();
            return view('admin.users', compact('admins')); 
        })->name('users');
    });
});

// Rute yang membutuhkan login (Auth)
Route::middleware(['auth'])->group(function () {
    
    // 1. Rute menampilkan Form Pemesanan
    Route::get('/order/form/{id}', [XenditController::class, 'showOrderForm'])->name('order.form');

    // 2. Rute memproses Checkout (Ini yang menyebabkan error 404 jika tidak ada)
    Route::post('/xendit/pay', [XenditController::class, 'checkout'])->name('xendit.pay');

    // 3. Rute Halaman Sukses
    Route::get('/order/status', function () {
        return view('pages.payment_success');
    })->name('payment.success');
});

// =====================
// 6. FALLBACK (Halaman 404)
// =====================
Route::fallback(fn () => view('404'));