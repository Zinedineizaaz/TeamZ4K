@extends('admin.app_admin')

@section('title', 'Dashboard')

@section('content')
    {{-- Konten dashboard admin --}}
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="p-5 border rounded shadow-lg" style="background-color: white;">
                
                <h1 class="dimsai-red mb-3">
                    <i class="bi bi-speedometer2 me-3"></i>Selamat Datang, Admin!
                </h1>

                <p class="lead text-muted">
                    Ini adalah area kontrol untuk mengelola konten dan data UMKM Dimsaykuu Anda.
                </p>

                <p class="text-muted fst-italic">
                    Terakhir diperbarui: {{ now()->format('d M Y, H:i') }}
                </p>

                <hr class="my-4">

                <h3 class="dimsai-red mb-3">Aksi Cepat</h3>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light h-100 border-start border-danger border-5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Kelola Produk Dimsum</h5>
                                <p class="card-text text-secondary">
                                    Tambah, lihat, edit, dan hapus menu dimsum yang tersedia.
                                </p>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-danger">
                                    <i class="bi bi-box-seam me-2"></i>Akses Produk
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light h-100 border-start border-warning border-5">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Lihat Data Admin</h5>
                                <p class="card-text text-secondary">
                                    Akses data Admin untuk melihat riwayat login mereka.
                                </p>
                                <a href="{{ route('admin.users') }}" class="btn btn-warning text-dark">
                                    <i class="bi bi-people me-2"></i>Akses Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-4">

                <p class="mt-3 text-end">
                    <small class="text-secondary">
                        Pastikan data Anda selalu terbarukan.
                    </small>
                </p>

            </div>
        </div>
    </div>
@endsection
