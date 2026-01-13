@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dimsai-red">Kelola Produk Dimsum</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-circle me-2"></i>Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle shadow-sm bg-white rounded-3">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Promo</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @php
                                // Logika deteksi URL Cloudinary
                                $imgSrc = $product->image;
                                if (!Str::startsWith($imgSrc, ['http://', 'https://'])) {
                                    $imgSrc = asset('storage/products/' . $product->image);
                                }
                            @endphp

                            <div class="rounded-3 overflow-hidden border" style="width: 60px; height: 60px;">
                                <img src="{{ $imgSrc }}" alt="{{ $product->name }}"
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/60/FF0000/FFFFFF?text=ERR';">
                            </div>
                        </td>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td class="text-danger fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock <= 5)
                                <span class="badge bg-warning text-dark">{{ $product->stock }} (Menipis)</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td>
                            @if ($product->is_promo)
                                <span class="badge bg-danger"><i class="bi bi-tag-fill me-1"></i>YA</span>
                            @else
                                <span class="badge bg-secondary">TIDAK</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin hapus {{ $product->name }}? Aset Cloudinary juga akan dimusnahkan!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Belum ada data produk dimsum.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection