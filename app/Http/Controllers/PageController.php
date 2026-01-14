<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;      // Pastikan Model Product ada
use App\Models\GameHistory;  // Pastikan Model GameHistory ada (dari langkah sebelumnya)
use Carbon\Carbon;           // Untuk cek tanggal hari ini
use Illuminate\Support\Facades\Auth; // Untuk cek login

class PageController extends Controller
{
    public function home()
    {
        // Eloquent ORM: Ambil 3 produk terbaru
        $products = Product::latest()->take(3)->get();
        return view('pages.home', compact('products'));
    }

    public function menu()
    {
        // Eloquent ORM: Ambil semua produk
        $products = Product::all();
        return view('pages.menu', compact('products'));
    }

   public function program()
    {
        // 1. Ambil produk promo (Sesuaikan dengan logic lama kamu)
        // Kalau error 'Product not found', pastikan model Product sudah di-use di atas
        $promo_products = Product::where('is_promo', true)->get(); 
        // ATAU kalau kamu belum punya kolom is_promo, pakai: Product::all();

        // 2. LOGIKA GAME (INI YANG BIKIN ERROR HILANG)
        $alreadyPlayed = false; // Default anggap belum main

        if (Auth::check()) {
            // Cek ke database: Apakah user ini sudah main di tanggal hari ini?
            // Pastikan kamu sudah bikin Model GameHistory ya!
            // Kalau belum bikin Modelnya, hapus blok if ini dan biarkan $alreadyPlayed = false;
            $alreadyPlayed = GameHistory::where('user_id', Auth::id())
                                        ->whereDate('played_at', Carbon::today())
                                        ->exists();
        }

        // 3. Kirim data ke View (Perhatikan bagian compact)
        return view('pages.program', compact('promo_products', 'alreadyPlayed'));
    }

    public function about()
    {
        return view('pages.about');
    }
    public function team()
    {
        return view('pages.our-team');
    }
    public function contact()
    {
        return view('pages.contact-us');
    }
}