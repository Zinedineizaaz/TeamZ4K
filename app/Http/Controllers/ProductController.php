<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses Upload Gambar ke public/products
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // Pindahkan ke folder public/products
            $file->move(public_path('products'), $fileName);
            $validated['image'] = $fileName;
        } else {
            $validated['image'] = null;
        }

        $validated['is_promo'] = $request->has('is_promo');
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE (Form)
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact($product));
    }

    // UPDATE (Store Logic)
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // HAPUS gambar lama jika ada di public/products
            if ($product->image && file_exists(public_path('products/' . $product->image))) {
                unlink(public_path('products/' . $product->image));
            }

            // Simpan gambar baru ke public/products
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $fileName);

            $validated['image'] = $fileName;
        } else {
            // Jika tidak upload gambar baru, biarkan gambar yang lama
            $validated['image'] = $product->image;
        }

        $validated['is_promo'] = $request->has('is_promo');
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Product $product)
    {
        // Hapus file gambar dari public/products sebelum data dihapus
        if ($product->image && file_exists(public_path('products/' . $product->image))) {
            unlink(public_path('products/' . $product->image));
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}