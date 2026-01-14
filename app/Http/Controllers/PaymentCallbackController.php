<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; // Tambahkan ini buat kurangi stok
use Illuminate\Support\Facades\Log; // Buat cek error di Vercel
use Illuminate\Support\Facades\DB;  // Buat transaksi database aman

class PaymentCallbackController extends Controller
{
    public function handleCallback(Request $request)
    {
        // 1. Ambil Token Header
        $incomingToken = $request->header('x-callback-token');
        
        // 2. Ambil Token Server (Pakai config agar aman di Vercel)
        $serverToken = config('services.xendit.callback_token');

        // Cek Validasi
        if ($incomingToken !== $serverToken) {
            return response()->json(['message' => 'Token Salah Bro! Akses Ditolak.'], 403);
        }

        // 3. Ambil Data Transaksi
        $data = $request->all();
        
        // Log untuk debugging (bisa dicek di Vercel Logs)
        Log::info('Xendit Callback Masuk:', $data);

        // 4. Proses jika status PAID / SETTLEMENT
        $status = $data['status'] ?? '';
        $external_id = $data['external_id'] ?? null;

        if ($status == 'PAID' || $status == 'SETTLEMENT') {
            
            // Cari Order berdasarkan External ID
            $order = Order::where('external_id', $external_id)->first(); // Sesuaikan nama kolom di DB kamu

            if ($order && $order->status != 'PAID') {
                
                // PENTING: Pakai DB Transaction biar data gak rusak
                DB::transaction(function () use ($order) {
                    // A. Update Status Order
                    $order->update(['status' => 'PAID']);

                    // B. Kurangi Stok Produk (Opsional tapi disarankan)
                    // Asumsi: Logic checkout kamu tadi single product
                    // Jika kamu punya relasi order->items, sesuaikan logic ini
                     if ($order->product_id) { // Pastikan kolom product_id ada di tabel orders
                        $product = Product::find($order->product_id);
                        if ($product) {
                            $product->decrement('stock', $order->quantity ?? 1);
                        }
                    }
                });

                return response()->json(['message' => 'Alhamdulillah Lunas! Stok berkurang.']);
            }
        } elseif ($status == 'EXPIRED') {
            $order = Order::where('external_id', $external_id)->first();
            if ($order) {
                $order->update(['status' => 'EXPIRED']);
            }
        }

        return response()->json(['message' => 'Callback Diterima']);
    }
}