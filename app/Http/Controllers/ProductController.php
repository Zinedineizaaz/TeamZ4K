<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Pastikan ini ada untuk manipulasi file

class ProductController extends Controller
{
    /**
     * Memastikan hanya user yang login yang bisa akses controller ini.
     * (Opsional, karena sudah dihandle di route, tapi bagus untuk double protection)
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        // Cek checkbox promo
        $validated['is_promo'] = $request->has('is_promo');
        
        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE (Form)
    public function edit(Product $product)
    {
        // PERBAIKAN: compact('product') pakai tanda kutip, bukan $product
        return view('admin.products.edit', compact('product'));
    }

    // UPDATE (Store Logic)
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            // Tambahkan .$product->id agar tidak error "nama sudah ada" saat update diri sendiri
            'name' => 'required|string|max:100|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|integer|min:1000',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // HAPUS gambar lama jika ada
            if ($product->image && file_exists(public_path('products/' . $product->image))) {
                unlink(public_path('products/' . $product->image));
            }

            // Simpan gambar baru
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $fileName);

            $validated['image'] = $fileName;
        } else {
            // Jika tidak upload, pertahankan gambar lama
            // Hapus baris ini: $validated['image'] = $product->image; 
            // Cukup unset agar tidak menimpa data lama dengan null (optional, tapi cara di bawah aman)
             unset($validated['image']);
        }

        $validated['is_promo'] = $request->has('is_promo');
        
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    // DELETE (INI BAGIAN KRUSIAL POLICE)
    
   public function destroy(Product $product)
{
    // --- PANGGIL POLICY (GANTINYA IF MANUAL) ---
    // Baris ini otomatis mengecek file 'ProductPolicy.php' fungsi 'delete'.
    // Kalau user bukan Superadmin, otomatis STOP dan lari ke Halaman Gembok (403).
    $this->authorize('delete', $product);
    // -------------------------------------------

    // Hapus file gambar jika ada
    if ($product->image && !str_starts_with($product->image, 'http') && file_exists(public_path('products/' . $product->image))) {
        unlink(public_path('products/' . $product->image));
    }

    $product->delete();
    
    return redirect()->route('admin.products.index')
        ->with('success', 'Produk berhasil dimusnahkan oleh Police!');
}
}