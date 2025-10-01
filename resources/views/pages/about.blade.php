@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Mengenal Dimsaykuu Lebih Dekat</h2>
            <p class="lead text-muted">Kami hadir untuk menghadirkan pengalaman kuliner dimsum yang tak terlupakan dengan kualitas terbaik.</p>
        </div>
    </div>

    {{-- Section 1: Perkenalan dan Visi --}}
    <div class="row mb-5 p-4 rounded-3 shadow-sm" style="background-color: white;">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-shop me-2"></i>Tentang Dimsaykuu</h3>
            <p class="text-secondary">Dimsaykuu adalah UMKM di bidang Food & Beverage yang berfokus pada penyediaan dimsum berkualitas dengan cita rasa **autentik dan harga terjangkau**. Kami berkomitmen menghadirkan pengalaman kuliner yang menyenangkan dengan menu dimsum yang bervariasi, higienis, dan sesuai selera masyarakat Indonesia.</p>
            
            <p class="mt-4">Kami percaya bahwa makanan berkualitas harus dapat dinikmati oleh semua kalangan, didukung oleh semangat tim yang solid dan inovasi rasa.</p>
            
            {{-- Button dengan Custom Style --}}
            <a href="{{ url('/contact-us') }}" class="btn btn-dimsai-primary mt-3">
                <i class="bi bi-chat-dots-fill me-2"></i> Hubungi Kami Sekarang!
            </a>
        </div>
        <div class="col-md-6 border-start ps-md-5">
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-star-fill me-2"></i>Visi Kami</h3>
            <blockquote class="blockquote border-start border-3 ps-3 alert alert-dimsai-yellow" style="border-color: var(--dimsai-yellow) !important; background-color: #FFFBEA;">
                <p class="mb-0 fw-bold text-dark">"Menjadi brand dimsum lokal yang dipercaya dan dicintai konsumen di seluruh Indonesia."</p>
                <footer class="blockquote-footer mt-1 text-secondary">Dimsaykuu Commitment</footer>
            </blockquote>
            
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-bookmark-check-fill me-2"></i>Misi Kami</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-transparent">Menyediakan produk lezat dan sehat.</li>
                <li class="list-group-item bg-transparent">Memberikan pelayanan yang ramah dan cepat.</li>
                <li class="list-group-item bg-transparent">Terus berinovasi dalam menu dan layanan.</li>
            </ul>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- Section 2: Nilai Kami dengan Ikon --}}
    <div class="row text-center">
        <div class="col-lg-12 mb-4">
            <h2 style="color: var(--dimsai-red);">Nilai Inti Dimsaykuu</h2>
        </div>
        
        {{-- Nilai 1: Kualitas Bahan (Icon Tangan/Checklist) --}}
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <i class="bi bi-hand-thumbs-up-fill display-3 mb-3" style="color: var(--dimsai-red);"></i>
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Kualitas Bahan</h5>
                <p class="card-text text-muted">Kami hanya menggunakan bahan-bahan segar dan terbaik untuk menjamin rasa dimsum yang maksimal.</p>
            </div>
        </div>

      {{-- Nilai 2: Higienis (Icon Ceklis/Verified) --}}
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                {{-- Mengganti ikon ke bi-check-circle-fill untuk menunjukkan Jaminan --}}
                <i class="bi bi-check-circle-fill display-3 mb-3" style="color: var(--dimsai-yellow);"></i> 
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Higienis</h5>
                <p class="card-text text-muted">Proses pembuatan dan penyajian dimsum dilakukan sesuai standar kebersihan yang ketat dan terjamin.</p>
            </div>
        </div>

        {{-- Nilai 3: Harga Kompetitif (Icon Uang/Tag) --}}
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <i class="bi bi-tags-fill display-3 mb-3" style="color: var(--dimsai-red);"></i>
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Harga Kompetitif</h5>
                <p class="card-text text-muted">Menyediakan dimsum lezat berkualitas dengan harga yang sangat terjangkau untuk semua kalangan.</p>
            </div>
        </div>
    </div>
@endsection