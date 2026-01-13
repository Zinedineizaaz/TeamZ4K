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
        // Mengambil token dari config yang merujuk ke .env Vercel
        $callbackToken = config('services.xendit.callback_token');
        $headerToken = $request->header('x-callback-token');

        // Validasi keamanan: Pastikan ini benar-benar dari Xendit
        if ($callbackToken !== $headerToken) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->all();
        $externalId = $data['external_id'];
        $order = Order::where('order_id_midtrans', $externalId)->first();

        if ($order && ($data['status'] === 'PAID' || $data['status'] === 'SETTLEMENT')) {
            DB::transaction(function () use ($order) {
                $order->update(['status' => 'PAID']);

                // Pengurangan stok di database TiDB
                $product = Product::find($order->product_id);
                if ($product) {
                    $product->decrement('stock', $order->quantity);
                }
            });
            return response()->json(['message' => 'Stock updated'], 200);
        }

        return response()->json(['message' => 'Order not found'], 404);
    }
}