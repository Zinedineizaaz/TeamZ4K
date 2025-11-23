<?php

namespace App\Http\Controllers;

use App\Models\Product; // Eloquent ORM
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Method untuk halaman Program
    public function program()
    {
        // Eloquent ORM: Mengambil semua data produk
        $all_products = Product::all();

        // Collection: Filter data hanya yang sedang promo (is_promo = true)
        $promo_products = $all_products->where('is_promo', true);
        
        return view('pages.program', [
            'promo_products' => $promo_products
        ]);
    }
}