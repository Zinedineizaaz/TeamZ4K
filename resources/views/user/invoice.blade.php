<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }} - Dimsaykuu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; font-family: sans-serif; }
        .invoice-card { max-width: 800px; margin: 30px auto; border-radius: 15px; border: none; }
        .watermark { position: absolute; top: 30%; left: 30%; font-size: 5rem; color: rgba(220, 53, 69, 0.1); transform: rotate(-30deg); font-weight: bold; pointer-events: none; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card invoice-card shadow-lg p-4 position-relative overflow-hidden">
            {{-- WATERMARK STATUS --}}
            @if(in_array(strtoupper($order->status), ['PAID', 'SETTLEMENT', 'SUCCESS']))
                <div class="watermark">LUNAS</div>
            @elseif(strtoupper($order->status) == 'PENDING')
                <div class="watermark text-warning">BELUM BAYAR</div>
            @else
                <div class="watermark text-secondary">{{ strtoupper($order->status) }}</div>
            @endif

            <div class="card-body">
                {{-- HEADER INVOICE --}}
                <div class="row mb-4 border-bottom pb-4 align-items-center">
                    <div class="col-6">
                        <h2 class="fw-bold text-danger mb-0"><i class="bi bi-receipt"></i> INVOICE</h2>
                        <small class="text-muted">Order ID: #{{ $order->id }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <h4 class="fw-bold text-dark">Dimsaykuu</h4>
                        <p class="small mb-0">Jalan Kuliner No. 1, Jakarta</p>
                        <p class="small mb-0">Email: support@dimsaykuu.com</p>
                    </div>
                </div>

                {{-- INFO PELANGGAN --}}
                <div class="row mb-4">
                    <div class="col-6">
                        <h6 class="fw-bold text-uppercase text-muted small">Ditagihkan Kepada:</h6>
                        <h5 class="fw-bold">{{ $order->user->name ?? 'Pelanggan Umum' }}</h5>
                        <p class="mb-0 text-muted">{{ $order->user->email ?? '-' }}</p>
                        @if(!empty($order->address))
                            <p class="mb-0 text-muted small mt-1"><i class="bi bi-geo-alt"></i> {{ $order->address }}</p>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="fw-bold text-uppercase text-muted small">Tanggal Pesanan:</h6>
                        <h5 class="fw-bold">{{ $order->created_at->format('d M Y') }}</h5>
                        <p class="mb-0 text-muted">{{ $order->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>

                {{-- TABEL PRODUK --}}
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Deskripsi Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $order->product_name }}</span>
                                </td>
                                <td class="text-center">1</td> {{-- Asumsi quantity 1, sesuaikan kalau ada kolom qty --}}
                                <td class="text-end">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total Pembayaran</td>
                                <td class="text-end fw-bold text-danger fs-5">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- FOOTER & TOMBOL --}}
                <div class="text-center mt-5 d-print-none">
                    <p class="small text-muted mb-4">Terima kasih sudah berbelanja di Dimsaykuu! Dimsum enak, hati senang.</p>
                    
                    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 me-2">
                        <i class="bi bi-printer"></i> Cetak Invoice
                    </button>
                    
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'police')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                    @else
                        <a href="{{ route('profile.history') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    {{-- ICON BOOTSTRAP --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</body>
</html>