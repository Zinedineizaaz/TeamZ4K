@extends('layouts.app')
@section('content')
    <div class="container py-5">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px;">
            <div class="card-body p-4">
                <h4 class="fw-bold text-danger mb-4">Konfirmasi Pesanan</h4>
                <form action="{{ route('xendit.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="mb-3">
                        <label class="form-label">Menu: <strong>{{ $product->name }}</strong></label>
                        <p class="text-muted small">Harga: Rp {{ number_format($product->price) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Beli (Stok: {{ $product->stock }})</label>
                        <input type="number" name="quantity" class="form-control" min="1" max="{{ $product->stock }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-danger w-100 fw-bold">Lanjut ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
@endsection