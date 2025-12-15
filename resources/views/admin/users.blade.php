@extends('admin.app_admin')

@section('title', 'Riwayat Admin Login')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="dimsai-red"><i class="bi bi-clock-history me-2"></i>Riwayat Admin Login</h2>
    </div>

    <div class="alert alert-info" role="alert">
        <i class="bi bi-info-circle me-2"></i> Halaman ini menampilkan riwayat login administrator berdasarkan waktu login
        terakhir.
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dimsai-red text-white fw-bold">Daftar Akun Administrator</div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Admin</th>
                        <th>Email</th>
                        <th>Login Terakhir</th>
                        <th>Bergabung Sejak</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if ($admin->last_login_at)
                                    {{ $admin->last_login_at->diffForHumans() }}
                                    ({{ $admin->last_login_at->format('Y-m-d H:i') }})
                                @else
                                    Belum pernah login
                                @endif
                            </td>
                            <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data admin ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
