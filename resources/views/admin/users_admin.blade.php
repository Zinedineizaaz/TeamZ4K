@extends('admin.app_admin')

@section('title', 'Kelola Tim Admin')

@section('content')

{{-- Style Khusus --}}
<style>
    .avatar-small { width: 40px; height: 40px; object-fit: cover; }
</style>

<div class="container-fluid px-0">
    
    {{-- HEADER MERAH (ADMIN) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1"><i class="bi bi-shield-lock me-2"></i>Tim Internal</h2>
            <p class="text-muted mb-0">Daftar Admin & Superadmin (Police).</p>
        </div>
        <span class="badge bg-danger rounded-pill fs-6 px-3">Total: {{ $admins->count() }}</span>
    </div>

    {{-- TABEL ADMIN --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-danger text-white">
            <i class="bi bi-person-lines-fill me-2"></i> Daftar Staff
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-secondary small fw-bold">
                            <th class="px-4 py-3">Nama</th>
                            <th>Jabatan</th>
                            <th>Email</th>
                            <th>Login Terakhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=dc3545&color=fff&bold=true" 
                                         class="rounded-circle avatar-small me-3 shadow-sm">
                                    <strong>{{ $admin->name }}</strong>
                                </div>
                            </td>
                            <td>
                                @if($admin->role == 'superadmin')
                                    <span class="badge bg-danger"><i class="bi bi-star-fill me-1"></i> POLICE</span>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-person-badge me-1"></i> STAFF</span>
                                @endif
                            </td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                {{ $admin->last_login_at ? \Carbon\Carbon::parse($admin->last_login_at)->diffForHumans() : 'Belum Login' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Tidak ada data admin.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection