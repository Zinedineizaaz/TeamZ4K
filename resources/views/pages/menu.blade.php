@extends('layouts.app')

@section('title', 'Daftar Menu Dimsum')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-danger">MENU KAMI</h1>
            <p class="text-muted">Nikmati kelezatan dimsum pilihan Dimsaykuu</p>
            <hr class="mx-auto" style="width: 60px; border-top: 3px solid #dc3545;">
        </div>

        {{-- Alert untuk pesan sukses/error --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 position-relative">
                        {{-- Badge Stok Habis --}}
                        @if($product->stock <= 0)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-dark">Stok Habis</span>
                            </div>
                        @endif

                        @if($product->image)
                            <img src="{{ asset('products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                                style="height: 250px; object-fit: cover; {{ $product->stock <= 0 ? 'filter: grayscale(1);' : '' }}">
                        @else
                            <img src="https://via.placeholder.com/400x300?text=No+Image" class="card-img-top" alt="No Image">
                        @endif

                        <div class="card-body">
                            <h5 class="fw-bold">{{ $product->name }}</h5>
                            <p class="text-muted small">{{ Str::limit($product->description, 100) }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="fs-5 fw-bold text-danger">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-muted small">Stok: {{ $product->stock }}</span>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            {{-- LOGIKA BARU: Mengarahkan ke Form Pemesanan (Halaman antara) --}}
                            @if($product->stock > 0)
                                <a href="{{ route('order.form', $product->id) }}" class="btn btn-danger w-100 fw-bold">
                                    <i class="bi bi-cart-plus me-2"></i>Pesan Sekarang
                                </a>
                            @else
                                <button class="btn btn-secondary w-100 fw-bold" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center my-5">
                    <p class="lead text-muted">Belum ada menu yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection