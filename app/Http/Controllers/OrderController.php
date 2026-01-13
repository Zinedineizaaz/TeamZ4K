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
use GuzzleHttp\Client; // Wajib ditambahkan

class OrderController extends Controller
{
    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.secret_key'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'required|string|min:10',
        ]);

        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $totalPrice = 0;
        $productDetails = [];

        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
            $totalPrice += $item->product->price * $item->quantity;
            $productDetails[] = "{$item->product->name} ({$item->quantity})";
        }

        $externalId = 'DIMSAY-' . time() . '-' . $user->id;

        // --- SOLUSI BYPASS SSL VIA .ENV ---
        $verifySsl = env('XENDIT_SSL_VERIFY', true); 
        $customClient = new Client(['verify' => $verifySsl]);
        $apiInstance = new InvoiceApi($customClient);
        // ----------------------------------

        $createInvoice = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'amount' => (double) $totalPrice,
            'payer_email' => $user->email,
            'description' => 'Pembayaran Dimsaykuu: ' . implode(', ', $productDetails),
            'currency' => 'IDR',
            'success_redirect_url' => route('profile.history'),
            'failure_redirect_url' => route('cart.index'),
        ]);

        try {
            $response = $apiInstance->createInvoice($createInvoice);

            foreach ($cartItems as $item) {
                Order::create([
                    'user_id' => $user->id,
                    'order_id_midtrans' => $externalId,
                    'product_name' => $item->product->name,
                    'price' => $item->product->price * $item->quantity,
                    'quantity' => $item->quantity,
                    'product_id' => $item->product_id,
                    'status' => 'PENDING',
                    'checkout_link' => $response['invoice_url']
                ]);
            }

            Cart::where('user_id', $user->id)->delete();

            return redirect($response['invoice_url']);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal terhubung ke Xendit: ' . $e->getMessage());
        }
    }

    public function handleWebhook(Request $request)
    {
        if ($request->header('x-callback-token') !== config('services.xendit.callback_token')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $external_id = $request->external_id;
        $status = strtoupper($request->status);

        if ($status === 'PAID' || $status === 'SETTLEMENT') {
            DB::transaction(function () use ($external_id) {
                $orders = Order::where('order_id_midtrans', $external_id)->where('status', 'PENDING')->get();

                foreach ($orders as $order) {
                    $order->update(['status' => 'PAID']);

                    $product = Product::find($order->product_id);
                    if ($product) {
                        $product->decrement('stock', $order->quantity);
                    }
                }
            });
        }

        return response()->json(['status' => 'OK']);
    }
}