@extends('layouts.app')

@section('title', '404 Not Found')

@section('content')

<div class="d-flex align-items-center justify-content-center min-vh-100">
        
        <div class="text-center">
            
            {{-- Gambar 404 --}}
            <img src="{{ asset('images/404-notfound.png') }}" alt="Halaman Tidak Ditemukan" class="img-fluid" style="max-width: 300px;">

            <h1 class="display-1 fw-bolder text-secondary" style="letter-spacing: 0.05em;">404</h1>
            
            <h2 class="display-5 fw-bold text-dark mt-n3 mb-3">Halaman Tidak Ditemukan</h2>
            
            <p class="lead text-muted mb-4">
                Maaf, halaman yang Anda cari mungkin telah dihapus, dipindahkan, atau tidak pernah ada.
            </p>
            
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                Kembali ke Beranda
            </a>
        </div>
        
</div>
@endsection