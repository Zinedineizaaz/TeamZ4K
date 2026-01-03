@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-3">
                
                {{-- HEADER --}}
                <div class="card-header bg-warning text-dark text-center py-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-unlock-fill me-2"></i>Reset Password</h4>
                    <small>Kami akan mengirimkan link pemulihan ke emailmu.</small>
                </div>

                <div class="card-body p-4">
                    
                    {{-- ALERT SUKSES (Jika link berhasil dikirim) --}}
                    @if (session('status'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                            <div>Link reset password berhasil dikirim! <br><strong>Cek file email kamu sekarang</strong></div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="text-center mb-4">
                            <div class="bg-light rounded-circle d-inline-flex p-3 mb-2">
                                <i class="bi bi-envelope-exclamation text-danger display-4"></i>
                            </div>
                            <p class="text-muted small px-3">Masukkan alamat email yang terdaftar di Dimsaykuu.</p>
                        </div>

                        {{-- INPUT EMAIL --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-at text-danger"></i></span>
                                <input id="email" type="email" class="form-control border-start-0 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="contoh@email.com">
                            </div>
                            @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- TOMBOL KIRIM --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger py-2 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-send-fill me-2"></i>KIRIM LINK RESET
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-muted">
                                <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection