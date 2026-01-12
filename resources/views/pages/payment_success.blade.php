@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <div class="card shadow-sm border-0 p-4 p-md-5">
                    <div class="mb-4">
                        {{-- Animasi Centang Sederhana --}}
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-check-lg" style="font-size: 3.5rem;"></i>
                        </div>
                    </div>

                    <h2 class="fw-bold text-dark">Pembayaran Berhasil!</h2>
                    <p class="text-muted mb-4 px-lg-5">
                        Terima kasih telah memesan di <strong>Dimsaykuu</strong>.
                        Sistem kami telah menerima pembayaran Anda melalui Xendit dan stok produk sudah otomatis diperbarui.
                    </p>

                    <div class="bg-light rounded-3 p-4 mb-4 text-start">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Informasi Pesanan</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Status Pembayaran</span>
                            <span class="badge bg-success">PAID / LUNAS</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Metode</span>
                            <span>Otomatis (Xendit)</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Waktu Transaksi</span>
                            <span>{{ now()->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('menu') }}" class="btn btn-danger btn-lg px-4 fw-bold">
                            <i class="bi bi-bag-plus me-2"></i>Beli Dimsum Lagi
                        </a>
                        <a href="/" class="btn btn-outline-secondary btn-lg px-4">
                            Kembali ke Beranda
                        </a>
                    </div>

                    <div class="mt-5 text-muted small">
                        <p>Butuh bantuan? Hubungi kami via <a href="https://wa.me/628123456789"
                                class="text-decoration-none text-success fw-bold">WhatsApp</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animasi kecil agar halaman terasa hidup */
        .bg-success {
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
@endsection