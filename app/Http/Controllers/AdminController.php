<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;       // PENTING: Import Model User
use App\Models\Product;    // PENTING: Import Model Product (Asumsi nama modelnya Product)
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA
     * Logika untuk mengirim data ke halaman Dashboard yang kamu kirim tadi.
     */
    public function index()
    {
        // Hitung total produk (Pastikan kamu punya Model Product)
        // Kalau belum punya model Product, hapus baris ini dan ganti jadi 0 dulu
        $total_products = Product::count();
        $total_stock = Product::sum('stock'); // Asumsi kolom stok namanya 'stock'

        // Hitung total user biasa (bukan admin)
        $total_users = User::where('role', 'user')->count();

        // Ambil 5 user yang login terakhir untuk tabel "Monitoring"
        $recent_logins = User::orderBy('last_login_at', 'desc')->take(5)->get();

        // Kirim semua variabel ini ke View 'admin.dashboard'
        return view('admin.dashboard', compact(
            'total_products', 
            'total_stock', 
            'total_users', 
            'recent_logins'
        ));
    }

    /**
     * 2. HALAMAN KELOLA TIM ADMIN (Internal)
     * Hanya menampilkan Superadmin (Police) dan Admin (Staff)
     */
    public function listAdmins()
    {
        // Ambil user yang role-nya BUKAN user biasa
        $admins = User::whereIn('role', ['superadmin', 'admin'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('admin.users_admin', compact('admins'));
    }

    /**
     * 3. HALAMAN KELOLA USER (Pelanggan)
     * Hanya menampilkan User biasa
     */
    public function listUsers()
    {
        // Ambil user yang role-nya CUMA 'user'
        $users = User::where('role', 'user')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.users_regular', compact('users'));
    }
    /**
     * 4. HAPUS USER (Khusus Police)
     */
    public function destroyUser($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Cek keamanan: Jangan sampai Police menghapus dirinya sendiri
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // Cek keamanan: Jangan hapus sesama admin lewat menu ini
        if ($user->role != 'user') {
            return back()->with('error', 'Hanya User biasa yang boleh dihapus dari sini!');
        }

        // Lakukan penghapusan
        $user->delete();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'User ' . $user->name . ' berhasil dihapus dari sistem.');
    }
}