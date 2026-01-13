<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage; // Gunakan Storage untuk fleksibilitas
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            // SOLUSI VERCEL: Hanya simpan ke public_path jika di lingkungan lokal
            if (config('app.env') === 'local') {
                $file->move(public_path('products'), $fileName);
                $validated['image'] = $fileName;
            } else {
                // Di Vercel (Production), kita gunakan URL placeholder agar tidak error
                $validated['image'] = 'https://via.placeholder.com/150';
            }
        }

        $validated['is_promo'] = $request->has('is_promo');
        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

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
            // Hapus lama hanya jika di lokal
            if (config('app.env') === 'local' && $product->image && file_exists(public_path('products/' . $product->image))) {
                unlink(public_path('products/' . $product->image));
            }

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            if (config('app.env') === 'local') {
                $file->move(public_path('products'), $fileName);
                $validated['image'] = $fileName;
            } else {
                $validated['image'] = 'https://via.placeholder.com/150';
            }
        } else {
            unset($validated['image']);
        }

        $validated['is_promo'] = $request->has('is_promo');
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        if (config('app.env') === 'local' && $product->image && !str_starts_with($product->image, 'http') && file_exists(public_path('products/' . $product->image))) {
            unlink(public_path('products/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dimusnahkan oleh Police!');
    }
}