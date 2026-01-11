@extends('layouts.app')

@section('content')

{{-- 1. SCRIPT WAJIB RECAPTCHA (Taro disini aja aman) --}}
{{-- {!! NoCaptcha::renderJs() !!} --}}

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white text-center py-4">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-shield-lock-fill me-2"></i>ADMINISTRATOR ACCESS</h4>
                    <small>Hanya untuk Staff & Police</small>
                </div>

                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Admin</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@team.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- 2. KOTAK CENTANG ROBOT (Ditaruh diatas tombol login) --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-center">
                                {{-- {!! NoCaptcha::display() !!} --}}
                            </div>
                            
                            {{-- Pesan Error kalau lupa nyentang --}}
                            @if ($errors->has('g-recaptcha-response'))
                                <div class="text-danger small text-center mt-1">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-lg fw-bold">
                                <i class="bi bi-box-arrow-in-right me-2"></i> MASUK DASHBOARD
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center bg-light py-3">
                    <small class="text-muted">Bukan admin? <a href="{{ route('login') }}" class="text-danger">Login User disini</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection