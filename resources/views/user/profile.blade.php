@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-4">
    
    {{-- ALERT SUKSES --}}
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- BAGIAN KIRI: KARTU PROFIL & FOTO --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100">
                <div class="card-body p-4">
                    <div class="position-relative d-inline-block mb-3">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="rounded-circle border border-4 border-warning shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=d32f2f&color=fff&size=150" class="rounded-circle border border-4 border-warning shadow-sm" alt="Profile">
                        @endif
                        
                        {{-- Badge Role --}}
                        <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark border border-white">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>

                    <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted small mb-3">{{ Auth::user()->email }}</p>
                    <p class="text-muted fst-italic small">
                        Bergabung sejak: {{ Auth::user()->created_at->format('d M Y') }}
                    </p>

                    <hr>

                    <div class="d-grid">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 rounded-pill">
                                <i class="bi bi-box-arrow-left me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: FORM EDIT PROFIL --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-gear-fill me-2"></i>Edit Informasi Akun</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Upload Foto --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">Ganti Foto Profil</label>
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB.</small>
                        </div>

                        {{-- Nama & Email --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled title="Email tidak dapat diubah">
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold text-danger mb-3"><i class="bi bi-shield-lock me-2"></i>Ganti Password (Opsional)</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Password Baru</label>
                                <input type="password" class="form-control" name="password" placeholder="Kosongkan jika tidak ingin ubah">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-danger px-4 py-2 fw-bold rounded-pill shadow-sm">
                                <i class="bi bi-save-fill me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection