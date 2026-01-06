@extends('layouts.app')

@section('title', 'Home')

@section('content')
    
    {{-- ========================================== --}}
    {{-- BAGIAN 1: DESAIN ASLI KAMU (TIDAK DIUBAH)  --}}
    {{-- ========================================== --}}

    {{-- 1. Hero Section dengan Carousel Otomatis --}}
    <div id="dimsumCarousel" class="carousel slide carousel-fade mb-5 shadow-lg rounded-3" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner rounded-3" style="max-height: 450px;">
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum1.PNG') }}" class="d-block w-100" alt="Dimsum Pilihan" style="object-fit: cover; height: 450px;">
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Selamat Datang di Dimsaykuu!</h5>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum2.PNG') }}" class="d-block w-100" alt="Promo Dimsum" style="object-fit: cover; height: 450px;">
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Cek Promo Spesial Mingguan Kami!</h5>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum3.PNG') }}" class="d-block w-100" alt="Varian Dimsum" style="object-fit: cover; height: 450px;">
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Dimsum Lezat, Harga Bersahabat. Pesan Sekarang!</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Call to Action Utama --}}
    <div class="text-center mb-5">
        <h3 class="fw-bold text-secondary">Rasakan Kenikmatan Autentik dari Setiap Gigitan!</h3>
        <a href="{{ url('/about') }}" class="btn btn-dimsai-primary btn-lg mt-3">Pelajari Dimsaykuu</a>
        <a href="{{ url('/program') }}" class="btn btn-outline-secondary btn-lg mt-3 ms-2" style="color: var(--dimsai-red); border-color: var(--dimsai-red);">Lihat Promo</a>
    </div>
    
    <hr class="mb-5">

    {{-- 3. Fitur Utama --}}
    {{-- 4. SECTION KEUNGGULAN (Why Choose Us) --}}
<div class="container mb-5 mt-5">
    
    {{-- Header Section --}}
    {{-- Header Section --}}
<div class="row"> {{-- Tambahkan row agar rapi seperti contoh 1 --}}
    <div class="col-lg-10 offset-lg-1 text-center mb-5">
        
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">KEUNGGULAN KAMI</span>
        <h2 class="display-6 fw-bold" style="color: var(--dimsai-red);">
            Kenapa Harus Dimsaykuu?
        </h2>
                    {{-- PERBAIKAN: Tambahkan class 'lead' agar teks paragraf lebih besar --}}
        <p class="lead text-muted mx-auto">
            Kami tidak hanya menjual rasa, tapi juga kualitas dan kepuasan di setiap gigitan.
        </p>
    {{-- PERBAIKAN: Tambahkan elemen garis kuning --}}
        <div style="width: 100px; height: 5px; background-color: var(--dimsai-yellow); margin: 0 auto; border-radius: 5px;"></div>
        
    </div>
</div>

    <div class="row g-4">
        
        {{-- Item 1: Kualitas --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 text-center py-4 px-3 bg-white">
                <div class="card-body">
                    {{-- Icon Bulat --}}
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle mb-4" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-patch-check-fill display-5"></i>
                    </div>
                    
                    <h4 class="card-title fw-bold mb-3">Kualitas Premium</h4>
                    <p class="card-text text-muted">
                        Dibuat dari daging ayam & udang segar pilihan. Tanpa pengawet, higienis, dan dijamin 100% Halal.
                    </p>
                </div>
            </div>
        </div>

        {{-- Item 2: Varian --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 text-center py-4 px-3 bg-white">
                <div class="card-body">
                    {{-- Icon Bulat --}}
                    <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle mb-4" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-grid-fill display-5"></i>
                    </div>

                    <h4 class="card-title fw-bold mb-3">Ragam Varian</h4>
                    <p class="card-text text-muted">
                        Nggak cuma satu rasa! Ada Mozzarella, Mentai, Nori, hingga Udang Rambutan yang siap manjakan lidahmu.
                    </p>
                </div>
            </div>
        </div>

        {{-- Item 3: Harga --}}
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 text-center py-4 px-3 bg-white">
                <div class="card-body">
                    {{-- Icon Bulat --}}
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-4" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-wallet2 display-5"></i>
                    </div>

                    <h4 class="card-title fw-bold mb-3">Harga Mahasiswa</h4>
                    <p class="card-text text-muted">
                        Rasa bintang lima, harga kaki lima. Nikmati kemewahan rasa dimsum tanpa bikin dompet menangis.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TAMBAHAN BARU (BIAR SCROLLABLE) --}}
    {{-- ========================================== --}}

    {{-- 5. SECTION TESTIMONI (Versi Bootstrap Murni) --}}
<div class="container mb-5 mt-5">
    <div class="text-center mb-5">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2">REVIEW JUJUR</span>
        {{-- Gunakan text-danger bawaan bootstrap biar merah --}}
        <h2 class="display-7 fw-bold" style="color: var(--dimsai-red);">
            Apa Kata Dimsum Lovers? 💬
        </h2>

        <p class="text-muted">Jangan percaya kami, percaya kata perut mereka.</p>
    </div>

    <div class="row g-4">
        {{-- Testimoni 1 --}}
        <div class="col-md-6">
            {{-- Pakai shadow-sm dan border-0 bawaan bootstrap --}}
            <div class="card h-100 border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4 position-relative">
                    {{-- Icon Quote Besar di pojok --}}
                    <i class="bi bi-quote display-1 text-danger position-absolute top-0 end-0 opacity-25 me-3"></i>
                    
                    {{-- Rating Bintang --}}
                    <div class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    
                    <p class="card-text fs-5 fst-italic text-dark mb-4 position-relative">
                        "Gila sih, ini dimsum terenak yang pernah gue coba di sekitaran kampus. Isiannya padet, kulitnya lembut, harganya pas banget buat mahasiswa!"
                    </p>

                    <div class="d-flex align-items-center mt-auto border-top pt-3">
                        {{-- Avatar pakai class rounded-circle --}}
                        <img src="https://ui-avatars.com/api/?name=Budi+Santoso&background=dc3545&color=fff" 
                             class="rounded-circle me-3" 
                             style="width: 50px; height: 50px;" alt="Budi">
                        <div>
                            <h6 class="fw-bold mb-0">Budi Santoso</h6>
                            <small class="text-muted">Mahasiswa Teknik</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Testimoni 2 --}}
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4 position-relative">
                    <i class="bi bi-quote display-1 text-danger position-absolute top-0 end-0 opacity-25 me-3"></i>
                    
                    <div class="text-warning mb-3">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-half"></i>
                    </div>

                    <p class="card-text fs-5 fst-italic text-dark mb-4 position-relative">
                        "Suka banget sama saus mentainya, creamy tapi nggak bikin eneg. Packagingnya juga rapi banget, aman dibawa pulang. Fix langganan!"
                    </p>

                    <div class="d-flex align-items-center mt-auto border-top pt-3">
                        <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=ffc107&color=000" 
                             class="rounded-circle me-3" 
                             style="width: 50px; height: 50px;" alt="Siti">
                        <div>
                            <h6 class="fw-bold mb-0">Siti Aminah</h6>
                            <small class="text-muted">Ibu Rumah Tangga</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 6. SECTION LOKASI & JAM BUKA (Bootstrap Dark Mode) --}}
<div class="container mb-5">
    {{-- Container Utama: Background Dark Gradient & Shadow --}}
    <div class="bg-dark bg-gradient text-white p-5 rounded-4 shadow">
        <div class="row align-items-center">
            
            {{-- ==========================
                 KOLOM KIRI: INFORMASI TEKS
                 ========================== --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3 text-warning">
                    <i class="bi bi-shop me-2"></i>Outlet Pusat
                </h2>
                <p class="lead mb-4 text-secondary text-white-50">
                    Lapar? Mampir langsung atau pesan online, kami siap melayani perut keronconganmu.
                </p>
                
                {{-- List Informasi --}}
                <div class="d-flex flex-column gap-3">
                    
                    {{-- Item 1: Alamat --}}
                    <div class="d-flex align-items-center p-3 rounded-3 bg-white bg-opacity-10">
                        <i class="bi bi-geo-alt-fill text-danger fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-warning">Alamat</h6>
                            <p class="mb-0 small">Jl. Jeruk Purut No. 88 (Samping Kopi Posko)</p>
                        </div>
                    </div>

                    {{-- Item 2: Jam Buka --}}
                    <div class="d-flex align-items-center p-3 rounded-3 bg-white bg-opacity-10">
                        <i class="bi bi-clock-fill text-danger fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-warning">Jam Operasional</h6>
                            <p class="mb-0 small">Senin - Minggu: 10.00 - 22.00 WIB</p>
                        </div>
                    </div>

                    {{-- Item 3: WhatsApp --}}
                    <div class="d-flex align-items-center p-3 rounded-3 bg-white bg-opacity-10">
                        <i class="bi bi-whatsapp text-danger fs-3 me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-0 text-warning">WhatsApp Order</h6>
                            <p class="mb-0 small">0812-3456-7890</p>
                        </div>
                    </div>
                </div>

                {{-- Tombol Buka Maps (Tab Baru) --}}
                <a href="https://www.google.com/maps/search/?api=1&query=Kopi+Posko+Jeruk+Purut" 
                   target="_blank" 
                   class="btn btn-outline-warning mt-4 rounded-pill px-4 fw-bold w-100">
                    <i class="bi bi-map-fill me-2"></i> Petunjuk Arah (G-Maps)
                </a>
            </div>

            {{-- ==========================
                 KOLOM KANAN: PETA EMBED ASLI
                 ========================== --}}
            <div class="col-lg-6">
                {{-- Bingkai Kuning & Rounded --}}
                <div class="border border-2 border-warning rounded-4 overflow-hidden shadow h-100" style="min-height: 400px;">
                    
                    {{-- IFRAME GOOGLE MAPS (Lokasi: Kopi Posko Jeruk Purut) --}}
                    <iframe 
                        width="100%" 
                        height="100%" 
                        id="gmap_canvas" 
                        src="https://maps.google.com/maps?q=Kopi+Posko+Jeruk+Purut+Jakarta&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>

                </div>
            </div>

        </div> {{-- End Row --}}
    </div> {{-- End Dark Box --}}
</div> {{-- End Container --}}

@endsection