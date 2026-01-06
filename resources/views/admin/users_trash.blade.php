@extends('layouts.admin')

@section('title', 'Tong Sampah User')

@section('content')

<div class="container-fluid px-0">
    
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('admin.manage.users') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Data Pelanggan
        </a>
    </div>

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary fw-bold"><i class="bi bi-trash-fill me-2"></i>Tong Sampah (Deleted Users)</h2>
        <span class="badge bg-secondary rounded-pill fs-6 px-3">Total: {{ $deletedUsers->count() }}</span>
    </div>

    {{-- Tabel Sampah --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-secondary text-white">
            <i class="bi bi-recycle me-2"></i> Daftar User yang Dihapus
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-light">
                    <thead>
                        <tr class="text-uppercase small fw-bold text-muted">
                            <th class="px-4 py-3">Nama User</th>
                            <th>Email</th>
                            <th>Dihapus Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deletedUsers as $user)
                        <tr>
                            <td class="px-4 fw-bold text-secondary">{{ $user->name }}</td>
                            <td class="text-secondary">{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                    {{ $user->deleted_at->format('d M Y, H:i') }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- TOMBOL RESTORE (FRONTEND BUTTON) --}}
                                <a href="{{ route('admin.users.restore', $user->id) }}" 
                                   class="btn btn-success btn-sm fw-bold shadow-sm"
                                   onclick="return confirm('Kembalikan user ini agar bisa login lagi?')">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> RESTORE
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-emoji-smile display-4 d-block mb-3"></i>
                                Tong sampah kosong. Tidak ada user yang dihapus.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection