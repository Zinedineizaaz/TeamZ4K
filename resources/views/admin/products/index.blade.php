@extends('admin.app_admin')

@section('title', 'Daftar Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dimsai-red">Kelola Produk Dimsum</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-danger"><i class="bi bi-plus-circle me-2"></i>Tambah Produk</a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    {{-- Collection & Eloquent: Looping Data --}}
    <table class="table table-striped table-bordered shadow-sm">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Promo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td class="fw-bold">{{ $product->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if ($product->is_promo)
                            <span class="badge bg-danger">YA</span>
                        @else
                            <span class="badge bg-secondary">TIDAK</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil"></i> Edit</a>
                        
                        {{-- DELETE --}}
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus {{ $product->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection