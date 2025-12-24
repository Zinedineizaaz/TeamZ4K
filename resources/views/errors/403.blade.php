@extends('layouts.app') {{-- Pastikan ini layout utama kamu --}}

@section('title', '403 Akses Ditolak')

@section('content')

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
        
    <div class="text-center p-5 border rounded shadow-sm bg-white" style="max-width: 600px;">
        
        {{-- Ikon Gembok (Ganti gambar 404 dengan Ikon Bootstrap biar ringan) --}}
        <div class="mb-4">
            <i class="bi bi-shield-lock-fill text-danger" style="font-size: 8rem;"></i>
        </div>

        <h1 class="display-1 fw-bolder text-danger" style="letter-spacing: 0.05em;">403</h1>
        
        <h2 class="display-6 fw-bold text-dark mt-n3 mb-3">AKSES DITAHAN!</h2>
        
        <p class="lead text-secondary mb-4">
            Waduh, Maaf <strong>{{ Auth::user()->name }}</strong>.<br>
            Halaman ini dikunci khusus untuk <strong>Police (Super Admin)</strong>.
            Jabatan kamu saat ini tidak memiliki izin untuk masuk.
        </p>
        
        <div class="d-flex justify-content-center gap-3">
            {{-- Tombol Balik ke Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-lg px-4">
                <i class="bi bi-speedometer2 me-2"></i>Ke Dashboard
            </a>
            
            {{-- Tombol Logout (Opsional) --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-lg px-4">
                    Logout
                </button>
            </form>
        </div>

    </div>
        
</div>
@endsection