@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-4">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-person-plus-fill me-2"></i>Gabung Dimsaykuu</h4>
                    <small>Buat akun cuma butuh 30 detik!</small>
                </div>
                
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- NAMA LENGKAP --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                <input id="name" type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Contoh: Budi Santoso">
                            </div>
                            @error('name')
                                <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="budi@example.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 6 karakter">
                                </div>
                                @error('password')
                                    <span class="text-danger small mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="password-confirm" class="form-label fw-bold">Ulangi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-check2-circle"></i></span>
                                    <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password">
                                </div>
                            </div>
                        </div>

<hr class="my-4">

<div class="d-grid gap-2">
    <a href="{{ route('google.login') }}" class="btn btn-outline-danger fw-bold">
        <i class="bi bi-google me-2"></i> Masuk dengan Google
    </a>
</div>
<br>
                        {{-- TOMBOL DAFTAR --}}
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-warning fw-bold py-2 shadow-sm">
                                <i class="bi bi-rocket-takeoff-fill me-2"></i>DAFTAR SEKARANG
                            </button>
                        </div>

                        <div class="text-center">
                            <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-danger fw-bold text-decoration-none">Login disini</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection