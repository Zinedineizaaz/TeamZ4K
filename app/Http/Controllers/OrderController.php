<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        // Menggunakan API Key dari config/services.php
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Validasi Input
        $request->validate([
            'address' => 'required|string|min:10', // Wajib diisi buat Invoice
        ]);

        // Ambil Keranjang
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $totalPrice = 0;
        $productDetails = [];

        // Validasi stok & Hitung Total
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
            $totalPrice += $item->product->price * $item->quantity;
            $productDetails[] = "{$item->product->name} ({$item->quantity})";
        }

        // Buat External ID Unik (Satu Invoice untuk banyak item)
        $externalId = 'DIMSAY-' . time() . '-' . $user->id;

        // Siapkan Invoice Xendit
        $apiInstance = new InvoiceApi();
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount' => (double) $totalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembayaran Dimsaykuu: ' . implode(', ', $productDetails),
            'currency' => 'IDR',
            'success_redirect_url' => route('profile.history'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            // Kirim Request ke Xendit
            $response = $apiInstance->createInvoice($createInvoice);

            // Simpan ke database (Looping per item keranjang)
            foreach ($cartItems as $item) {
                Order::create([
                    'user_id' => $user->id,
                    'order_id_midtrans' => $externalId, // ID Invoice Gabungan
                    'product_name' => $item->product->name,
                    'price' => $item->product->price * $item->quantity,
                    'quantity' => $item->quantity,
                    'product_id' => $item->product_id,
                    'status' => 'PENDING',
                    'checkout_link' => $response['invoice_url'],
                    'address' => $request->address, // <--- PENTING: Simpan Alamat
                ]);
            }

            // Kosongkan keranjang setelah order dibuat
            Cart::where('user_id', $user->id)->delete();

            // Redirect langsung ke halaman pembayaran Xendit
            return redirect($response['invoice_url']);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }

    // --- FITUR SIMULASI BAYAR (ACC MANUAL) ---
    // Bisa dipakai User (Test) atau Admin (Verifikasi Manual)
    public function simulatePaymentSuccess($id)
    {
        // 1. Cari satu order buat dapet External ID-nya
        $order = Order::findOrFail($id);
        $external_id = $order->order_id_midtrans;

        // 2. Gunakan logic transaksi biar aman
        DB::transaction(function () use ($external_id) {
            // Ambil semua item dalam satu nota invoice ini yang belum bayar
            $orders = Order::where('order_id_midtrans', $external_id)
                           ->where('status', 'PENDING')
                           ->get();

            foreach ($orders as $o) {
                // Update Status jadi PAID
                $o->update(['status' => 'PAID']);

                // Kurangi Stok Produk Real-time
                $product = Product::find($o->product_id);
                if ($product) {
                    $product->decrement('stock', $o->quantity);
                }
            }
        });

        // 3. PERBAIKAN: Gunakan back() agar fleksibel
        // Kalau Admin klik dari Dashboard -> Balik ke Dashboard
        // Kalau User klik dari History -> Balik ke History
        return back()->with('success', 'Pembayaran Berhasil Diverifikasi (ACC Manual)!');
    }

    // --- WEBHOOK XENDIT (Otomatis) ---
    public function handleWebhook(Request $request)
    {
        if ($request->header('x-callback-token') !== config('services.xendit.callback_token')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $external_id = $request->external_id;
        $status = strtoupper($request->status);

        if ($status === 'PAID' || $status === 'SETTLEMENT') {
            DB::transaction(function () use ($external_id) {
                $orders = Order::where('order_id_midtrans', $external_id)
                               ->where('status', 'PENDING')
                               ->get();

                foreach ($orders as $order) {
                    $order->update(['status' => 'PAID']);

                    $product = Product::find($order->product_id);
                    if ($product) {
                        $product->decrement('stock', $order->quantity);
                    }
                }
            });
        }

        return response()->json(['status' => 'OK']);
    }

    // --- HALAMAN DETAIL PEMBAYARAN (Opsional) ---
    public function showPayment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if (in_array(strtoupper($order->status), ['PAID', 'SETTLEMENT', 'SUCCESS'])) {
            return redirect()->route('profile.history')->with('success', 'Pesanan ini sudah lunas!');
        }

        return view('user.payment', compact('order'));
    }

    // --- HALAMAN INVOICE / NOTA DIGITAL ---
    public function showInvoice($id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        // Validasi Keamanan:
        // Invoice cuma boleh dilihat oleh: Pemilik Order, Admin, atau Police
        if ($order->user_id != $user->id && $user->role != 'admin' && $user->role != 'police') {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }

        // Tampilkan view invoice (resources/views/user/invoice.blade.php)
        return view('user.invoice', compact('order'));
    }
}