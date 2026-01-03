@extends('layouts.app')

@section('title', 'Program & Promo')

@section('content')

    {{-- ========================================== --}}
    {{-- BAGIAN 1: KONTEN ASLI (KARTU & MODAL)      --}}
    {{-- ========================================== --}}

    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Program Spesial Dimsaykuu</h2>
            <p class="lead text-muted">Dapatkan penawaran terbaik dan ikuti event seru kami di sini!</p>
            <div style="width: 100px; height: 5px; background-color: var(--dimsai-yellow); margin: 0 auto; border-radius: 5px;"></div>
        </div>
    </div>

    <div class="row mb-5">
        {{-- Kartu Promo 1: Promo Spesial Mingguan --}}
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

        {{-- Kartu Promo 2: Paket Hemat Keluarga --}}
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

        {{-- Kartu Promo 3: Event Kuliner --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 h-100 hover-card" style="border-top: 5px solid var(--dimsai-red) !important;">
                <div class="card-body text-center p-4">
                    <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                        <i class="bi bi-calendar-event-fill display-4" style="color: var(--dimsai-red);"></i>
                    </div>
                    <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Event Kuliner Terbaru</h5>
                    <p class="card-text text-muted">Ikuti kami di berbagai food bazaar dan pop-up event terdekat di kotamu.</p>
                    <a href="{{ url('/contact-us') }}" class="btn btn-outline-danger mt-3 w-100 rounded-pill">
                        <i class="bi bi-geo-alt me-2"></i>Cek Jadwal
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TAMBAHAN BARU (BIAR RAME)        --}}
    {{-- ========================================== --}}

    {{-- SECTION: CARA MENDAPATKAN PROMO (Steps) --}}
    <div class="bg-light p-5 rounded-4 mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--dimsai-red);">Cara Gampang Dapat Diskon 🤑</h2>
            <p class="text-muted">Ikuti 3 langkah mudah ini biar jajan tetap hemat!</p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 position-relative">
                <div class="display-1 fw-bold text-muted opacity-25" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); z-index: 0;">1</div>
                <div class="position-relative" style="z-index: 1;">
                    <i class="bi bi-instagram fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Follow Sosmed</h5>
                    <p class="text-secondary small">Wajib follow Instagram @Dimsaykuu biar gak ketinggalan info kode voucher.</p>
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <div class="display-1 fw-bold text-muted opacity-25" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); z-index: 0;">2</div>
                <div class="position-relative" style="z-index: 1;">
                    <i class="bi bi-camera-fill fs-1 text-warning mb-3"></i>
                    <h5 class="fw-bold">Snap & Story</h5>
                    <p class="text-secondary small">Foto dimsum pesananmu, upload ke Story, dan tag kami.</p>
                </div>
            </div>
            <div class="col-md-4 position-relative">
                <div class="display-1 fw-bold text-muted opacity-25" style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); z-index: 0;">3</div>
                <div class="position-relative" style="z-index: 1;">
                    <i class="bi bi-ticket-perforated-fill fs-1 text-success mb-3"></i>
                    <h5 class="fw-bold">Tunjukkan ke Kasir</h5>
                    <p class="text-secondary small">Tunjukkan bukti storymu ke kasir dan dapatkan potongan langsung 10%!</p>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION: LOYALTY PROGRAM (Banner) --}}
    <div class="card border-0 shadow-lg text-white mb-5 overflow-hidden" style="background: linear-gradient(135deg, #d32f2f 0%, #ffc107 100%);">
        <div class="row g-0 align-items-center">
            <div class="col-md-8 p-5">
                <h2 class="display-5 fw-bold mb-3"><i class="bi bi-stars me-2"></i>Dimsaykuu Member Club</h2>
                <p class="fs-5">Gabung jadi member eksklusif dan kumpulkan poin setiap pembelian! Tukarkan poinmu dengan <strong>Dimsum Gratis</strong> atau Merchandise Keren.</p>
                <button class="btn btn-light text-danger fw-bold rounded-pill px-4 py-2 mt-3 shadow-sm">
                    Daftar Member Sekarang (Gratis)
                </button>
            </div>
            <div class="col-md-4 text-center p-3 d-none d-md-block">
                <i class="bi bi-trophy-fill" style="font-size: 10rem; color: rgba(255,255,255,0.3);"></i>
            </div>
        </div>
    </div>

    {{-- SECTION: FAQ PROMO (Accordion) --}}
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
                            Promo mingguan saat ini hanya berlaku untuk <strong>Dine-in (Makan di tempat)</strong> dan <strong>Take-away</strong> langsung di outlet. Untuk pemesanan via ojek online, ikuti promo di aplikasi masing-masing.
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
                            Promo berlaku setiap hari selama jam operasional (10.00 - 22.00 WIB) selama persediaan menu promo masih ada.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ... MODAL ASLI (TETAP ADA) ... --}}
    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="menuModalLabel"><i class="bi bi-fire me-2"></i>Produk Lagi Promo!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    @if ($promo_products->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-emoji-frown display-1 text-muted"></i>
                            <p class="mt-3 text-muted">Yah, belum ada promo aktif saat ini. Cek lagi besok ya!</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Menu</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end">Harga Spesial</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promo_products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($product->image)
                                                    <img src="{{ asset('images/' . $product->image) }}" class="rounded me-3 shadow-sm" width="50" height="50" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center text-white" style="width:50px; height:50px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-bold">{{ $product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="small text-muted">{{ Str::limit($product->description, 60) }}</td>
                                        <td class="text-end fw-bold text-danger">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ url('/contact-us') }}" class="btn btn-danger rounded-pill px-4"><i class="bi bi-whatsapp me-2"></i>Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .hover-card:hover { transform: translateY(-5px); transition: 0.3s; }
</style>
@endsection