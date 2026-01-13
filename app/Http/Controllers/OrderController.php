<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; 
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use GuzzleHttp\Client;

class OrderController extends Controller
{
    public function __construct()
    {
        $apiKey = config('services.xendit.api_key') ?? env('XENDIT_API_KEY');
        Configuration::setXenditKey($apiKey);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Input Alamat
        $request->validate([
            'address' => 'required|string|min:10',
        ]);
        
        // 2. Ambil item keranjang beserta data produknya
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // 3. Hitung total harga dan buat daftar nama produk
        $totalPrice = 0;
        $productNames = [];

        foreach ($cartItems as $item) {
            $totalPrice += $item->product->price * $item->quantity;
            $productNames[] = $item->product->name . ' (' . $item->quantity . ')';
        }

        $allProductsString = implode(', ', $productNames);

        if ($totalPrice < 10000) {
            return back()->with('error', 'Minimal total pembayaran adalah Rp 10.000');
        }

        $externalId = 'DIMSAY-' . time() . '-' . $user->id;

        // Bypass SSL untuk Localhost
        $customClient = new Client(['verify' => false]);
        $apiInstance = new InvoiceApi($customClient);

        // 4. Siapkan data untuk Xendit
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount'      => (double)$totalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembayaran Keranjang Belanja Dimsaykuu - ' . $user->name,
            'customer' => [
                'given_names' => $user->name,
                'email' => $user->email,
                'addresses' => [
                    [
                        'country' => 'Indonesia',
                        'street_line1' => $request->address,
                    ]
                ]
            ],
            'invoice_duration' => 86400,
            'currency' => 'IDR',
            // Memastikan daftar metode muncul
            'payment_methods' => ['VIRTUAL_ACCOUNT', 'RETAIL_OUTLET', 'EWALLET', 'QRIS', 'DIRECT_DEBIT'],
            'success_redirect_url' => route('profile.history'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            $response = $apiInstance->createInvoice($createInvoice);

            // 5. SIMPAN KE TABEL ORDERS
            $order = Order::create([
                'user_id' => $user->id,
                'order_id_midtrans' => $externalId,
                'product_name' => $allProductsString, 
                'price' => $totalPrice,
                'status' => 'PENDING',
                'checkout_link' => $response['invoice_url'] // URL ini yang berisi metode pembayaran
            ]);

            // 6. Kosongkan keranjang
            Cart::where('user_id', $user->id)->delete();

            // OPSI A: Langsung arahkan ke Xendit (Rekomendasi agar metode langsung muncul)
            return redirect($response['invoice_url']);

            // OPSI B: Jika tetap ingin ke halaman detail dulu, gunakan baris di bawah dan hapus Opsi A
            // return redirect()->route('payment', $order->id);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }

    public function showPayment($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        if ($order->status === 'PAID') {
            return redirect()->route('profile.history')->with('success', 'Pesanan ini sudah lunas!');
        }
        return view('user.payment', compact('order'));
    }
}