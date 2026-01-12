<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Ambil data dari Xendit
        $data = $request->all();
        
        // Log data yang masuk (untuk debugging di storage/logs/laravel.log)
        Log::info('Xendit Webhook Received:', $data);

        // 2. Cari order berdasarkan external_id (DIMSAY-xxx)
        $externalId = $data['external_id'];
        $order = Order::where('order_id_midtrans', $externalId)->first();

        if ($order) {
            $status = $data['status'];

            if ($status === 'PAID' || $status === 'SETTLEMENT') {
                // Update status jadi PAID
                $order->update([
                    'status' => 'PAID'
                ]);
                
                return response()->json(['message' => 'Status updated to PAID'], 200);
            }
        }

        return response()->json(['message' => 'Order not found or status not PAID'], 404);
    }
}