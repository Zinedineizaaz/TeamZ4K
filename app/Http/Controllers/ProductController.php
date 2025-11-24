<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // READ (Admin Index)
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // CREATE (Form)
    public function create()
    {
        return view('admin.products.create');
    }

    // CREATE (Store Logic)
    public function store(Request $request)
    {
        // Form Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        // Proses Upload Gambar ke public/images
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName); 
            $validated['image'] = $fileName;
        } else {
            $validated['image'] = null;
        }
        
        $validated['is_promo'] = $request->has('is_promo');
        Product::create($validated); // Eloquent ORM (Create)

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE (Form)
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // UPDATE (Store Logic)
    public function update(Request $request, Product $product)
    {
        // Form Validation
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name,'.$product->id, 
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);
        
        // Proses Upload Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari public/images
            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }
            
            // Simpan gambar baru
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            
            $validated['image'] = $fileName;
        } else {
            unset($validated['image']); // Pertahankan nilai gambar lama
        }
        
        $validated['is_promo'] = $request->has('is_promo'); 
        $product->update($validated); // Eloquent ORM (Update)

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Product $product)
    {
        // Hapus file gambar dari public/images
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete(); // Eloquent ORM (Delete)
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}