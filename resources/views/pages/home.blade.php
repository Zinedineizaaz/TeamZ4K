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
    <h2 class="text-center mb-5" style="color: var(--dimsai-red);">Mengapa Memilih Dimsaykuu?</h2>
    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-5 rounded-3 h-100" style="border-top: 5px solid var(--dimsai-yellow) !important;">
                <div class="card-body">
                    <h5 class="card-title" style="color: var(--dimsai-red);">Kualitas Terbaik</h5>
                    <p class="card-text text-muted">Dimsum dibuat dari bahan-bahan segar pilihan dan proses yang higienis.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-5 rounded-3 h-100" style="border-top: 5px solid var(--dimsai-yellow) !important;">
                <div class="card-body">
                    <h5 class="card-title" style="color: var(--dimsai-red);">Ragam Varian</h5>
                    <p class="card-text text-muted">Pilihan menu dimsum bervariasi, dari klasik hingga inovatif.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-5 rounded-3 h-100" style="border-top: 5px solid var(--dimsai-yellow) !important;">
                <div class="card-body">
                    <h5 class="card-title" style="color: var(--dimsai-red);">Harga Terjangkau</h5>
                    <p class="card-text text-muted">Nikmati dimsum lezat tanpa perlu menguras dompet Anda.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TAMBAHAN BARU (BIAR SCROLLABLE) --}}
    {{-- ========================================== --}}

    

    {{-- 5. SECTION TESTIMONI (Apa Kata Mereka) --}}
    <div class="container mb-5">
        <h2 class="text-center mb-4" style="color: var(--dimsai-red);">Kata Mereka Tentang Dimsaykuu 💬</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card p-3 border-start border-4 border-warning shadow-sm">
                    <figure class="mb-0">
                        <blockquote class="blockquote">
                            <p class="fs-6 text-muted">"Gila sih, ini dimsum terenak yang pernah gue coba di sekitaran kampus. Harganya pas banget buat mahasiswa!"</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0">
                            Budi Santoso, <cite title="Source Title">Mahasiswa Teknik</cite>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card p-3 border-start border-4 border-warning shadow-sm">
                    <figure class="mb-0">
                        <blockquote class="blockquote">
                            <p class="fs-6 text-muted">"Suka banget sama saus mentainya, creamy tapi nggak bikin eneg. Fix bakal langganan terus!"</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0">
                            Siti Aminah, <cite title="Source Title">Ibu Rumah Tangga</cite>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>

    {{-- 6. SECTION LOKASI & JAM BUKA --}}
    <div class="row align-items-center bg-dark text-white p-5 rounded-3 shadow-lg" style="background: linear-gradient(45deg, #1a1a1a, #2c2c2c);">
        <div class="col-md-6">
            <h3 class="fw-bold text-warning mb-3">Kunjungi Outlet Kami! 📍</h3>
            <p>Mau makan di tempat atau take-away? Langsung aja gas ke lokasi kami.</p>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Jl. Jeruk Purut Samping Kopi Posko</li>
                <li class="mb-2"><i class="bi bi-clock-fill text-danger me-2"></i> Buka Setiap Hari: 10.00 - 22.00 WIB</li>
                <li class="mb-2"><i class="bi bi-whatsapp text-danger me-2"></i> 0812-3456-7890</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            {{-- Gambar Peta Ilustrasi --}}
            <img src="https://images.unsplash.com/photo-1569336415962-a4bd9f69cd83?auto=format&fit=crop&q=80&w=600&h=300" class="img-fluid rounded-3 opacity-75" alt="Map Location">
            <a href="https://maps.google.com" target="_blank" class="btn btn-danger mt-3 fw-bold">Buka Google Maps</a>
        </div>
    </div>

@endsection