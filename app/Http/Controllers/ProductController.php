<?php

namespace App\Http\Controllers;

use App\Models\Product; // Menggunakan Model Eloquent
use Illuminate\Http\Request; // Untuk Form Processing dan Validasi

class ProductController extends Controller
{
    /**
     * READ: Menampilkan daftar semua produk (Index).
     * Menggunakan Collection.
     */
    public function index()
    {
        // Eloquent ORM: Mengambil semua data dari tabel products
        $products = Product::all();
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * CREATE: Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * CREATE: Menyimpan produk baru ke database.
     * Menggunakan Form Validation.
     */
    public function store(Request $request)
    {
        // Form Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
        ]);
        
        // Memproses checkbox is_promo
        $validated['is_promo'] = $request->has('is_promo'); // Akan menjadi true/false

        // Eloquent ORM: Menyimpan data (Create)
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * UPDATE: Menampilkan form untuk mengedit produk tertentu.
     * Menggunakan Route Model Binding ($product).
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * UPDATE: Menyimpan perubahan produk ke database.
     * Menggunakan Form Validation.
     */
    public function update(Request $request, Product $product)
    {
        // Form Validation
        $validated = $request->validate([
            // Unique, tetapi abaikan ID produk yang sedang diedit
            'name' => 'required|string|max:100|unique:products,name,'.$product->id, 
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|max:255',
        ]);
        
        // Memproses checkbox is_promo
        $validated['is_promo'] = $request->has('is_promo'); 

        // Eloquent ORM: Memperbarui data (Update)
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus produk dari database.
     * Menggunakan Route Model Binding ($product).
     */
    public function destroy(Product $product)
    {
        // Eloquent ORM: Menghapus data (Delete)
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}