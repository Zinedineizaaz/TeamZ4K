@extends('admin.app_admin')

@section('title', 'Riwayat Admin Login')

@section('content')

{{-- Style Tambahan Khusus Halaman Ini --}}
<style>
    .avatar-initial {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .text-small {
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid px-0">
    
    {{-- HEADER HALAMAN --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1">
                <i class="bi bi-shield-lock me-2"></i>Data Pengguna & Admin
            </h2>
            <p class="text-muted mb-0">Pantau aktivitas login tim dan pengguna aplikasi.</p>
        </div>
        {{-- Tombol Refresh (Opsional) --}}
        <a href="{{ request()->url() }}" class="btn btn-light shadow-sm border text-secondary">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
        </a>
    </div>

    {{-- ALERT INFO --}}
    <div class="alert alert-light border-start border-danger border-5 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill text-danger fs-4 me-3"></i>
            <div>
                <strong>Informasi:</strong> Halaman ini menampilkan seluruh pengguna yang terdaftar di sistem.
                <br>
                <small class="text-muted">Urutan berdasarkan waktu login paling baru.</small>
            </div>
        </div>
    </div>

    {{-- CARD TABEL --}}
    <div class="card border-0 shadow-lg overflow-hidden" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Daftar Akun</h5>
                <span class="badge bg-danger rounded-pill px-3">Total: {{ count($admins) }} Akun</span>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-secondary text-small fw-bold">
                            <th class="px-4 py-3">Pengguna</th>
                            <th class="py-3">Role / Jabatan</th>
                            <th class="py-3">Login Terakhir</th>
                            <th class="py-3">Bergabung</th>
                            <th class="py-3 text-end px-4">ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                {{-- KOLOM 1: AVATAR & NAMA & EMAIL --}}
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        {{-- Avatar Inisial --}}
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=random&color=fff&bold=true" 
                                             alt="Avatar" 
                                             class="rounded-circle avatar-initial me-3 shadow-sm">
                                        
                                        {{-- Nama & Email --}}
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">{{ $admin->name }}</span>
                                            <span class="text-muted small">{{ $admin->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                {{-- KOLOM 2: ROLE (DIPERBAIKI DISINI) --}}
                                <td>
                                    @if($admin->role == 'superadmin')
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2">
                                            <i class="bi bi-shield-fill-check me-1"></i> KOMANDAN (POLICE)
                                        </span>
                                    @elseif($admin->role == 'admin')
                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-dark border border-warning px-3 py-2">
                                            <i class="bi bi-person-badge-fill me-1"></i> STAFF ADMIN
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary px-3 py-2">
                                            <i class="bi bi-person-fill me-1"></i> USER / PENGUNJUNG
                                        </span>
                                    @endif
                                </td>

                                {{-- KOLOM 3: LOGIN TERAKHIR --}}
                                <td>
                                    @if ($admin->last_login_at)
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark">
                                                {{ \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans() }}
                                            </span>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ \Carbon\Carbon::parse($admin->last_login_at)->format('d M Y, H:i') }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum Login</span>
                                    @endif
                                </td>

                                {{-- KOLOM 4: TANGGAL GABUNG --}}
                                <td>
                                    <span class="text-muted fw-medium">
                                        {{ $admin->created_at->format('d M Y') }}
                                    </span>
                                </td>

                                {{-- KOLOM 5: ID --}}
                                <td class="text-end px-4 text-muted fw-bold">
                                    #{{ $admin->id }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <i class="bi bi-inbox text-muted display-4 mb-3"></i>
                                        <h5 class="text-muted">Tidak ada data pengguna ditemukan.</h5>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer Card (Opsional untuk Pagination) --}}
        <div class="card-footer bg-white py-3">
            <small class="text-muted">Menampilkan seluruh data pengguna sistem.</small>
        </div>
    </div>
</div>
@endsection