@extends('admin.app_admin')

@section('title', 'Edit Produk: ' . $product->name)

@section('content')
    <h2 class="dimsai-red mb-4">Edit Produk Dimsum: **{{ $product->name }}**</h2>
    
    {{-- Form Processing & Validation Error Display --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form UPDATE --}}
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="p-4 border rounded shadow-sm">
        @csrf
        @method('PUT') {{-- Metode untuk Update --}}
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Dimsum</label>
            {{-- Eloquent: Menggunakan nilai produk saat ini --}}
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
            <label for="image" class="form-label">URL/Path Gambar</label>
            <input type="text" class="form-control" id="image" name="image" value="{{ old('image', $product->image) }}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_promo" name="is_promo" value="1" {{ old('is_promo', $product->is_promo) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_promo">Sedang Promo?</label>
        </div>
        
        <button type="submit" class="btn btn-danger"><i class="bi bi-upload me-2"></i>Perbarui Produk</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Batal</a>
    </form>
@endsection