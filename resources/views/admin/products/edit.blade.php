@extends('admin.app_admin')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
    <h2 class="dimsai-red mb-4">Edit Produk Dimsum: **{{ $product->name }}**</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    {{-- Penting: enctype="multipart/form-data" --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="p-4 border rounded shadow-sm" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Dimsum</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required min="1000">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Gambar Produk (Kosongkan jika tidak ingin ganti)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">

            @if ($product->image)
                <small class="text-muted mt-2 d-block">Gambar saat ini:</small>
                <img src="{{ asset('images/' . $product->image) }}" alt="Gambar Lama" style="max-height: 100px; margin-top: 5px;">
            @endif
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_promo" name="is_promo" value="1" {{ old('is_promo', $product->is_promo) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_promo">Sedang Promo?</label>
        </div>
        
        <button type="submit" class="btn btn-danger"><i class="bi bi-upload me-2"></i>Perbarui Produk</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
    </form>
@endsection