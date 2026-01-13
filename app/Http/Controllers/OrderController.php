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

        $request->validate([
            'address' => 'required|string|min:10',
        ]);

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        // --- BAGIAN YANG TADI ERROR SUDAH DIPERBAIKI ---
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }
        // ----------------------------------------------

        $totalPrice = 0;
        $productDetails = [];

        // Validasi stok
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
            $totalPrice += $item->product->price * $item->quantity;
            $productDetails[] = "{$item->product->name} ({$item->quantity})";
        }

        $externalId = 'DIMSAY-' . time() . '-' . $user->id;

        // Siapkan Invoice Xendit
        $apiInstance = new InvoiceApi();
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount' => (double) $totalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembayaran Dimsaykuu: ' . implode(', ', $productDetails),
            'currency' => 'IDR',
            // payment_methods DIHAPUS agar semua opsi muncul
            'success_redirect_url' => route('profile.history'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            $response = $apiInstance->createInvoice($createInvoice);

            // Simpan ke database
            foreach ($cartItems as $item) {
                Order::create([
                    'user_id' => $user->id,
                    'order_id_midtrans' => $externalId,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price * $item->quantity,
                    'quantity' => $item->quantity,
                    'product_id' => $item->product_id,
                    'status' => 'PENDING',
                    'checkout_link' => $response['invoice_url']
                ]);
            }

            // Kosongkan keranjang
            Cart::where('user_id', $user->id)->delete();

            return redirect($response['invoice_url']);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }
// --- TAMBAHAN UNTUK TESTING MANUAL (SIMULASI) ---
    public function simulatePaymentSuccess($id)
    {
        // 1. Cari satu order buat dapet External ID-nya
        $order = Order::findOrFail($id);
        $external_id = $order->order_id_midtrans;

        // 2. Gunakan logic transaksi biar aman
        DB::transaction(function () use ($external_id) {
            // Ambil semua item dalam satu nota invoice ini
            $orders = Order::where('order_id_midtrans', $external_id)
                           ->where('status', 'PENDING') // Cuma yang belum bayar
                           ->get();

            foreach ($orders as $o) {
                // Update Status
                $o->update(['status' => 'PAID']);

                // Kurangi Stok Produk (Sama kayak logic webhook)
                $product = Product::find($o->product_id);
                if ($product) {
                    $product->decrement('stock', $o->quantity);
                }
            }
        });

        // 3. Balikin ke halaman history dengan pesan sukses
        return redirect()->route('profile.history')->with('success', 'Simulasi Pembayaran Berhasil! (Mode Test)');
    }
    public function handleWebhook(Request $request)
    {
        if ($request->header('x-callback-token') !== config('services.xendit.callback_token')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $external_id = $request->external_id;
        $status = strtoupper($request->status);

        if ($status === 'PAID' || $status === 'SETTLEMENT') {
            DB::transaction(function () use ($external_id) {
                $orders = Order::where('order_id_midtrans', $external_id)->where('status', 'PENDING')->get();

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

    public function showPayment($id)
    {
        // Cari pesanan berdasarkan ID milik user yang login
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        // Jika status sudah PAID, arahkan kembali ke riwayat agar tidak membayar dua kali
        if (in_array(strtoupper($order->status), ['PAID', 'SETTLEMENT', 'SUCCESS'])) {
            return redirect()->route('profile.history')->with('success', 'Pesanan ini sudah lunas!');
        }

        // Tampilkan view payment dengan data order
        return view('user.payment', compact('order'));
    }
}