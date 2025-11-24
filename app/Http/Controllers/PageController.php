<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Menampilkan produk yang sedang promo di halaman Program.
     * Menggunakan Eloquent ORM dan Collection.
     */
    public function program()
    {
        // Eloquent ORM: Mengambil semua data
        $all_products = Product::all();
        
        // Collection: Filter data hanya yang sedang promo (is_promo = true)
        $promo_products = $all_products->where('is_promo', true);
        
        return view('pages.program', compact('promo_products'));
    }
}