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
        // Pastikan API Key diambil dari config agar aman di Vercel
        $apiKey = config('services.xendit.secret_key');
        Configuration::setXenditKey($apiKey);
    }

    /**
     * Menampilkan riwayat pesanan user
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history', compact('orders'));
    }

    /**
     * Proses Checkout dan Pembuatan Invoice Xendit
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input Alamat
        $request->validate([
            'address' => 'required|string|min:10',
        ]);

        // 2. Ambil Item Keranjang
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $totalPrice = 0;
        $productDetails = [];

        // 3. Validasi Stok & Hitung Total
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Maaf, stok {$item->product->name} tidak mencukupi.");
            }
            $totalPrice += $item->product->price * $item->quantity;
            $productDetails[] = "{$item->product->name} ({$item->quantity})";
        }

        // ID unik untuk referensi Xendit & Database
        $externalId = 'DIMSAY-' . time() . '-' . $user->id;

        // 4. Siapkan Request Invoice Xendit
        $apiInstance = new InvoiceApi();
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount' => (double) $totalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembayaran Dimsaykuu: ' . implode(', ', $productDetails),
            'currency' => 'IDR',
            // Aktifkan semua metode pembayaran populer
            'payment_methods' => ['VIRTUAL_ACCOUNT', 'RETAIL_OUTLET', 'EWALLET', 'QRIS', 'DIRECT_DEBIT'],
            'success_redirect_url' => route('profile.history'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            // Panggil API Xendit
            $response = $apiInstance->createInvoice($createInvoice);

            // 5. Simpan ke Tabel Orders di TiDB Cloud
            DB::transaction(function () use ($user, $cartItems, $externalId, $response, $totalPrice, $request) {
                foreach ($cartItems as $item) {
                    Order::create([
                        'user_id' => $user->id,
                        'product_id' => $item->product_id,
                        'order_id_midtrans' => $externalId, // external_id Xendit
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price * $item->quantity,
                        'status' => 'PENDING',
                        'checkout_link' => $response['invoice_url'],
                        'address' => $request->address,
                    ]);
                }

                // 6. Kosongkan Keranjang setelah sukses buat invoice
                Cart::where('user_id', $user->id)->delete();
            });

            // Redirect ke halaman pembayaran Xendit
            return redirect($response['invoice_url']);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }
}