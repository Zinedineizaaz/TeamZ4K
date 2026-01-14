<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Langsung upload ke Cloudinary
        if ($request->hasFile('image')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'dimsaykuu_products',
            ])->getSecurePath();

            $validated['image'] = $uploadedFileUrl;
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
            // Hapus gambar lama dari Cloudinary jika ada
            if ($product->image && str_contains($product->image, 'cloudinary')) {
                $publicId = 'dimsaykuu_products/' . pathinfo($product->image, PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            // Upload gambar baru
            $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'dimsaykuu_products',
            ])->getSecurePath();

            $validated['image'] = $uploadedFileUrl;
        } else {
            // Jika tidak upload gambar baru, biarkan gambar lama tetap ada
            unset($validated['image']);
        }

        $validated['is_promo'] = $request->has('is_promo');
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus aset dari Cloudinary saat data dihapus dari database TiDB
        if ($product->image && str_contains($product->image, 'cloudinary')) {
            $publicId = 'dimsaykuu_products/' . pathinfo($product->image, PATHINFO_FILENAME);
            Cloudinary::destroy($publicId);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}