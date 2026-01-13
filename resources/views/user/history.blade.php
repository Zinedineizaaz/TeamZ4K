@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Dimsaykuu')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=ffc107&color=000' }}" 
                     class="rounded-circle mx-auto mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                <p class="small text-muted">{{ auth()->user()->email }}</p>
                <hr>
                <a href="{{ route('profile') }}" class="btn btn-outline-danger btn-sm w-100 rounded-pill">Edit Profil</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan Dimsum</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4 py-3">Order ID</th>
                                    <th class="py-3">Produk</th>
                                    <th class="py-3">Total Bayar</th>
                                    <th class="py-3">Status</th>
                                    <th class="py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr class="align-middle">
                                    <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $order->product_name }}</div>
                                        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                    </td>
                                    <td class="text-danger fw-bold">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $status = strtoupper($order->status);
                                        @endphp
                                        @if($status == 'PENDING')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Menunggu Pembayaran</span>
                                        @elseif(in_array($status, ['PAID', 'SETTLEMENT', 'SUCCESS']))
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Berhasil</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('payment', $order->id) }}" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x mb-3 d-block" style="font-size: 3rem; opacity: 0.3;"></i>
                                        Belum ada pesanan dimsum nih. <br>
                                        <a href="{{ route('menu') }}" class="btn btn-danger btn-sm mt-3 rounded-pill px-4">Pesan Sekarang</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection