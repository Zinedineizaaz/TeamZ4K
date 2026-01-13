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
        // A. Data Statistik Dasar
        $total_products = Product::count();
        $total_stock = Product::sum('stock');
        $total_users = User::where('role', 'user')->count();
        $recent_logins = User::orderBy('last_login_at', 'desc')->take(5)->get();

        // B. Data Transaksi & Omset
        $status_sukses = ['PAID', 'SETTLEMENT', 'SUCCESS'];

        // BALIKIN KE 'price' (Sesuai Log Migrasi kamu)
        $total_omset = Order::whereIn('status', $status_sukses)->sum('price'); 
        
        $pesanan_berhasil = Order::whereIn('status', $status_sukses)->count();
        $pesanan_pending = Order::where('status', 'PENDING')->count();

        // Ambil 10 transaksi terbaru
        $recent_orders = Order::with('user')->orderBy('created_at', 'desc')->take(10)->get();

        // C. Data Grafik Penjualan (7 Hari Terakhir)
        $sales_data = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(price) as total') // BALIKIN KE 'price'
            )
            ->whereIn('status', $status_sukses)
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

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
        // PERBAIKAN 3: Tambahkan 'police' agar muncul di daftar admin
        $admins = User::whereIn('role', ['superadmin', 'admin', 'police'])
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

    /**
     * 10. EKSPOR DATA TRANSAKSI KE CSV/EXCEL
     */
    public function exportOrders()
    {
        // 1. Tentukan Nama File (Pake tanggal & jam biar unik)
        $fileName = 'laporan-transaksi-' . date('Y-m-d_H-i') . '.csv';

        // 2. Ambil Data dari Database
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();

        // 3. Header Browser (Biar otomatis download)
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // 4. JUDUL KOLOM EXCEL (Saya tambahin 'Alamat Pengiriman')
        $columns = array('ID Order', 'Nama Customer', 'Alamat Pengiriman', 'Menu', 'Harga (Rp)', 'Status', 'Tanggal Transaksi');

        // 5. Proses Penulisan Data
        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tulis Judul Kolom dulu paling atas
            fputcsv($file, $columns);

            // Looping isi data
            foreach ($orders as $order) {
                fputcsv($file, array(
                    // Kolom 1: ID Order (Pake external ID biar keren, atau $order->id juga boleh)
                    $order->order_id_midtrans, 

                    // Kolom 2: Nama Customer (Jaga-jaga kalo user udah diapus)
                    $order->user ? $order->user->name : 'Guest', 

                    // Kolom 3: ALAMAT (PENTING! Pake tanda ?? '-' biar gak error kalau kosong)
                    $order->address ?? '-', 

                    // Kolom 4: Menu
                    $order->product_name, 

                    // Kolom 5: Harga
                    $order->price, 

                    // Kolom 6: Status
                    $order->status, 

                    // Kolom 7: Tanggal
                    $order->created_at->format('Y-m-d H:i:s')
                ));
            }

            fclose($file);
        };

        // 6. Return Download
        return response()->stream($callback, 200, $headers);
    }
    
}