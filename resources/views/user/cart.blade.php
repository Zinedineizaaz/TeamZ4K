@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cart3 me-2 text-danger"></i>Keranjang Belanja</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($cartItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
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
                                                    {{-- LOGIKA SMART PATH GAMBAR --}}
                                                    <img src="{{ asset('products/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="rounded me-3" 
                                                         style="width: 60px; height: 60px; object-fit: cover;"
                                                         onerror="this.onerror=null; this.src='{{ asset('storage/products/' . $item->product->image) }}';">
                                                    
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">{{ $item->product->name }}</h6>
                                                        <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                           class="form-control form-control-sm text-center me-2" 
                                                           style="width: 60px;" min="1" max="{{ $item->product->stock }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary border-0">
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
                                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0" onclick="return confirm('Hapus item ini?')">
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
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                            <p class="mt-3 lead">Wah, keranjangmu masih kosong!</p>
                            <a href="{{ route('menu') }}" class="btn btn-danger rounded-pill px-4">Lihat Menu Dimsum</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RINGKASAN BELANJA & INPUT ALAMAT --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
                <div class="card-header bg-white py-3">
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
                    <hr>
                    
                    @if($cartItems->count() > 0)
                        {{-- FORM CHECKOUT DENGAN ALAMAT --}}
                        <form action="{{ route('order') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="address" class="form-label fw-bold">Alamat Pengiriman</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Masukkan alamat lengkap (Jalan, No. Rumah, RT/RW, Kelurahan)..." required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="fs-5 fw-bold">Total Tagihan</span>
                                <span class="fs-5 fw-bold text-danger">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>

                            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                            <button type="submit" class="btn btn-danger w-100 py-3 rounded-pill fw-bold mb-3 shadow">
                                <i class="bi bi-wallet2 me-2"></i> Bayar Sekarang
                            </button>
                        </form>
                    @else
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fs-5 fw-bold">Total Tagihan</span>
                            <span class="fs-5 fw-bold text-danger">Rp 0</span>
                        </div>
                        <button class="btn btn-secondary w-100 py-3 rounded-pill fw-bold disabled">
                            Checkout
                        </button>
                    @endif
                    
                    <p class="text-center small text-muted">
                        Pembayaran aman & instan via Xendit
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection