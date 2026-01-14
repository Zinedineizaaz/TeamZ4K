@extends('layouts.app')

@section('title', 'Program & Promo')

@section('content')

    {{-- ========================================== --}}
    {{-- BAGIAN 1: KONTEN ASLI (HEADER & KARTU) --}}
    {{-- ========================================== --}}

    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Program Spesial Dimsaykuu</h2>
            <p class="lead text-muted">Dapatkan penawaran terbaik dan ikuti event seru kami di sini!</p>
            <div style="width: 100px; height: 5px; background-color: var(--dimsai-yellow); margin: 0 auto; border-radius: 5px;"></div>
        </div>
    </div>

    <div class="row mb-5">
        {{-- Kartu Promo 1 --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card" style="border-top: 5px solid var(--dimsai-red) !important;">
                <div class="card-body text-center p-4">
                    <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-gift-fill display-4" style="color: var(--dimsai-red);"></i>
                    </div>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Promo Spesial Mingguan</h5>
                    <p class="card-text text-muted">Dapatkan potongan harga menarik untuk menu dimsum pilihan setiap hari kerja.</p>
                    <button type="button" class="btn btn-dimsai-primary mt-3 w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#menuModal">
                        <i class="bi bi-eye me-2"></i>Lihat Menu Diskon
                    </button>
                </div>
            </div>
        </div>

        {{-- Kartu Promo 2 --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card" style="border-top: 5px solid var(--dimsai-yellow) !important;">
                <div class="card-body text-center p-4">
                    <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-people-fill display-4" style="color: var(--dimsai-yellow);"></i>
                    </div>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Paket Hemat Keluarga</h5>
                    <p class="card-text text-muted">Pilihan paket bundling dimsum porsi besar, sempurna untuk acara kumpul keluarga.</p>
                    <a href="{{ url('/contact-us') }}" class="btn btn-outline-danger mt-3 w-100 rounded-pill">
                        <i class="bi bi-cart-plus me-2"></i>Pesan Paket
                    </a>
                </div>
            </div>
        </div>

        {{-- Kartu Promo 3 --}}
<div class="col-md-4 mb-4">
    <div class="card shadow-lg border-0 h-100 hover-card" style="border-top: 5px solid var(--dimsai-red) !important;">
        <div class="card-body text-center p-4">
            <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                <i class="bi bi-calendar-event-fill display-4" style="color: var(--dimsai-red);"></i>
            </div>
            <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Event Kuliner Terbaru</h5>
            <p class="card-text text-muted">Ikuti kami di berbagai food bazaar dan pop-up event terdekat di kotamu.</p>
            
            {{-- PERBAIKAN DI SINI: Ganti href ke route events.index --}}
            <a href="{{ route('events.index') }}" class="btn btn-outline-danger mt-3 w-100 rounded-pill">
                <i class="bi bi-geo-alt me-2"></i>Cek Jadwal
            </a>
            
        </div>
    </div>
</div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: LOYALTY PROGRAM & GAME           --}}
    {{-- ========================================== --}}

    {{-- SECTION: LOYALTY PROGRAM (Banner) --}}
    <div class="card border-0 shadow-lg text-white mb-5 overflow-hidden" style="background: linear-gradient(135deg, #d32f2f 0%, #ffc107 100%);">
        <div class="row g-0 align-items-center">
            <div class="col-md-8 p-5">
                <h2 class="display-5 fw-bold mb-3"><i class="bi bi-stars me-2"></i>Dimsaykuu Member Club</h2>
                <p class="fs-5">Gabung jadi member eksklusif dan kumpulkan poin setiap pembelian!</p>
                <button class="btn btn-light text-danger fw-bold rounded-pill px-4 py-2 mt-3 shadow-sm">
                    Daftar Member Sekarang
                </button>
            </div>
            <div class="col-md-4 text-center p-3 d-none d-md-block">
                <i class="bi bi-trophy-fill" style="font-size: 10rem; color: rgba(255,255,255,0.3);"></i>
            </div>
        </div>
    </div>

    {{-- !!!!!!!!!!!! GAME SECTION (LITE VERSION) !!!!!!!!!!!! --}}
    <div class="row justify-content-center mb-5" id="luckyKlakat">
        <div class="col-lg-10 text-center">
            <div class="bg-white p-5 rounded-4 shadow-lg border border-warning position-relative overflow-hidden">
                
                {{-- Hiasan Background Simple --}}
                <div style="position: absolute; top: -20px; right: -20px; font-size: 10rem; opacity: 0.1; transform: rotate(30deg);">🎰</div>

                <h2 class="fw-bold display-6 mb-2" style="color: var(--dimsai-red);">
                    🧧 TEBAK KLAKAT HOKI 🧧
                </h2>
                <p class="text-muted mb-4">Pilih satu klakat misterius di bawah ini dan dapatkan hadiah voucher rahasia! (1x Kesempatan/Hari)</p>

                {{-- === ALERT HASIL GAME (PENGGANTI POPUP ANIMASI) === --}}
                @if(session('prize_result'))
                    <div class="alert alert-success border-2 border-success p-4 mb-4 shadow-sm animate__animated animate__fadeIn">
                        <h2 class="alert-heading fw-bold">🎉 SELAMAT! 🎉</h2>
                        <p class="fs-4 mb-0">Kamu mendapatkan: <strong class="text-success bg-white px-2 rounded">{{ session('prize_result') }}</strong></p>
                        <hr>
                        <p class="mb-0 small">Screenshot layar ini dan tunjukkan ke kasir untuk klaim hadiahmu!</p>
                    </div>
                @endif
                {{-- ================================================= --}}

                @guest
                    {{-- STATE: BELUM LOGIN --}}
                    <div class="alert alert-warning d-inline-block px-5 py-3 rounded-pill">
                        <i class="bi bi-lock-fill me-2"></i> 
                        Silakan <a href="{{ route('login') }}" class="fw-bold text-dark">Login</a> terlebih dahulu untuk bermain.
                    </div>
                @else
                    {{-- STATE: SUDAH LOGIN --}}
                    
                    @if($alreadyPlayed)
                        {{-- STATE: SUDAH MAIN (TAMPILKAN PESAN HABIS) --}}
                        <div class="p-4 bg-light rounded-3 border">
                            <i class="bi bi-hourglass-split display-4 text-muted mb-3"></i>
                            <h4 class="fw-bold text-muted">Kesempatan Hari Ini Habis!</h4>
                            <p class="mb-0">Kamu sudah mencoba keberuntunganmu hari ini. Kembali lagi besok ya! 👋</p>
                        </div>
                    @else
                        {{-- STATE: BELUM MAIN (TAMPILKAN KLAKAT) --}}
                        <div class="row justify-content-center g-4">
                            @foreach([1, 2, 3] as $box)
                                <div class="col-md-3 col-6">
                                    <form action="{{ route('game.play') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn p-0 border-0 bg-transparent klakat-btn w-100">
                                            <div class="card h-100 shadow-sm border-0 hover-shake">
                                                <div class="card-body text-center py-4">
                                                    {{-- Icon Klakat/Box --}}
                                                    <i class="bi bi-box2-heart-fill display-1 text-warning"></i>
                                                    <h5 class="fw-bold mt-3 text-dark">KLAKAT #{{ $box }}</h5>
                                                    <small class="text-muted">Klik untuk Buka</small>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endguest
            </div>
        </div>
    </div>

    {{-- SECTION: FAQ PROMO --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <h3 class="fw-bold text-center mb-4" style="color: var(--dimsai-red);">Syarat & Ketentuan Promo</h3>
            <div class="accordion" id="accordionPromo">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            Apakah promo berlaku untuk pemesanan online?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionPromo">
                        <div class="accordion-body text-muted">
                            Promo mingguan saat ini hanya berlaku untuk <strong>Dine-in (Makan di tempat)</strong> dan <strong>Take-away</strong> langsung di outlet.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Sampai jam berapa promo berlaku?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionPromo">
                        <div class="accordion-body text-muted">
                            Promo berlaku setiap hari selama jam operasional (10.00 - 22.00 WIB).
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PROMO (ASLI) --}}
    <div class="modal fade" id="menuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-fire me-2"></i>Produk Lagi Promo!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body bg-light">
                      @if ($promo_products->isEmpty())
                        <p class="text-center py-4">Belum ada promo.</p>
                      @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-warning">
                                    <tr><th>Menu</th><th>Harga Spesial</th></tr>
                                </thead>
                                <tbody>
                                    @foreach ($promo_products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-danger fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
    .hover-card:hover { transform: translateY(-5px); transition: 0.3s; }
    
    /* Animasi Hover Klakat Ringan */
    .hover-shake { transition: 0.3s; cursor: pointer; }
    .klakat-btn:hover .hover-shake {
        transform: scale(1.05); /* Membesar Sedikit */
        background-color: #fff3cd !important;
        border-color: #ffc107 !important;
    }
</style>
@endsection

{{-- BAGIAN SCRIPT DIHAPUS KARENA SUDAH TIDAK PAKAI JS --}}