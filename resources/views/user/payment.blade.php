@extends('layouts.app')

@section('title', 'Pembayaran - Dimsaykuu')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-danger text-white text-center py-3 rounded-top-4">
                    <h4 class="mb-0 fw-bold">Detail Pesanan #{{ $order->id }}</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="row mb-4">
                        <div class="col-6">
                            <p class="text-muted mb-1">Nama Produk</p>
                            <h5 class="fw-bold">{{ $order->product_name }}</h5>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted mb-1">Total Bayar</p>
                            <h4 class="text-danger fw-bold">Rp {{ number_format($order->price, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <hr class="my-4">

                    @if($order->status == 'pending')
                        <div class="text-center py-3">
                            <div class="bg-light p-4 rounded-3 mb-4">
                                <h6 class="fw-bold mb-2">Metode Pembayaran Otomatis</h6>
                                <p class="text-muted small">Klik tombol di bawah untuk membayar menggunakan E-Wallet (QRIS, ShopeePay), Virtual Account (Mandiri, BRI, BNI), atau Gerai Retail (Alfamart).</p>
                            </div>
                            
                            {{-- TOMBOL XENDIT: Langsung membuka Link yang disimpan di snap_token --}}
                            <a href="{{ $order->snap_token }}" target="_blank" class="btn btn-danger btn-lg w-100 py-3 fw-bold rounded-pill shadow">
                                <i class="bi bi-wallet2 me-2"></i>Bayar Sekarang
                            </a>
                            
                            <p class="mt-3 small text-muted"><i class="bi bi-shield-lock-fill me-1"></i> Pembayaran Aman didukung oleh <strong>Xendit</strong></p>
                        </div>
                    @elseif($order->status == 'success' || $order->status == 'settlement' || $order->status == 'PAID')
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="bi bi-patch-check-fill text-success" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="fw-bold text-success">Pembayaran Berhasil!</h3>
                            <p class="text-muted">Terima kasih telah memesan di Dimsaykuu. Pesanan Anda sedang diproses secara otomatis.</p>
                            
                            <div class="d-grid gap-2 d-md-block mt-4">
                                <button onclick="window.print()" class="btn btn-outline-dark px-4 py-2 fw-bold rounded-pill">
                                    <i class="bi bi-printer me-2"></i>Cetak Resi (Download)
                                </button>
                                <a href="{{ route('menu') }}" class="btn btn-danger px-4 py-2 fw-bold rounded-pill">
                                    Pesanan Baru
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-x-circle-fill text-warning mb-3" style="font-size: 4rem;"></i>
                            <h3 class="fw-bold">Status: {{ strtoupper($order->status) }}</h3>
                            <p class="text-muted">Silakan coba pesan kembali melalui menu.</p>
                            <a href="{{ route('menu') }}" class="btn btn-danger px-4 py-2 fw-bold rounded-pill mt-3">Kembali ke Menu</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        .card, .card * { visibility: visible; }
        .card { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; }
        .btn, .bg-light, hr, p.mt-3 { display: none !important; }
        .card-header { background-color: #dc3545 !important; color: white !important; -webkit-print-color-adjust: exact; }
    }
</style>
@endsection