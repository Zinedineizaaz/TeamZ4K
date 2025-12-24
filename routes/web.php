<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman publik
Route::get('/', function () {
    return view('pages.home'); });
Route::get('/about', function () {
    return view('pages.about'); });
Route::get('/program', [PageController::class, 'program'])->name('program'); // Menggunakan Controller
Route::get('/our-team', function () {
    return view('pages.team'); });
Route::get('/contact-us', function () {
    return view('pages.contact'); });
Route::get('/menu', [PageController::class, 'menu'])->name('pages.menu');

// Admin Group (CRUD)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class); // CRUD

    Route::get('/dashboard', function () {
        return view('admin.dashboard'); })->name('dashboard');
    Route::get('/users', function () {
        return view('admin.users'); })->name('users');
});

Route::fallback(function () {
    return view('404'); });
Auth::routes();

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('products', App\Http\Controllers\ProductController::class);

    Route::get('/dashboard', function () {
        return view('admin.dashboard'); })->name('dashboard');
    Route::get('/users', function () {
        return view('admin.users'); })->name('users');
    Route::get('/users', function () { 
        // Ambil semua user, urutkan berdasarkan waktu login terbaru
        $admins = App\Models\User::orderBy('last_login_at', 'desc')->get();
        return view('admin.users', compact('admins')); // Kirimkan data ke view
    })->name('users');
});