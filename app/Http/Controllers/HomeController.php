<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\User;    // Import Model User

class HomeController extends Controller
{
    /**
     * Memastikan hanya user login yang bisa akses.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman Dashboard dengan Statistik.
     */
    public function index()
    {
        // 1. DATA UNTUK SEMUA ADMIN (Staff & Police)
        $stats = [
            'total_products' => Product::count(),      // Hitung jumlah produk
            'total_stock'    => Product::sum('stock'), // Hitung total stok tersedia
        ];

        // 2. DATA KHUSUS POLICE (SUPER ADMIN)
        // Kita siapkan variabel kosong dulu agar tidak error di Admin Biasa
        $police_data = [
            'total_users'   => 0,
            'recent_logins' => []
        ];

        // Jika yang login adalah Super Admin, baru kita isi datanya
        if (auth()->user()->role == 'superadmin') {
            $police_data['total_users']   = User::count();
            $police_data['recent_logins'] = User::orderBy('last_login_at', 'desc')->take(5)->get();
        }

        // Gabungkan semua data dan kirim ke View
        return view('admin.dashboard', array_merge($stats, $police_data));
    }
}