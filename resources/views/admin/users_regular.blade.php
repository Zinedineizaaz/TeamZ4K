@extends('admin.app_admin')

@section('title', 'Data Pelanggan')

@section('content')

<style>
    .avatar-small { width: 40px; height: 40px; object-fit: cover; }
</style>

<div class="container-fluid px-0">
    
    {{-- ALERT SUKSES HAPUS (Muncul kalau habis hapus user) --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-1"><i class="bi bi-people me-2"></i>Data Pelanggan</h2>
            <p class="text-muted mb-0">Daftar pengguna terdaftar (User).</p>
        </div>
        <span class="badge bg-primary rounded-pill fs-6 px-3">Total: {{ $users->count() }}</span>
    </div>

<div class="d-flex gap-2">
            {{-- BUTTON AKSES SAMPAH (HANYA POLICE) --}}
            @if(Auth::user()->role == 'superadmin')
                <a href="{{ route('admin.users.trash') }}" class="btn btn-outline-secondary position-relative">
                    <i class="bi bi-trash me-1"></i> Tong Sampah
                    {{-- Opsional: Badge jumlah sampah --}}
                    {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">!</span> --}}
                </a>
            @endif
            
            <span class="badge bg-primary rounded-pill fs-6 px-3 d-flex align-items-center">
                Total: {{ $users->count() }}
            </span>
        </div>
    </div>
    <br>

    <form action="{{ route('admin.manage.users') }}" method="GET" class="d-flex mb-3">
    <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email..." value="{{ request('search') }}">
    <button class="btn btn-primary" type="submit">Cari</button>
</form>
<br>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-people-fill me-2"></i> Daftar User
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-uppercase text-secondary small fw-bold">
                            <th class="px-4 py-3">Nama Pelanggan</th>
                            <th>Email</th>
                            <th>Bergabung Sejak</th>
                            <th class="text-center">Status</th>
                            @if(Auth::user()->role == 'superadmin')
                                <th class="text-center">Aksi (Police)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0d6efd&color=fff&bold=true" 
                                         class="rounded-circle avatar-small me-3 shadow-sm">
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        <small class="text-muted" style="font-size:10px;">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark border border-info px-3">User Aktif</span>
                            </td>

                            @if(Auth::user()->role == 'superadmin')
                                <td class="text-center">
                                    {{-- Pastikan Route Delete ini benar --}}
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin MENGHAPUS user {{ $user->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus User">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role == 'superadmin' ? '5' : '4' }}" class="text-center py-4 text-muted">
                                <i class="bi bi-search display-4 d-block mb-3 text-secondary"></i>
                                Tidak ada user yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div> {{-- Tutup table-responsive --}}
        </div> {{-- Tutup card-body --}}
        
        {{-- PAGINATION PINDAH KESINI (DILUAR TABEL) --}}
        <div class="card-footer bg-white py-3">
             <div class="d-flex justify-content-center">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>

    </div> {{-- Tutup Card --}}
</div> {{-- Tutup Container --}}
@endsection