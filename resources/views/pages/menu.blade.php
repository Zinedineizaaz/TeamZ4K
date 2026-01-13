@extends('layouts.app')

@section('title', 'Daftar Menu Dimsum')

@section('content')

{{-- STYLE TAMBAHAN KHUSUS HALAMAN INI --}}
<style>
    .card-product {
        transition: all 0.3s ease-in-out;
        border: 1px solid #f0f0f0;
    }
    .card-product:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        border-color: #dc3545;
    }
    .product-img-wrapper {
        overflow: hidden;
        height: 250px;
        position: relative;
    }
    .product-img-wrapper img {
        transition: transform 0.5s ease;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .card-product:hover .product-img-wrapper img {
        transform: scale(1.1);
    }
    .btn-fav {
        transition: all 0.2s;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(2px);
    }
    .btn-fav:hover {
        background: #dc3545;
        color: white !important;
    }
    .btn-fav:hover i {
        color: white !important;
    }
</style>

<div class="container py-5">

    {{-- ================= HEADER & NOTIFIKASI ================= --}}
    <div class="text-center mb-5">
        <h6 class="text-danger fw-bold text-uppercase tracking-wide">Pilihan Terbaik</h6>
        <h1 class="fw-bold text-dark display-5 mb-3">Menu Spesial Dimsaykuu</h1>
        <p class="text-muted col-md-8 mx-auto lead">
            Nikmati kelezatan dimsum premium dengan bahan pilihan yang siap memanjakan lidah Anda.
        </p>
        
        {{-- GARIS HIASAN --}}
        <div class="d-flex justify-content-center align-items-center mt-3">
            <span style="height: 2px; width: 50px; background: #dc3545; opacity: 0.2;"></span>
            <i class="bi bi-star-fill text-danger mx-3"></i>
            <span style="height: 2px; width: 50px; background: #dc3545; opacity: 0.2;"></span>
        </div>

        {{-- NOTIFIKASI --}}
        <div class="mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mx-auto shadow-sm border-0" style="max-width:600px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mx-auto shadow-sm border-0" style="max-width:600px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    {{-- ================= LIST PRODUK ================= --}}
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm rounded-4 card-product position-relative overflow-hidden">

                    {{-- TOMBOL FAVORIT (POJOK KANAN ATAS) --}}
                    <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" 
                          class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                        @csrf
                        <button type="submit" class="btn btn-fav rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                style="width:45px; height:45px;" title="Tambah ke Favorit">
                            @auth
                                <i class="bi {{ Auth::user()->favorites->contains('product_id', $product->id) ? 'bi-heart-fill text-danger' : 'bi-heart text-danger' }} fs-5"></i>
                            @else
                                <i class="bi bi-heart text-danger fs-5"></i>
                            @endauth
                        </button>
                    </form>

                    {{-- GAMBAR PRODUK (YANG SUDAH DIPERBAIKI: ANTI-LOOP) --}}
                    <div class="product-img-wrapper bg-light">
                        <img 
                            src="{{ asset('products/' . $product->image) }}" 
                            alt="{{ $product->name }}"
                            {{-- LOGIC: Cek folder public -> Cek storage -> Kalau gagal, kasih Placeholder (STOP DISITU) --}}
                            onerror="this.onerror=null; this.src='{{ asset('storage/' . $product->image) }}'; 
                                     setTimeout(() => { 
                                         if(!this.complete || this.naturalWidth === 0) { 
                                             this.src='https://via.placeholder.com/400x300?text=Gambar+Tidak+Ditemukan'; 
                                         } 
                                     }, 500);"
                        >

                        {{-- BADGE STOK HABIS --}}
                        @if($product->stock <= 0)
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger fs-6 px-4 py-2 text-uppercase fw-bold shadow">Stok Habis</span>
                            </div>
                        @endif
                    </div>

                    {{-- KONTEN KARTU --}}
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold text-dark mb-0">{{ $product->name }}</h5>
                        </div>

                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            {{ Str::limit($product->description, 90) }}
                        </p>

                        {{-- HARGA DAN SISA STOK --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem;">Harga Satuan</small>
                                <span class="fs-4 fw-bold text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            @if($product->stock > 0 && $product->stock <= 5)
                                <div class="text-end">
                                    <small class="text-warning fw-bold"><i class="bi bi-fire me-1"></i>Sisa {{ $product->stock }}!</small>
                                </div>
                            @endif
                        </div>

                        {{-- TOMBOL BELI --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                            @csrf
                            @if($product->stock > 0)
                                <button type="submit" class="btn btn-dark w-100 rounded-pill py-2 shadow-sm fw-bold">
                                    <i class="bi bi-bag-plus-fill me-2"></i> Pesan Sekarang
                                </button>
                            @else
                                <button type="button" class="btn btn-light text-muted w-100 rounded-pill py-2 fw-bold" disabled style="cursor: not-allowed;">
                                    <i class="bi bi-x-circle me-2"></i> Tidak Tersedia
                                </button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-light rounded-4 p-5 d-inline-block">
                    <i class="bi bi-emoji-frown display-1 text-muted mb-3 d-block"></i>
                    <h4 class="fw-bold text-muted">Belum ada menu tersedia.</h4>
                    <p class="text-muted">Silakan kembali lagi nanti ya!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection