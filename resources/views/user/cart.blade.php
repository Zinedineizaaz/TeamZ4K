@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- DAFTAR PRODUK DI KERANJANG --}}
            <div class="col-md-8">
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold text-danger">
                            <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-pill">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($cartItems->count() > 0)
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr class="text-muted small">
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{-- LOGIKA GAMBAR CERDAS: MENDUKUNG CLOUDINARY & LOKAL --}}
                                                        @php
                                                            $imgUrl = $item->product->image;
                                                            // Jika bukan URL lengkap (Cloudinary), maka cari di folder lokal
                                                            if (!Str::startsWith($imgUrl, ['http://', 'https://'])) {
                                                                $imgUrl = asset('storage/products/' . $item->product->image);
                                                            }
                                                        @endphp

                                                        <img src="{{ $imgUrl }}"
                                                            alt="{{ $item->product->name }}" class="rounded-3 me-3"
                                                            style="width: 70px; height: 70px; object-fit: cover;"
                                                            onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=Dimsum';">

                                                        <div>
                                                            <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                                            <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                                <td>
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                        class="d-flex align-items-center">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                            class="form-control form-control-sm text-center me-2 border-danger-subtle shadow-sm"
                                                            style="width: 60px; border-radius: 8px;" min="1"
                                                            max="{{ $item->product->stock }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                            <i class="bi bi-arrow-clockwise"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="fw-bold text-danger">
                                                    Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-muted p-0"
                                                            onclick="return confirm('Hapus item ini?')">
                                                            <i class="bi bi-trash3 fs-5"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x display-1 text-muted" style="opacity: 0.3;"></i>
                                <p class="mt-3 lead">Wah, keranjangmu masih kosong!</p>
                                <a href="{{ route('menu') }}" class="btn btn-danger rounded-pill px-5 py-2 shadow">Mulai Belanja</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RINGKASAN PEMBAYARAN --}}
            <div class="col-md-4">
                <div class="card shadow-sm border-0 sticky-top rounded-4" style="top: 100px;">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="mb-0 fw-bold text-dark">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Harga ({{ $cartItems->sum('quantity') }} item)</span>
                            <span class="fw-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Biaya Layanan</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>
                        <hr class="border-dashed">

                        @if($cartItems->count() > 0)
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="address" class="form-label fw-bold">Alamat Pengiriman</label>
                                    <textarea name="address" id="address"
                                        class="form-control border-danger-subtle @error('address') is-invalid @enderror"
                                        rows="3" placeholder="Masukkan alamat lengkap..." required
                                        style="border-radius: 12px;">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between mb-4">
                                    <span class="fs-5 fw-bold text-dark">Total Tagihan</span>
                                    <span class="fs-4 fw-bold text-danger">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                                </div>

                                <input type="hidden" name="total_price" value="{{ $totalPrice }}">

                                <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill fw-bold mb-3 shadow-lg border-0">
                                    <i class="bi bi-wallet2 me-2"></i> Bayar Sekarang
                                </button>
                            </form>
                        @endif

                        <div class="text-center mt-3">
                            <p class="small text-muted mb-0">
                                <i class="bi bi-shield-check me-1"></i> Pembayaran Aman Via <strong>Xendit</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection