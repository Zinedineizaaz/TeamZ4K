<?php

namespace App\Http\Controllers;

use App\Models\Product; 
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * MENGATUR: Pengambilan data untuk halaman Program.
     * Memanfaatkan fitur ORM dan Data Collection.
     */
    public function program()
    {
        // Aksi 1 - ORM: Memuat seluruh data produk dari database.
        $all_products = Product::all();
        
        // Aksi 2 - Collection: Menyaring/memfilter produk berdasarkan status promo.
        $promo_products = $all_products->where('is_promo', true);
        
        // Aksi 3: Mengirim hasil Collection yang sudah difilter ke View.
        return view('pages.program', compact('promo_products'));
    }
}