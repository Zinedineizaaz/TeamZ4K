@extends('layouts.app')

@section('title', 'Our Team')

@section('content')

    {{-- ========================================== --}}
    {{-- BAGIAN 1: KONTEN ASLI (FOTO & LIST TIM)    --}}
    {{-- ========================================== --}}

    <div class="row mb-5">
        <div class="col-lg-8 offset-lg-2 text-center">
            <h2 class="display-4 fw-bold mb-3" style="color: var(--dimsai-red);">Meet The Squad! 🚀</h2>
            <p class="lead text-muted mb-5">Tim solid mahasiswa berprestasi di balik lezatnya setiap gigitan Dimsaykuu.</p>
            
            {{-- FOTO TIM UTAMA --}}
            <div class="position-relative mb-5 d-inline-block">
                <img src="{{ asset('images/team.png') }}" 
                     alt="Foto Tim Dimsaykuu" 
                     class="img-fluid rounded-4 shadow-lg"
                     style="max-height: 450px; object-fit: cover; border: 8px solid white;">
                {{-- Dekorasi Badge --}}
                <div class="bg-warning text-dark fw-bold px-4 py-2 rounded-pill shadow position-absolute start-50 translate-middle-x" style="bottom: -20px;">
                    TeamZ4K - 2025
                </div>
            </div>
        </div>
    </div>

    {{-- LIST ANGGOTA TIM (Desain Baru: Kartu Horizontal) --}}
    <div class="row justify-content-center mb-5">
        <div class="col-lg-9">
            <h3 class="text-center mb-4 fw-bold" style="color: var(--dimsai-red);">Struktur Tim</h3>
            
            <div class="list-group shadow-sm border-0 rounded-4 overflow-hidden">
                
                {{-- Anggota 1 --}}
                <div class="list-group-item p-4 border-0 border-bottom d-flex align-items-center hover-bg">
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        A
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold text-dark">Agus Saputra Hamzah</h5>
                        <p class="mb-0 text-muted small"><i class="bi bi-card-heading me-1"></i> NIM: 2310120018</p>
                    </div>
                    <span class="badge bg-danger rounded-pill px-3 py-2">Team Leader</span>
                </div>

                {{-- Anggota 2 --}}
                <div class="list-group-item p-4 border-0 border-bottom d-flex align-items-center hover-bg">
                    <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        K
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold text-dark">Khairan Noor Fadhlillah</h5>
                        <p class="mb-0 text-muted small"><i class="bi bi-card-heading me-1"></i> NIM: 2310120022</p>
                    </div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">Fullstack Dev</span>
                </div>
                
                {{-- Anggota 3 --}}
                <div class="list-group-item p-4 border-0 d-flex align-items-center hover-bg">
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-4 shadow-sm" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        Z
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold text-dark">Zinedine Daffa Izaaz</h5>
                        <p class="mb-0 text-muted small"><i class="bi bi-card-heading me-1"></i> NIM: 2310120014</p>
                    </div>
                    <span class="badge bg-secondary rounded-pill px-3 py-2">UI/UX Designer</span>
                </div>

            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TAMBAHAN BARU (BIAR RAME)        --}}
    {{-- ========================================== --}}

    {{-- SECTION: BUDAYA KERJA --}}
    <div class="bg-light py-5 mb-5 rounded-4 px-3">
        <div class="container text-center">
            <h2 class="fw-bold mb-5" style="color: var(--dimsai-red);">Bagaimana Kami Bekerja</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <i class="bi bi-emoji-sunglasses-fill display-3 text-warning mb-3"></i>
                    <h5 class="fw-bold">Fun & Creative</h5>
                    <p class="text-muted">Kami percaya ide terbaik muncul dari suasana kerja yang santai tapi serius.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-lightning-charge-fill display-3 text-danger mb-3"></i>
                    <h5 class="fw-bold">Gerak Cepat</h5>
                    <p class="text-muted">Pelayanan cepat adalah kunci. Sat set sat set, dimsum hangat sampai di mejamu.</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-heart-fill display-3 text-dark mb-3"></i>
                    <h5 class="fw-bold">Sepenuh Hati</h5>
                    <p class="text-muted">Setiap porsi dibuat dengan cinta, karena kepuasanmu prioritas kami.</p>
                </div>
            </div>
        </div>
    </div>



    {{-- SECTION: CAREER (Join Us) --}}
    <div class="p-5 rounded-4 text-center text-white shadow" style="background: var(--dimsai-red); background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
        <h2 class="fw-bold">Ingin Bergabung dengan Tim Kami?</h2>
        <p class="fs-5 opacity-75">Kami selalu mencari talenta muda yang hobi makan dan jago masak!</p>
        <a href="mailto:hrd@dimsaykuu.com" class="btn btn-warning text-dark fw-bold px-5 py-3 mt-3 rounded-pill shadow-sm hover-scale">
            <i class="bi bi-envelope-fill me-2"></i>Kirim CV Kamu
        </a>
    </div>

@endsection

@section('styles')
<style>
    .hover-bg:hover { background-color: #f8f9fa; transition: 0.3s; }
    .object-fit-cover { object-fit: cover; }
    .hover-scale:hover { transform: scale(1.05); transition: 0.3s; }
</style>
@endsection