<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;       // Model untuk menghitung Omzet
use App\Models\GameHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;   // Untuk query Grafik

class AdminController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA DENGAN ANALITIK KEUANGAN
     */
    public function index()
{
    // ... data produk & user tetap sama ...
    $total_products = Product::count();
    $total_stock = Product::sum('stock');
    $total_users = User::where('role', 'user')->count();
    $recent_logins = User::orderBy('last_login_at', 'desc')->take(5)->get();

    // --- DATA TRANSAKSI & OMSET ---
    $status_sukses = ['PAID', 'SETTLEMENT', 'SUCCESS'];
    $total_omset = Order::whereIn('status', $status_sukses)->sum('price');
    $pesanan_berhasil = Order::whereIn('status', $status_sukses)->count();
    $pesanan_pending = Order::where('status', 'PENDING')->count();

    // !!! PERBAIKAN: TAMBAHKAN BARIS INI !!!
    // Mengambil 10 transaksi terbaru untuk ditampilkan di tabel dashboard
    $recent_orders = Order::with('user')->orderBy('created_at', 'desc')->take(10)->get();

    // --- DATA GRAFIK PENJUALAN ---
    $sales_data = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(price) as total')
        )
        ->whereIn('status', $status_sukses)
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

    // Kirim ke View (Sekarang 'recent_orders' sudah ada datanya)
    return view('admin.dashboard', compact(
        'total_products', 
        'total_stock', 
        'total_users', 
        'recent_logins',
        'total_omset',
        'pesanan_berhasil',
        'pesanan_pending',
        'sales_data',
        'recent_orders' 
    ));
}
    /**
     * 2. RIWAYAT GAME
     */
    public function gameHistory()
    {
        $histories = GameHistory::with('user')->latest()->get();
        return view('admin.game.history', compact('histories'));
    }

    /**
     * 3. DAFTAR USER REGULAR (DENGAN SEARCH)
     */
    public function users(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10); 
        return view('admin.users_regular', compact('users'));
    }

    /**
     * 4. KELOLA TIM ADMIN (STAFF & POLICE)
     */
    public function listAdmins()
    {
        $admins = User::whereIn('role', ['superadmin', 'admin'])
                      ->orderBy('created_at', 'desc')
                      ->get();

        return view('admin.users_admin', compact('admins'));
    }

    /**
     * 5. CETAK DATA USER
     */
    public function printUsers()
    {
        $users = User::all();
        return view('admin.users_print', compact('users'));
    }

    /**
     * 6. LIST USER (TANPA PAGINASI)
     */
    public function listUsers()
    {
        $users = User::where('role', 'user')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.users_regular', compact('users'));
    }

    /**
     * 7. HAPUS USER (POLICY PROTECTED)
     */
    public function destroyUser($id)
    {
        $targetUser = User::findOrFail($id);

        if (Auth::user()->cannot('delete', $targetUser)) {
            return back()->with('error', 'AKSES DITOLAK: Kebijakan sistem melarang tindakan ini.');
        }

        $targetUser->delete();
        return back()->with('success', 'User berhasil dihapus sesuai Policy.');
    }

    /**
     * 8. LIHAT TEMPAT SAMPAH USER
     */
    public function trashUsers()
    {
        $deletedUsers = User::onlyTrashed()
                            ->where('role', 'user')
                            ->orderBy('deleted_at', 'desc')
                            ->get();

        return view('admin.users_trash', compact('deletedUsers'));
    }

    /**
     * 9. RESTORE USER
     */
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return back()->with('success', 'Data user ' . $user->name . ' berhasil dikembalikan.');
    }
}