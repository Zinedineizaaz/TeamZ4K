@extends('layouts.app')

@section('title', 'Home')

@section('content')
    
    {{-- 1. Hero Section dengan Carousel Otomatis --}}
    <div id="dimsumCarousel" class="carousel slide carousel-fade mb-5 shadow-lg rounded-3" data-bs-ride="carousel">
        
        {{-- Indikator (Titik-titik di bawah) --}}
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#dimsumCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        {{-- Konten Carousel --}}
        <div class="carousel-inner rounded-3" style="max-height: 450px;">
            
            {{-- Slide 1: Welcome (Menggunakan dimsum1.JPG sesuai permintaan) --}}
            <div class="carousel-item active" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum1.PNG') }}" class="d-block w-100" alt="Dimsum Pilihan" style="object-fit: cover; height: 450px;">
                {{-- Caption diletakkan di bawah gambar agar tidak menutupi --}}
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Selamat Datang di Dimsaykuu!</h5>
                </div>
            </div>

            {{-- Slide 2: Promo (Menggunakan dimsum2.JPG) --}}
            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum2.PNG') }}" class="d-block w-100" alt="Promo Dimsum" style="object-fit: cover; height: 450px;">
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Cek Promo Spesial Mingguan Kami!</h5>
                </div>
            </div>
            
            {{-- Slide 3: Call to Action (Menggunakan dimsum3.JPG) --}}
            <div class="carousel-item" data-bs-interval="4000">
                <img src="{{ asset('images/dimsum3.PNG') }}" class="d-block w-100" alt="Varian Dimsum" style="object-fit: cover; height: 450px;">
                <div class="carousel-caption d-none d-md-block p-2 text-center" style="position: static; background-color: white; color: black;">
                    <h5 class="fw-bold" style="color: var(--dimsai-red);">Dimsum Lezat, Harga Bersahabat. Pesan Sekarang!</h5>
                </div>
            </div>
            
        </div>
        
    </div>

    {{-- 2. Call to Action Utama (di bawah Slider) --}}
    <div class="text-center mb-5">
        <h3 class="fw-bold text-secondary">Rasakan Kenikmatan Autentik dari Setiap Gigitan!</h3>
        <a href="{{ url('/about') }}" class="btn btn-dimsai-primary btn-lg mt-3">Pelajari Dimsaykuu</a>
        <a href="{{ url('/program') }}" class="btn btn-outline-secondary btn-lg mt-3 ms-2" style="color: var(--dimsai-red); border-color: var(--dimsai-red);">Lihat Promo</a>
    </div>
    
    <hr class="mb-5">

    {{-- 3. Fitur Utama --}}
    <h2 class="text-center mb-5" style="color: var(--dimsai-red);">Mengapa Memilih Dimsaykuu?</h2>
    <div class="row text-center">
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
@endsection