<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
// Tambahkan baris Guzzle ini agar tidak error
use GuzzleHttp\Client;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout(Request $request) {
        // 1. Inisialisasi Konfigurasi Xendit
        $config = new Configuration();
        $config->setApiKey(config('services.xendit.secretKey'));

        // 2. SOLUSI FIX SSL LOCALHOST: Buat Client HTTP yang mematikan verifikasi SSL
        $httpClient = new Client([
            'verify' => false 
        ]);

        // 3. Masukkan Client dan Config ke dalam API Instance
        // Parameter pertama adalah client HTTP, kedua adalah config
        $apiInstance = new InvoiceApi($httpClient, $config);

        $externalId = 'DIMSAY-' . time() . '-' . auth()->id();
        $cleanPrice = (int) str_replace(['.', ','], '', $request->price);

        // 4. Simpan database
        $order = Order::create([
            'user_id'           => auth()->id(),
            'product_name'      => $request->product_name,
            'price'             => $cleanPrice,
            'status'            => 'pending',
            'order_id_midtrans' => $externalId,
        ]);

        // 5. Buat Request Invoice
        $create_invoice_request = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount' => $cleanPrice,
            'payer_email' => auth()->user()->email,
            'description' => 'Pembayaran Produk: ' . $request->product_name,
            'invoice_duration' => 86400,
            'currency' => 'IDR',
        ]);

        try {
            // 6. Eksekusi pembuatan invoice
            $result = $apiInstance->createInvoice($create_invoice_request);
            
            // 7. Ambil URL Invoice
            $invoiceUrl = $result->getInvoiceUrl();
            
            // 8. Update database dengan link pembayaran
            $order->update(['snap_token' => $invoiceUrl]);

            // 9. Arahkan ke halaman detail pembayaran (payment.blade.php)
            return redirect()->route('payment', $order->id);
            
        } catch (\Exception $e) {
            // Jika ada error, tampilkan pesan errornya
            return redirect()->route('menu')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function showPayment($id) {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('user.payment', compact('order'));
    }
}