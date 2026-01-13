@extends('layouts.app')

@section('title', 'Daftar Menu Dimsum')

@section('content')
<div class="container py-5">

    {{-- ================= HEADER & NOTIFIKASI ================= --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold text-danger">MENU KAMI</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-auto mb-3" style="max-width:600px;">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-auto mb-3" style="max-width:600px;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <p class="text-muted">Nikmati kelezatan dimsum pilihan Dimsaykuu</p>
        <hr class="mx-auto" style="width:60px;border-top:3px solid #dc3545;">
    </div>

    {{-- ================= LIST PRODUK ================= --}}
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 position-relative">

                    {{-- FAVORITE FLOATING BUTTON --}}
                   <form 
    action="{{ route('favorites.toggle', $product->id) }}" 
    method="POST" 
    class="position-absolute top-0 end-0 m-3"
    style="z-index: 999;"
>
    @csrf
    <button 
        type="submit" 
        class="btn rounded-circle shadow-sm d-flex align-items-center justify-content-center"
        style="width:40px;height:40px;background-color:#fff;"
    >
        @auth
            <i class="bi 
                {{ Auth::user()->favorites->contains('product_id', $product->id) 
                    ? 'bi-heart-fill text-danger' 
                    : 'bi-heart text-danger' 
                }} fs-5">
            </i>
        @else
            <i class="bi bi-heart text-danger fs-5"></i>
        @endauth
    </button>
</form>


                    {{-- ================= GAMBAR PRODUK (SISTEM DETEKSI OTOMATIS) ================= --}}
                    <div class="position-relative">
                        @if($product->image)
                            <img 
                                {{-- Jalur 1: Cek folder public/products (untuk upload manual lama) --}}
                                src="{{ asset('products/' . $product->image) }}" 
                                class="card-img-top" 
                                alt="{{ $product->name }}"
                                style="height:250px; object-fit:cover;"
                                
                                {{-- Jalur 2: Jika gagal, cek storage/products/ (untuk upload admin baru) --}}
                                onerror="this.onerror=null; this.src='{{ asset('storage/products/' . $product->image) }}'; 
                                
                                {{-- Jalur 3: Jika gagal lagi, cek storage/ (root storage) --}}
                                this.onerror=function(){ this.src='{{ asset('storage/' . $product->image) }}'; 
                                
                                {{-- Jalur 4: Placeholder jika semua gagal --}}
                                this.onerror=function(){ this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'; }; };"
                            >
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" style="height:250px; object-fit:cover;">
                        @endif

                        @if($product->stock <= 0)
                            <div class="position-absolute top-50 start-50 translate-middle w-100 text-center">
                                <span class="badge bg-dark fs-6 px-3 py-2 opacity-75">STOK HABIS</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="fw-bold mb-1">{{ $product->name }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($product->description, 100) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fs-5 fw-bold text-danger">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @if($product->stock > 0 && $product->stock <= 5)
                                <span class="badge bg-warning text-dark">Sisa {{ $product->stock }}!</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            @if($product->stock > 0)
                                <button type="submit" class="btn btn-danger w-100 fw-bold rounded-pill py-2 shadow-sm">
                                    <i class="bi bi-cart-plus-fill me-2"></i>Tambah Keranjang
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary w-100 fw-bold rounded-pill py-2" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-shop display-1 text-muted opacity-25"></i>
                <p class="lead text-muted mt-3">Belum ada menu yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection