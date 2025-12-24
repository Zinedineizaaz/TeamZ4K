<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        // Eloquent ORM: Ambil 3 produk terbaru
        $products = Product::latest()->take(3)->get();
        return view('pages.home', compact('products'));
    }

    public function menu()
    {
        // Eloquent ORM: Ambil semua produk
        $products = Product::all();
        return view('pages.menu', compact('products'));
    }

    public function program()
    {
        // Eloquent ORM: Ambil hanya produk yang sedang promo
        $promo_products = Product::where('is_promo', true)->get();
        return view('pages.program', compact('promo_products'));
    }

    public function about()
    {
        return view('pages.about');
    }
    public function team()
    {
        return view('pages.our-team');
    }
    public function contact()
    {
        return view('pages.contact-us');
    }
}