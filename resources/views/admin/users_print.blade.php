<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengguna - TeamZ4K</title>
    
    {{-- Kita pakai Bootstrap biar tabelnya rapi --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* CSS Khusus Cetak */
        @media print {
            /* Sembunyikan tombol cetak pas diprint */
            .no-print { display: none !important; }
            /* Paksa background warna (biar badge warna warni ke-print) */
            body { -webkit-print-color-adjust: exact; }
        }
        
        body { font-family: sans-serif; }
        .kop-surat { border-bottom: 3px double black; margin-bottom: 20px; padding-bottom: 10px; }
    </style>
</head>
<body onload="window.print()"> {{-- Otomatis muncul dialog print pas dibuka --}}

    <div class="container mt-4">
        
        {{-- Tombol Kembali (Akan hilang pas diprint) --}}
        <div class="no-print mb-4">
            <a href="{{ route('admin.manage.users') }}" class="btn btn-secondary">
                &larr; Kembali ke Dashboard
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak Lagi
            </button>
        </div>

        {{-- KOP SURAT ALA-ALA RESMI --}}
        <div class="text-center kop-surat">
            <h2 class="fw-bold mb-0">LAPORAN DATA PENGGUNA</h2>
            <h4 class="mb-0">DIMSAYKUU APP - TEAM Z4K</h4>
            <small>Jl. Kodingan No. 404, Server Localhost, Indonesia</small>
        </div>

        {{-- Info Tanggal Cetak --}}
        <div class="d-flex justify-content-between mb-3">
            <span><strong>Dicetak Oleh:</strong> {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})</span>
            <span><strong>Tanggal:</strong> {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
        </div>

        {{-- TABEL DATA --}}
        <table class="table table-bordered table-striped border-dark">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung Sejak</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        @if($user->role == 'superadmin')
                            <span class="badge bg-danger text-uppercase border border-dark text-dark bg-opacity-25">Police</span>
                        @elseif($user->role == 'admin')
                            <span class="badge bg-warning text-uppercase border border-dark text-dark bg-opacity-25">Staff</span>
                        @else
                            <span class="badge bg-light text-uppercase border border-dark text-dark">User</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Tanda Tangan (Biar kayak laporan beneran) --}}
        <div class="row mt-5">
            <div class="col-4 offset-8 text-center">
                <p>Mengetahui,</p>
                <br><br><br>
                <p class="fw-bold text-decoration-underline">{{ Auth::user()->name }}</p>
                <p>Kepala Divisi IT</p>
            </div>
        </div>

    </div>

</body>
</html>