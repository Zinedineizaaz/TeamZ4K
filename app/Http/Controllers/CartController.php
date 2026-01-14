<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart', compact('cartItems', 'totalPrice'));
    }

    // Tambah produk ke keranjang
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        // Cek stok
        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk sedang habis!');
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambah jumlahnya
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang!');
    }

    // Update jumlah (Quantity) di halaman keranjang
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $cartItem->product->stock
        ]);

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah berhasil diperbarui!');
    }

    // Hapus satu item dari keranjang
    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}