<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Tampilkan menu favorit user
    public function index()
    {
        $favorites = Favorite::with('product')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.favorites', compact('favorites'));
    }

    // Toggle Favorite (Tambah jika belum ada, hapus jika sudah ada)
    public function toggle($productId)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('info', 'Dihapus dari menu favorit.');
        }

        Favorite::create([
            'user_id' => Auth::id(),
            'product_id' => $productId
        ]);

        return back()->with('success', 'Ditambahkan ke menu favorit!');
    }
}