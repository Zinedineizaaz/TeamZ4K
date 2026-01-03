@extends('layouts.app')

@section('title', 'Buat Password Baru')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-3">
                
                {{-- HEADER --}}
                <div class="card-header bg-danger text-white text-center py-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Password Baru</h4>
                    <small>Silakan buat password baru yang kuat.</small>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        {{-- Token Wajib Ada (Hidden) --}}
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- EMAIL (Readonly) --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold text-muted small">Alamat Email</label>
                            <input id="email" type="email" class="form-control bg-light" name="email" value="{{ $email ?? old('email') }}" required readonly>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- PASSWORD BARU --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-key text-danger"></i></span>
                                <input id="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                            </div>
                            @error('password')
                                <span class="invalid-feedback d-block mt-1">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">Ulangi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-check-circle text-success"></i></span>
                                <input id="password-confirm" type="password" class="form-control border-start-0" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password baru">
                            </div>
                        </div>

                        {{-- TOMBOL SIMPAN --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning fw-bold py-2 rounded-pill shadow-sm">
                                <i class="bi bi-save-fill me-2"></i>SIMPAN PASSWORD BARU
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection