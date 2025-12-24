@extends('layouts.app')

@section('title', 'Daftar Menu Dimsum')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="fw-bold text-danger">MENU KAMI</h1>
            <p class="text-muted">Nikmati kelezatan dimsum pilihan Dimsaykuu</p>
            <hr class="mx-auto" style="width: 60px; border-top: 3px solid #dc3545;">
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        {{-- Menampilkan Gambar Produk --}}
                        @if($product->image)
                            <img src="{{ asset('products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                                style="height: 250px; object-fit: cover;">
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
                                @if($product->is_promo)
                                    <span class="badge bg-warning text-dark">Promo!</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            {{-- Link ke WhatsApp untuk pemesanan langsung --}}
                            <a href="https://wa.me/628123456789?text=Halo%20Dimsaykuu,%20saya%20ingin%20pesan%20{{ urlencode($product->name) }}"
                                class="btn btn-danger w-100 fw-bold" target="_blank">
                                <i class="bi bi-whatsapp me-2"></i>Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Tampilan jika admin belum menginput produk --}}
                <div class="col-12 text-center my-5">
                    <p class="lead text-muted">Belum ada menu yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection