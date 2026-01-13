<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; // <--- TAMBAHKAN INI
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // <--- TAMBAHKAN INI UNTUK TRANSACTION

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $data = $request->all();
        Log::info('Xendit Webhook Received:', $data);

        $externalId = $data['external_id'];
        $order = Order::where('order_id_midtrans', $externalId)->first();

        if ($order) {
            $status = $data['status'];

            // Cek jika status lunas dan belum diproses sebelumnya
            if (($status === 'PAID' || $status === 'SETTLEMENT') && $order->status !== 'PAID') {

                // Gunakan Database Transaction agar data konsisten
                DB::transaction(function () use ($order) {
                    // 1. Update status pesanan jadi PAID
                    $order->update(['status' => 'PAID']);

                    // 2. LOGIKA KURANGI STOK:
                    // Cari produk berdasarkan ID yang tersimpan di pesanan
                    $product = Product::find($order->product_id);

                    if ($product) {
                        // Kurangi stok sesuai jumlah (quantity) pesanan
                        $product->decrement('stock', $order->quantity);
                        Log::info("Stok produk {$product->name} berhasil dikurangi sebanyak {$order->quantity}");
                    }
                });

                return response()->json(['message' => 'Status updated and stock decremented'], 200);
            }

            return response()->json(['message' => 'Order already processed'], 200);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
}