@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 text-center mb-5">
            <h1 class="fw-bold text-danger display-5">EVENT KULINER TERBARU</h1>
            <p class="lead text-muted">Ayo mampir ke booth kami di lokasi paling hits Jakarta!</p>
            <div style="width: 80px; height: 4px; background: #dc3545; margin: 0 auto;"></div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6">
                        {{-- Menggunakan Gambar M-Bloc dari Tempo --}}
                        <div class="h-100" style="background-image: url('{{ asset($event['image']) }}'); 
     background-size: cover; 
     background-position: center; 
     min-height: 400px;
     border-radius: 15px 0 0 15px;">
</div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center bg-white">
                        <div class="card-body p-4 p-lg-5">
                            <span class="badge bg-danger px-3 py-2 mb-3 rounded-pill">PASAR LOKAL</span>
                            <h2 class="fw-bold text-dark mb-3">{{ $event['title'] }}</h2>
                            
                            <div class="mb-4">
                                <h5 class="text-danger fw-bold mb-1"><i class="bi bi-calendar-check me-2"></i>{{ $event['date'] }}</h5>
                                <p class="text-muted"><i class="bi bi-geo-alt-fill me-2"></i>{{ $event['location'] }}</p>
                            </div>

                            <p class="text-secondary lh-lg mb-4" style="text-align: justify;">
                                {{ $event['description'] }}
                            </p>
                            
                            <div class="d-grid gap-3 d-sm-flex">
                                <a href="https://wa.me/{{ $event['whatsapp'] }}?text=Halo%20Dimsaykuu,%20saya%20tertarik%20mampir%20ke%20booth%20di%20M-Bloc!" 
                                   target="_blank" 
                                   class="btn btn-success btn-lg rounded-pill px-4 shadow-sm flex-fill">
                                    <i class="bi bi-whatsapp me-2"></i> Hubungi Penjual
                                </a>
                                <a href="{{ route('menu') }}" class="btn btn-outline-danger btn-lg rounded-pill px-4 flex-fill">
                                    Lihat Menu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection