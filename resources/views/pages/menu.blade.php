@extends('layouts.app')

@section('title', 'Menu Dimsum Premium - Dimsaykuu')

@section('content')
    <div class="container py-5">
        {{-- ================= HEADER SECTION ================= --}}
        <div class="text-center mb-5 mt-4">
            <h6 class="text-danger fw-bold text-uppercase ls-2">Authentic Taste</h6>
            <h1 class="fw-bold text-dark display-4">Menu Dimsaykuu</h1>
            <p class="text-muted col-md-6 mx-auto">Dari bahan premium untuk kepuasan lidah Anda. Segar, Halal, dan Higienis.
            </p>
        </div>

        {{-- ================= SEARCH & FILTER BAR ================= --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <form action="{{ route('menu') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-lg-8">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0 rounded-end-pill py-2"
                                    placeholder="Cari dimsum favoritmu..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-danger w-100 rounded-pill py-2 fw-bold">
                                Cari Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ================= NOTIFIKASI ================= --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show">
                <i class="bi bi-cart-check-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ================= PRODUCT GRID ================= --}}
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 card-product overflow-hidden">

                        {{-- IMAGE WRAPPER --}}
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            @php
                                $imgUrl = Str::startsWith($product->image, 'http')
                                    ? $product->image
                                    : asset('storage/products/' . $product->image);
                            @endphp

                            <img src="{{ $imgUrl }}" class="card-img-top w-100 h-100 object-fit-cover transition-transform"
                                alt="{{ $product->name }}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300?text=Dimsum+Image';">

                            {{-- STATUS BADGES --}}
                            <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-2">
                                @if($product->is_promo)
                                    <span class="badge bg-danger rounded-pill px-3 shadow-sm">Promo!</span>
                                @endif
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 shadow-sm">Limited</span>
                                @endif
                            </div>

                            {{-- FAVORITE BUTTON --}}
                            <form action="{{ route('favorites.toggle', $product->id) }}" method="POST"
                                class="position-absolute top-0 end-0 m-3">
                                @csrf
                                <button type="submit"
                                    class="btn btn-white btn-sm rounded-circle shadow-sm p-2 bg-white opacity-90 border-0">
                                    <i
                                        class="bi {{ auth()->user() && auth()->user()->favorites->contains('product_id', $product->id) ? 'bi-heart-fill text-danger' : 'bi-heart text-danger' }} fs-5"></i>
                                </button>
                            </form>

                            @if($product->stock <= 0)
                                <div
                                    class="position-absolute inset-0 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center w-100 h-100">
                                    <span class="badge bg-white text-dark px-4 py-2 rounded-pill fw-bold">STOK HABIS</span>
                                </div>
                            @endif
                        </div>

                        {{-- CARD BODY --}}
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold mb-1 text-dark">{{ $product->name }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($product->description, 60) }}</p>

                            <div class="d-flex justify-content-between align-items-end mt-auto">
                                <div>
                                    <p class="text-muted small mb-0 lh-1">Harga</p>
                                    <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block mb-1">Stok: {{ $product->stock }}</small>
                                </div>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $product->stock > 0 ? 'btn-dark' : 'btn-light disabled' }} w-100 rounded-pill py-2 fw-bold"
                                    {{ $product->stock > 0 ? '' : 'disabled' }}>
                                    <i class="bi bi-cart-plus me-2"></i> {{ $product->stock > 0 ? 'Pesan Sekarang' : 'Habis' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search text-muted display-1 mb-3 opacity-25"></i>
                    <h4 class="fw-bold">Menu tidak ditemukan</h4>
                    <p class="text-muted">Coba gunakan kata kunci pencarian yang lain.</p>
                    <a href="{{ route('menu') }}" class="btn btn-outline-danger rounded-pill px-4">Tampilkan Semua Menu</a>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .ls-2 {
            letter-spacing: 2px;
        }

        .card-product {
            transition: transform 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
        }

        .card-product:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1) !important;
        }

        .transition-transform {
            transition: transform 0.5s ease;
        }

        .card-product:hover .transition-transform {
            transform: scale(1.1);
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .object-fit-cover {
            object-fit: cover;
        }

        .opacity-90 {
            opacity: 0.9;
        }
    </style>
@endsection