@extends('layouts.app')

@section('title', 'Program & Promo')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Program Spesial Dimsaykuu</h2>
            <p class="lead text-muted">Dapatkan penawaran terbaik dan ikuti event seru kami di sini!</p>
        </div>
    </div>

    <div class="row">

        {{-- Kartu Promo 1: Promo Spesial Mingguan --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100" style="border-top: 5px solid var(--dimsai-red) !important;">
                <div class="card-body text-center">
                    <i class="bi bi-gift-fill display-2 mb-3" style="color: var(--dimsai-red);"></i>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Promo Spesial Mingguan</h5>
                    <p class="card-text text-muted">Dapatkan potongan harga menarik untuk menu dimsum pilihan setiap hari
                        kerja. Hemat dan lezat!</p>

                    {{-- TOMBOL BARU: Memicu Modal --}}
                    <button type="button" class="btn btn-dimsai-primary mt-3" data-bs-toggle="modal"
                        data-bs-target="#menuModal">
                        <i class="bi bi-calendar-week me-2"></i>Lihat Menu Hari Ini
                    </button>
                </div>
            </div>
        </div>

        {{-- Kartu Promo 2: Paket Hemat Keluarga (TETAP SAMA) --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100" style="border-top: 5px solid var(--dimsai-yellow) !important;">
                <div class="card-body text-center">
                    <i class="bi bi-bag-heart-fill display-2 mb-3" style="color: var(--dimsai-yellow);"></i>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Paket Hemat Keluarga</h5>
                    <p class="card-text text-muted">Pilihan paket bundling dimsum porsi besar yang sempurna untuk acara
                        kumpul keluarga. Mulai dari Rp 50K!</p>
                    <a href="{{ url('/contact-us') }}" class="btn btn-dimsai-primary mt-3"><i
                            class="bi bi-cart-fill me-2"></i>Pesan Paket</a>
                </div>
            </div>
        </div>

        {{-- Kartu Promo 3: Event Kuliner (TETAP SAMA) --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100" style="border-top: 5px solid var(--dimsai-red) !important;">
                <div class="card-body text-center">
                    <i class="bi bi-mic-fill display-2 mb-3" style="color: var(--dimsai-red);"></i>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Event Kuliner Terbaru</h5>
                    <p class="card-text text-muted">Ikuti kami di berbagai *food bazaar* dan *pop-up event*. Cek lokasi dan
                        tanggal terdekat di sini!</p>
                    <a href="{{ url('/contact-us') }}" class="btn btn-dimsai-primary mt-3"><i
                            class="bi bi-map-fill me-2"></i>Cek Lokasi</a>
                </div>
            </div>
        </div>
    </div>

    {{-- ************************************************* --}}
    {{-- MODAL (POP-UP) UNTUK DAFTAR MENU HARI INI (DIUBAH) --}}
    {{-- ************************************************* --}}
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background-color: var(--dimsai-red); color: white;">
                    <h5 class="modal-title" id="menuModalLabel"><i class="bi bi-list-check me-2"></i> Produk Yang Sedang
                        Promo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: var(--dimsai-bg-light);">

                    @if ($promo_products->isEmpty())
                        <div class="alert alert-info text-center">Saat ini belum ada produk yang sedang promo!</div>
                    @else
                        <p class="text-center fw-bold text-secondary">Produk di bawah ini sedang diskon! Pesan sebelum
                            kehabisan.</p>

                        {{-- Tabel Daftar Menu --}}
                        <table class="table table-striped table-hover shadow-sm">
                            <thead style="background-color: var(--dimsai-yellow); color: var(--dimsai-red);">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Dimsum</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Harga Normal (Simulasi)</th>
                                    <th scope="col">Harga Promo</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Collection: Iterasi promo_products --}}
                                @foreach ($promo_products as $key => $product)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>**{{ $product->name }}**</td>
                                        <td>{{ Str::limit($product->description, 50) ?? 'N/A' }}</td>
                                        <td><del>Rp {{ number_format($product->price + 5000, 0, ',', '.') }}</del></td>
                                        {{-- Simulasi Harga Normal --}}
                                        <td class="fw-bold text-success">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ url('/contact-us') }}" class="btn btn-danger"><i class="bi bi-bag-check-fill me-2"></i>
                        Pesan Sekarang</a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
