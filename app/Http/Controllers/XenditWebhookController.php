<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class XenditWebhookController extends Controller
{
    public function __construct()
    {
        Configuration::setDefaultConfiguration(
            Configuration::getDefaultConfiguration()
                ->setApiKey(env('XENDIT_API_KEY'))
        );
    }

    // FUNGSI BARU: Menampilkan Form Pemesanan
    public function showOrderForm($id)
    {
        $product = Product::findOrFail($id);
        return view('user.cart', compact('product'));
    }

    // FUNGSI UPDATE: Checkout dengan Pengurangan Stok
    public function checkout(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // 1. Validasi Stok di TiDB Cloud
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Maaf, stok ' . $product->name . ' tidak mencukupi.');
        }

        $total_harga = $product->price * $request->quantity;
        $external_id = 'ORD-' . time();

        // 2. Simpan Data Pesanan ke TiDB Cloud
        $order = Order::create([
            'external_id' => $external_id,
            'user_id' => auth()->id(),
            'amount' => $total_harga,
            'status' => 'PENDING'
        ]);

        // 3. LOGIKA BARU: Kurangi Stok Produk
        $product->decrement('stock', $request->quantity);

        // 4. Buat Invoice Xendit
        $apiInstance = new InvoiceApi();
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'amount' => (double) $total_harga,
            'payer_email' => auth()->user()->email,
            'description' => "Pembelian {$request->quantity}x {$product->name}",
            'success_redirect_url' => route('payment.success'),
        ]);

        try {
            $result = $apiInstance->createInvoice($createInvoice);
            $order->update(['checkout_link' => $result['invoice_url']]);

            return redirect($result['invoice_url']);
        } catch (\Exception $e) {
            // Jika gagal, kembalikan stok (Rollback)
            $product->increment('stock', $request->quantity);
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // FUNGSI BARU: Webhook untuk update status otomatis
    public function handleWebhook(Request $request)
    {
        if ($request->header('x-callback-token') !== env('XENDIT_CALLBACK_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order = Order::where('external_id', $request->external_id)->first();
        if ($order && $request->status === 'PAID') {
            $order->update(['status' => 'PAID']);
        }

        return response()->json(['status' => 'OK']);
    }
}