@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Dimsaykuu')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- SIDEBAR PROFIL --}}
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 sticky-top" style="top: 100px;">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=ffc107&color=000' }}"
                        class="rounded-circle mx-auto mb-3 shadow-sm"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                    <p class="small text-muted">{{ auth()->user()->email }}</p>
                    <div class="badge bg-light text-dark mb-3 rounded-pill px-3">
                        {{ ucfirst(auth()->user()->role ?? 'Pelanggan') }}</div>
                    <hr>
                    <a href="{{ route('profile') }}" class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                        <i class="bi bi-person-gear me-1"></i> Edit Profil
                    </a>
                </div>
            </div>

            {{-- DAFTAR PESANAN --}}
            <div class="col-md-9">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div
                        class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-clock-history me-2"></i>Riwayat Pesanan</h5>
                        <span class="badge bg-danger rounded-pill">{{ $orders->count() }} Pesanan</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light text-muted small text-uppercase">
                                    <tr>
                                        <th class="ps-4 py-3">Order ID</th>
                                        <th class="py-3">Produk & Tanggal</th>
                                        <th class="py-3">Total Bayar</th>
                                        <th class="py-3">Status Pembayaran</th>
                                        <th class="py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr class="align-middle">
                                            <td class="ps-4 fw-bold">#{{ substr($order->order_id_midtrans, -6) }}</td>
                                            <td>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">
                                                    {{ $order->product_name }}</div>
                                                <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>
                                                    {{ $order->created_at->format('d M Y, H:i') }}</small>
                                            </td>
                                            <td class="text-danger fw-bold">Rp {{ number_format($order->price, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php $status = strtoupper($order->status); @endphp

                                                {{-- STATUS PAID WARNA HIJAU --}}
                                                @if(in_array($status, ['PAID', 'SETTLEMENT', 'SUCCESS']))
                                                    <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">
                                                        <i class="bi bi-patch-check-fill me-1"></i> PAID
                                                    </span>
                                                @elseif($status == 'PENDING')
                                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($status == 'PENDING')
                                                    {{-- TOMBOL BAYAR JIKA BELUM LUNAS --}}
                                                    <a href="{{ $order->checkout_link }}" target="_blank"
                                                        class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm">
                                                        <i class="bi bi-wallet2 me-1"></i> Bayar
                                                    </a>
                                                @else
                                                    {{-- TOMBOL DETAIL JIKA SUDAH LUNAS --}}
                                                    <a href="{{ route('payment', $order->id) }}"
                                                        class="btn btn-outline-dark btn-sm rounded-pill px-3">
                                                        <i class="bi bi-receipt me-1"></i> Invoice
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bi bi-cart-x mb-3 d-block" style="font-size: 3rem; opacity: 0.2;"></i>
                                                <p class="mb-0">Belum ada riwayat transaksi.</p>
                                                <a href="{{ route('menu') }}"
                                                    class="btn btn-danger btn-sm mt-3 rounded-pill px-4">Pesan Dimsum
                                                    Sekarang</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3 small text-muted">
                    <i class="bi bi-info-circle me-1"></i> Status pembayaran diperbarui otomatis oleh sistem Xendit.
                </div>
            </div>
        </div>
    </div>
@endsection