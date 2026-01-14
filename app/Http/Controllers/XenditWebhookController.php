<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class XenditWebhookController extends Controller
{
    public function __construct()
    {
        // INISIALISASI API KEY YANG AMAN UNTUK VERCEL
        Configuration::setDefaultConfiguration(
            Configuration::getDefaultConfiguration()
                ->setApiKey(config('services.xendit.secret_key'))
        );
    }

    // FUNGSI CHECKOUT (Dipanggil saat user klik "Bayar Sekarang")
    public function checkout(Request $request)
    {
        // ... (Validasi input, dll) ...
        
        $external_id = 'ORD-' . time();
        $user = auth()->user();

        // 1. Buat Order di Database (Status PENDING)
        $order = Order::create([
            'external_id' => $external_id,
            'user_id' => $user->id,
            'amount' => $request->total_price,
            'status' => 'PENDING',
            'description' => $request->address,
            // Simpan product_id & quantity jika ingin pengurangan stok otomatis di callback nanti
            'product_id' => $request->product_id ?? null, 
            'quantity' => $request->quantity ?? 1
        ]);

        // 2. Buat Invoice ke Xendit
        $apiInstance = new InvoiceApi();
        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $external_id,
            'amount' => (double) $request->total_price,
            'payer_email' => $user->email,
            'description' => "Pembayaran Order #{$external_id}",
            'success_redirect_url' => route('payment.success'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            $result = $apiInstance->createInvoice($createInvoice);
            $order->update(['checkout_link' => $result['invoice_url']]);
            
            return redirect($result['invoice_url']);

        } catch (\Exception $e) {
            $order->delete();
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }
}