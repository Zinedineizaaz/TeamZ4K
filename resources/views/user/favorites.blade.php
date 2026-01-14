@extends('layouts.app')

@section('title', 'Menu Favorit Saya')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold text-danger"><i class="bi bi-heart-fill me-2"></i>MENU FAVORIT</h1>
        <p class="text-muted">Daftar dimsum yang paling kamu sukai di Dimsaykuu</p>
        <hr class="mx-auto" style="width: 60px; border-top: 3px solid #dc3545;">
    </div>

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mx-auto mb-4" style="max-width: 600px;">
            <i class="bi bi-info-circle-fill me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($favorites as $fav)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 position-relative">
                    
                    {{-- Tombol Hapus dari Favorit --}}
                    <form action="{{ route('favorites.toggle', $fav->product->id) }}" method="POST" class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                        @csrf
                        <button type="submit" class="btn btn-danger shadow-sm rounded-circle p-2" style="width: 40px; height: 40px;" title="Hapus dari favorit">
                            <i class="bi bi-heart-fill text-white"></i>
                        </button>
                    </form>

                    {{-- Gambar Produk dengan Smart Path --}}
                    @if($fav->product->image)
    <img 
        src="{{ asset('products/' . $fav->product->image) }}"
        class="card-img-top"
        alt="{{ $fav->product->name }}"
        style="height: 250px; object-fit: cover;"
        onerror="
            this.onerror=null;
            this.src='{{ asset('storage/products/' . $fav->product->image) }}';
        "
    >
@else
    <img 
        src="https://via.placeholder.com/400x300?text=No+Image" 
        class="card-img-top" 
        style="height: 250px; object-fit: cover;"
    >
@endif

                    <div class="card-body">
                        <h5 class="fw-bold">{{ $fav->product->name }}</h5>
                        <p class="text-muted small">{{ Str::limit($fav->product->description, 80) }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="fs-5 fw-bold text-danger">
                                Rp {{ number_format($fav->product->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-3 text-center">
                        <div class="d-grid gap-2">
                            {{-- Tambah ke Keranjang --}}
                            <form action="{{ route('cart.add', $fav->product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold rounded-pill">
                                    <i class="bi bi-cart-plus-fill me-2"></i>Tambah Keranjang
                                </button>
                            </form>
                            
                            <a href="{{ route('menu') }}" class="btn btn-link btn-sm text-muted text-decoration-none">
                                Lihat Detail Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-heartbreak display-1 text-muted opacity-25"></i>
                </div>
                <h4 class="text-muted">Belum ada menu favorit nih...</h4>
                <p class="text-muted">Yuk, jelajahi menu dan klik ikon hati pada dimsum pilihanmu!</p>
                <a href="{{ route('menu') }}" class="btn btn-danger rounded-pill px-4 py-2 mt-3 shadow-sm">
                    Mulai Jelajah Menu
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection