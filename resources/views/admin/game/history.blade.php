@extends('layouts.admin') {{-- Sesuaikan dengan layout admin kamu --}}

@section('title', 'Riwayat Game Klakat')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">🎰 Riwayat Pemenang Game</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
            <h6 class="m-0 font-weight-bold text-white">Log Aktivitas User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Main</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Hadiah Didapat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{-- Format Tanggal Indonesia --}}
                                {{ \Carbon\Carbon::parse($history->created_at)->isoFormat('D MMMM Y, HH:mm') }} WIB
                            </td>
                            <td class="fw-bold">{{ $history->user->name }}</td>
                            <td>{{ $history->user->email }}</td>
                            <td>
                                @if(str_contains($history->prize, 'Zonk'))
                                    <span class="badge bg-secondary rounded-pill px-3">ZONK 😅</span>
                                @elseif(str_contains($history->prize, 'GRATIS'))
                                    <span class="badge bg-success rounded-pill px-3">JACKPOT! 🎉</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill px-3">{{ $history->prize }}</span>
                                @endif
                            </td>
                            <td><i class="bi bi-check-circle-fill text-success"></i> Selesai</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection