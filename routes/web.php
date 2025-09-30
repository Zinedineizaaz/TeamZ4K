```php
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default route bawaan Laravel (menampilkan welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
});

// Redirect: jika akses "/" maka diarahkan ke "/home"
// (Note: karena sudah ada route "/" di atas, redirect ini bisa dihapus,
// atau kalau mau tetap, ubah "/" di atas ke "/welcome")
Route::redirect('/start', '/home');

// Halaman utama
Route::get('/home', function () {
    return "Selamat datang di Dimsaykuu - UMKM F&B penyedia dimsum lezat!";
});

// Halaman About
Route::get('/about', function () {
    return "Dimsaykuu adalah UMKM di bidang Food & Beverage yang berfokus pada penyediaan dimsum berkualitas dengan cita rasa autentik dan harga terjangkau. 
    Kami berkomitmen menghadirkan pengalaman kuliner yang menyenangkan dengan menu dimsum yang bervariasi, higienis, dan sesuai selera masyarakat Indonesia. 
    Visi kami adalah menjadi brand dimsum lokal yang dipercaya dan dicintai konsumen, sementara misi kami adalah menyediakan produk lezat, sehat, serta pelayanan ramah. 
    Dengan semangat tim yang solid, Dimsaykuu terus berinovasi untuk menjangkau lebih banyak pelanggan melalui promosi, kerjasama event kuliner, dan layanan pemesanan online maupun offline.";
});

// Halaman Program
Route::get('/program', function () {
    return "Program Dimsaykuu: Promo spesial, paket hemat, dan event kuliner.";
});

// Halaman Our Team
Route::get('/our-team', function () {
    return "Meet Our Team! :
    - Agus Saputra Hamzah (2310120018)
    - Khairan Noor Fadhlillah (2310120022)
    - Zinedine Daffa Izaaz (2310120014)";
});

// Halaman Contact Us
Route::get('/contact-us', function () {
    return "Hubungi (083136892742) Dimsaykuu untuk pemesanan atau informasi lebih lanjut!";
});

// Grouping contoh untuk halaman admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Admin Dashboard";
    });
    Route::get('/users', function () {
        return "Admin - Manage Users";
    });
});

// Fallback kalau route tidak ditemukan
Route::fallback(function () {
    return "404 - Page Not Found!";
});