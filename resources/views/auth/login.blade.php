@extends('layouts.app')

@section('title', 'Login Akun')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    
                    {{-- BAGIAN KIRI: GAMBAR (Hanya muncul di Laptop/PC) --}}
                    <div class="col-lg-6 d-none d-lg-block position-relative">
                        <img src="https://images.unsplash.com/photo-1563245372-f21724e3856d?q=80&w=1000&auto=format&fit=crop" 
                             alt="Login Image" 
                             class="w-100 h-100 object-fit-cover"
                             style="position: absolute; top: 0; left: 0;">
                        
                        {{-- Overlay Gelap biar teks terbaca --}}
                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center text-white text-center p-4" 
                             style="background: rgba(211, 47, 47, 0.6);"> <h2 class="fw-bold mb-3">Lapar? Login Dulu!</h2>
                            <p class="fs-5">Nikmati promo spesial member dan kumpulkan poinmu sekarang.</p>
                        </div>
                    </div>

                    {{-- BAGIAN KANAN: FORM LOGIN --}}
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-danger">Selamat Datang Kembali!</h3>
                                <p class="text-muted">Masuk untuk melanjutkan pesananmu.</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Input Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold small text-muted">ALAMAT EMAIL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope-fill text-danger"></i></span>
                                        <input id="email" type="email" class="form-control border-start-0 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@email.com">
                                    </div>
                                    @error('email')
                                        <span class="text-danger small mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Input Password --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label for="password" class="form-label fw-bold small text-muted">PASSWORD</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="small text-decoration-none text-danger fw-bold">Lupa Password?</a>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-key-fill text-danger"></i></span>
                                        <input id="password" type="password" class="form-control border-start-0 py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">
                                    </div>
                                    @error('password')
                                        <span class="text-danger small mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Remember Me --}}
                                <div class="mb-4 form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label text-muted small" for="remember">
                                        Ingat Saya di perangkat ini
                                    </label>
                                </div>

                                <hr class="my-4">

<div class="d-grid gap-2">
    <a href="{{ route('google.login') }}" class="btn btn-outline-danger fw-bold">
        <i class="bi bi-google me-2"></i> Masuk dengan Google
    </a>
</div>
<br>
                                {{-- Tombol Login --}}
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-danger py-2 fw-bold shadow-sm rounded-pill">
                                        MASUK SEKARANG <i class="bi bi-arrow-right ms-2"></i>
                                    </button>
                                </div>

                                <hr class="my-4">

                                <div class="text-center">
                                    <p class="text-muted mb-0">Belum punya akun?</p>
                                    <a href="{{ route('register') }}" class="btn btn-outline-warning text-dark fw-bold w-100 mt-2 rounded-pill">
                                        Daftar Akun Baru
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection