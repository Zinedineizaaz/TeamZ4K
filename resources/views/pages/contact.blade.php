@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('content')
    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Hubungi Dimsaykuu Sekarang!</h2>
            <p class="lead text-muted">Kami siap melayani pemesanan dan pertanyaan Anda dengan cepat dan ramah.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        
        {{-- Kartu Info Kontak --}}
        <div class="col-md-8 mb-5">
            <div class="card p-4 shadow-lg border-0" style="border-left: 8px solid var(--dimsai-yellow) !important;">
                <div class="card-body">
                    <h4 class="fw-bold mb-4" style="color: var(--dimsai-red);">Informasi Kontak Utama</h4>
                    
                    <ul class="list-group list-group-flush">
                        {{-- Telepon --}}
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-whatsapp display-6 me-3" style="color: #25D366;"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Pemesanan WhatsApp (Fast Response)</h6>
                                <a href="https://wa.me/6283136892742" target="_blank" class="text-decoration-none" style="color: var(--dimsai-red);">0831-3689-2742 (Klik untuk Chat)</a>
                            </div>
                        </li>
                        
                        {{-- Email --}}
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-envelope-fill display-6 me-3" style="color: var(--dimsai-red);"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Email Layanan Pelanggan</h6>
                                <span class="text-secondary">dimsaykuu.id@email.com</span>
                            </div>
                        </li>

                        {{-- Alamat --}}
                        <li class="list-group-item d-flex align-items-center bg-transparent">
                            <i class="bi bi-geo-alt-fill display-6 me-3" style="color: var(--dimsai-yellow);"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Alamat Utama Outlet</h6>
                                <span class="text-secondary">[Depan Kopi Posko, Jeruk Purut, Cilandak Timur Pasar Minggu, Jakarta Selatan]</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="col-md-8 text-center">
            <h4 class="mb-3" style="color: var(--dimsai-red);">Siap menikmati dimsum lezat?</h4>
            <a href="https://wa.me/6283136892742" target="_blank" class="btn btn-dimsai-primary btn-lg shadow-lg">
                <i class="bi bi-cart-check-fill me-2"></i> PESAN VIA WHATSAPP SEKARANG
            </a>
        </div>
    </div>
@endsection