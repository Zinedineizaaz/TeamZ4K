@extends('admin.app_admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Konten dashboard admin --}}
    <div class="row justify-content-center">
        <div class="col-lg-12"> 
            <div class="p-5 border rounded shadow-lg" style="background-color: white;">
                
                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="dimsai-red mb-0">
                        <i class="bi bi-speedometer2 me-3"></i>Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    @if(Auth::user()->role == 'superadmin')
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-shield-lock-fill me-1"></i> POLICE MODE</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-person-badge-fill me-1"></i> STAFF ADMIN</span>
                    @endif
                </div>

                <p class="lead text-muted">
                    Area kontrol untuk mengelola konten dan data UMKM Dimsaykuu.
                </p>
                <p class="text-muted fst-italic">
                    Terakhir Login: {{ Auth::user()->last_login_at ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y, H:i') : 'Baru saja' }}
                </p>

                <hr class="my-4">

                {{-- STATISTIK RINGKAS --}}
                <div class="row mb-4">
                    {{-- Stat Produk --}}
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Produk</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_products }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Stat Stok --}}
                    <div class="col-md-4">
                        <div class="card text-dark bg-warning mb-3 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-layers"></i> Total Stok</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_stock }}</p>
                            </div>
                        </div>
                    </div>
                    {{-- Stat User (Hanya Police) --}}
                    @if(Auth::user()->role == 'superadmin')
                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-people"></i> Total User</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_users }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <h3 class="dimsai-red mb-3">Aksi Cepat</h3>

                {{-- UPDATE TERBARU: DIBAGI JADI 3 KOLOM AGAR RAPI --}}
                <div class="row">
                    
                    {{-- 1. KELOLA PRODUK (SEMUA BISA) --}}
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light h-100 border-start border-danger border-5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kelola Produk</h5>
                                <p class="card-text text-secondary small">
                                    Tambah & edit menu dimsum.
                                </p>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-danger btn-sm w-100">
                                    <i class="bi bi-box-seam me-2"></i>Akses Produk
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 2. KELOLA PELANGGAN (STAFF & POLICE BISA) --}}
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light h-100 border-start border-primary border-5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Data Pelanggan</h5>
                                <p class="card-text text-secondary small">
                                    Lihat user yang terdaftar.
                                </p>
                                <a href="{{ route('admin.manage.users') }}" class="btn btn-primary btn-sm w-100">
                                    <i class="bi bi-people me-2"></i>Lihat Pelanggan
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 3. KELOLA TIM ADMIN (KHUSUS POLICE) --}}
                    <div class="col-md-4 mb-3">
                        @if(Auth::user()->role == 'superadmin')
                            {{-- TAMPILAN POLICE (AKTIF) --}}
                            <div class="card bg-light h-100 border-start border-dark border-5">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Tim Internal</h5>
                                    <p class="card-text text-secondary small">
                                        Pantau aktivitas Staff Admin.
                                    </p>
                                    {{-- LINK INI SUDAH DIPERBAIKI --}}
                                    <a href="{{ route('admin.manage.admins') }}" class="btn btn-dark btn-sm w-100">
                                        <i class="bi bi-shield-lock me-2"></i>Akses Tim Admin
                                    </a>
                                </div>
                            </div>
                        @else
                            {{-- TAMPILAN STAFF (TERKUNCI) --}}
                            <div class="card bg-light h-100 border-start border-secondary border-5" style="opacity: 0.6;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-muted">
                                        <i class="bi bi-lock-fill me-1"></i> Tim Internal
                                    </h5>
                                    <p class="card-text text-muted small">
                                        Menu dikunci (Police Only).
                                    </p>
                                    <button class="btn btn-secondary btn-sm w-100 disabled" aria-disabled="true">
                                        <i class="bi bi-slash-circle me-2"></i>Akses Dibatasi
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- TABEL MONITORING (HANYA POLICE YANG BISA LIHAT) --}}
                @if(Auth::user()->role == 'superadmin')
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <i class="bi bi-eye-fill me-2"></i> <strong>Monitoring Aktivitas Login (Police View)</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Login Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_logins as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'superadmin')
                                            <span class="badge bg-danger">Police</span>
                                        @elseif($user->role == 'admin')
                                            <span class="badge bg-secondary">Staff</span>
                                        @else
                                            <span class="badge bg-info text-dark">User</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Belum Login' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
                {{-- FOOTER KECIL --}}
                <p class="mt-4 text-end">
                    <small class="text-secondary">
                        Sistem Dimsaykuu v1.0 &bull; Role Anda: <strong>{{ ucfirst(Auth::user()->role) }}</strong>
                    </small>
                </p>

            </div>
        </div>
    </div>
@endsection