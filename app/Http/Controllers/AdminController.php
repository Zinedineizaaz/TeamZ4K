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
        $targetUser = User::findOrFail($id);

        // --- CARA LAMA (MANUAL) ---
        // if (Auth::user()->role != 'superadmin') { ... }
        
        // --- CARA BARU (PAKAI POLICY) ---
        // Kita tanya ke Laravel: "Apakah user yg login CAN (BISA) delete targetUser?"
        if (Auth::user()->cannot('delete', $targetUser)) {
            return back()->with('error', 'AKSES DITOLAK: Kebijakan sistem melarang tindakan ini.');
        }

        // Kalau lolos pengecekan di atas, baru hapus
        $targetUser->delete();

        return back()->with('success', 'User berhasil dihapus sesuai Policy.');
    }

    /**
     * 5. HALAMAN SAMPAH (Lihat User yang Dihapus)
     */
    public function trashUsers()
    {
        // Ambil user yang sudah dihapus (onlyTrashed)
        // Dan pastikan cuma role 'user' yang diambil
        $deletedUsers = User::onlyTrashed()
                            ->where('role', 'user')
                            ->orderBy('deleted_at', 'desc')
                            ->get();

        return view('admin.users_trash', compact('deletedUsers'));
    }

    /**
     * 6. RESTORE USER (Balikin User)
     */
    public function restoreUser($id)
    {
        // Cari user di tong sampah (withTrashed)
        $user = User::withTrashed()->findOrFail($id);

        // Balikin dia!
        $user->restore();

        return back()->with('success', 'Data user ' . $user->name . ' berhasil dikembalikan (Restore).');
    }
}