@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Konten dashboard admin --}}
    <div class="row justify-content-center">
        <div class="col-lg-12"> 
            <div class="p-5 border rounded shadow-lg" style="background-color: white;">
                
                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="dimsai-red mb-0">
                        <i class="bi bi-speedometer2 me-3"></i>Selamat Datang, {{ Auth::user()->name }}!
                    </h1>
                    @if(Auth::user()->role == 'superadmin')
                        <span class="badge bg-danger fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-shield-lock-fill me-1"></i> POLICE MODE</span>
                    @else
                        <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill">
                            <i class="bi bi-person-badge-fill me-1"></i> STAFF ADMIN</span>
                    @endif
                </div>

                <p class="lead text-muted">
                    Area kontrol untuk mengelola konten dan data UMKM Dimsaykuu.
                </p>
                <p class="text-muted fst-italic">
                    Terakhir Login: {{ Auth::user()->last_login_at ? \Carbon\Carbon::parse(Auth::user()->last_login_at)->format('d M Y, H:i') : 'Baru saja' }}
                </p>

                <hr class="my-4">

                {{-- STATISTIK FINANSIAL (UPDATE BARU) --}}
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-cash-stack me-2"></i>Ringkasan Keuangan</h4>
                <div class="row mb-4">
                    {{-- Omzet --}}
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h6 class="card-title text-uppercase small">Total Omset (PAID)</h6>
                                <p class="card-text display-6 fw-bold">Rp {{ number_format($total_omset, 0, ',', '.') }}</p>
                                <small><i class="bi bi-check-circle-fill"></i> Dari {{ $pesanan_berhasil }} transaksi sukses</small>
                            </div>
                        </div>
                    </div>
                    {{-- Pesanan Sukses --}}
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h6 class="card-title text-uppercase small">Pesanan Berhasil</h6>
                                <p class="card-text display-6 fw-bold">{{ $pesanan_berhasil }}</p>
                                <small>Total transaksi selesai</small>
                            </div>
                        </div>
                    </div>
                    {{-- Pesanan Pending --}}
                    <div class="col-md-4">
                        <div class="card text-dark bg-info mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h6 class="card-title text-uppercase small">Pesanan Pending</h6>
                                <p class="card-text display-6 fw-bold">{{ $pesanan_pending }}</p>
                                <small>Menunggu konfirmasi Xendit</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sisipkan bagian ini setelah penutup Row Statistik Finansial dan sebelum Grafik Analitik --}}

<h4 class="fw-bold mb-3 text-dark mt-4"><i class="bi bi-cart-check me-2"></i>Riwayat Pembelian Terbaru</h4>
<a href="{{ route('admin.orders.export') }}" class="btn btn-success">
        <i class="fas fa-file-excel"></i> Export ke Excel (CSV)
    </a>
<div class="card border-0 shadow-sm mb-5">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Produk</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th class="pe-4">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_orders as $order)
                    <tr>
                        <td class="ps-4 small text-muted">#{{ $order->order_id_midtrans }}</td>
                        <td>
                            <div class="fw-bold">{{ $order->user->name ?? 'User Terhapus' }}</div>
                            <small class="text-muted">{{ $order->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ Str::limit($order->product_name, 30) }}</td>
                        <td class="fw-bold text-danger">Rp {{ number_format($order->price, 0, ',', '.') }}</td>
                        <td>
                            @if(in_array($order->status, ['PAID', 'SETTLEMENT', 'SUCCESS']))
                                <span class="badge bg-success rounded-pill px-3">LUNAS</span>
                            @elseif($order->status == 'PENDING')
                                <span class="badge bg-warning text-dark rounded-pill px-3">MENUNGGU</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="pe-4 small">{{ $order->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada transaksi terekam.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($recent_orders->count() > 0)
    <div class="card-footer bg-white text-center py-3 border-0">
        <a href="#" class="text-danger fw-bold text-decoration-none small">LIHAT SEMUA PESANAN <i class="bi bi-arrow-right ms-1"></i></a>
    </div>
    @endif
</div>

                {{-- GRAFIK ANALITIK (UPDATE BARU) --}}
                <div class="card border-0 shadow-sm mb-5" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="bi bi-graph-up-arrow me-2 text-danger"></i>Tren Penjualan (7 Hari Terakhir)</h5>
                        <div style="height: 300px;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- STATISTIK INVENTARIS (LAMA) --}}
                <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-archive me-2"></i>Inventaris & User</h4>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-danger mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-box-seam"></i> Total Produk</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_products }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-dark bg-warning mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-layers"></i> Total Stok</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_stock }}</p>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->role == 'superadmin')
                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3 shadow-sm h-100 border-0">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-people"></i> Total User</h5>
                                <p class="card-text display-6 fw-bold">{{ $total_users }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <h3 class="dimsai-red mb-3">Aksi Cepat</h3>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light h-100 border-start border-danger border-5 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kelola Produk</h5>
                                <p class="card-text text-secondary small">Tambah & edit menu dimsum.</p>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-danger btn-sm w-100 rounded-pill">
                                    <i class="bi bi-box-seam me-2"></i>Akses Produk
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card bg-light h-100 border-start border-primary border-5 border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Data Pelanggan</h5>
                                <p class="card-text text-secondary small">Lihat user yang terdaftar.</p>
                                <a href="{{ route('admin.manage.users') }}" class="btn btn-primary btn-sm w-100 rounded-pill">
                                    <i class="bi bi-people me-2"></i>Lihat Pelanggan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        @if(Auth::user()->role == 'superadmin')
                            <div class="card bg-light h-100 border-start border-dark border-5 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">Tim Internal</h5>
                                    <p class="card-text text-secondary small">Pantau aktivitas Staff Admin.</p>
                                    <a href="{{ route('admin.manage.admins') }}" class="btn btn-dark btn-sm w-100 rounded-pill">
                                        <i class="bi bi-shield-lock me-2"></i>Akses Tim Admin
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card bg-light h-100 border-start border-secondary border-5 border-0 shadow-sm" style="opacity: 0.6;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-muted"><i class="bi bi-lock-fill me-1"></i> Tim Internal</h5>
                                    <p class="card-text text-muted small">Menu dikunci (Police Only).</p>
                                    <button class="btn btn-secondary btn-sm w-100 disabled rounded-pill">
                                        <i class="bi bi-slash-circle me-2"></i>Akses Dibatasi
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                @if(Auth::user()->role == 'superadmin')
                <div class="card mt-4 shadow-sm border-0">
                    <div class="card-header bg-dark text-white rounded-top">
                        <i class="bi bi-eye-fill me-2"></i> <strong>Monitoring Aktivitas Login (Police View)</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Login Terakhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_logins as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'superadmin')
                                            <span class="badge bg-danger">Police</span>
                                        @elseif($user->role == 'admin')
                                            <span class="badge bg-secondary">Staff</span>
                                        @else
                                            <span class="badge bg-info text-dark">User</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Belum Login' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
                <p class="mt-4 text-end">
                    <small class="text-secondary">
                        Sistem Dimsaykuu v1.0 &bull; Role Anda: <strong>{{ ucfirst(Auth::user()->role) }}</strong>
                    </small>
                </p>

            </div>
        </div>
    </div>

    {{-- SCRIPTS UNTUK CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Mengambil data dari variabel PHP yang dikirim controller
            const labels = {!! json_encode($sales_data->pluck('date')) !!};
            const dataOmset = {!! json_encode($sales_data->pluck('total')) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: dataOmset,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#dc3545',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
@endsection