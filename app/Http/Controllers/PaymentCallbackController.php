<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Sesuaikan nama model pesanan lu
use Illuminate\Support\Facades\Response;

class PaymentCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        // 1. Ambil Token Callback dari Xendit yang dikirim di Header
        $xenditXCallbackToken = $request->header('x-callback-token');

        // 2. Cek apakah Tokennya Valid (Sesuai yang di .env lu)
        // Token: KksM6rLSY3YaBLh2ZYymXKQ15q23Uq3RJYgotlhUiYMKz6iJ
        if ($xenditXCallbackToken != env('XENDIT_CALLBACK_TOKEN')) {
            return response()->json(['message' => 'Token Salah Bro!'], 403);
        }

        // 3. Ambil Data Transaksi
        $data = $request->all();
        
        // Pastikan ini notifikasi pembayaran sukses (bukan expired/created)
        if (isset($data['status']) && $data['status'] == 'PAID') {
            
            // Cari Order berdasarkan External ID (biasanya ID Pesanan lu)
            $external_id = $data['external_id']; 
            $order = Order::where('order_id_midtrans', $external_id)->first(); // Sesuaikan nama kolom ID

            if ($order) {
                // UPDATE STATUS JADI SUCCESS
                $order->update([
                    'status' => 'SUCCESS', // atau 'PAID'
                ]);
            }
        }

        return response()->json(['message' => 'Callback Berhasil!']);
    }
}