@extends('layouts.app')

@section('title', 'Our Team')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h2 class="text-center mb-4 display-4 fw-bold" style="color: var(--dimsai-red);">Meet Our Team!</h2>
            <p class="text-center lead mb-5 text-muted">Tim solid di balik lezatnya setiap dimsum Dimsaykuu.</p>
            
            {{-- BAGIAN FOTO TIM KESELURUHAN --}}
            <div class="text-center mb-5">
                <img 
                    src="{{ asset('images/team.PNG') }}" 
                    alt="Foto Tim Dimsaykuu" 
                    class="img-fluid rounded-3 shadow-lg"
                    style="max-height: 400px; object-fit: cover; border: 5px solid var(--dimsai-yellow);"
                >
            </div>
            
            <h3 class="text-center mb-4" style="color: var(--dimsai-red);">Anggota Tim</h3>
            
            {{-- DAFTAR NAMA TIM (Struktur Sebelumnya) --}}
            <ul class="list-group shadow-lg">
                
                {{-- Anggota 1: Agus Saputra Hamzah --}}
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: var(--dimsai-red);">Agus Saputra Hamzah</h5>
                        <small class="text-secondary">2310120018</small>
                    </div>
                    <div>
                        <span class="badge bg-primary">Leader</span>
                    </div>
                </li>

                {{-- Anggota 2: Khairan Noor Fadhlillah --}}
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: var(--dimsai-red);">Khairan Noor Fadhlillah</h5>
                        <small class="text-secondary">2310120022</small>
                    </div>
                    <div>
                        <span class="badge bg-secondary">Member</span>
                    </div>
                </li>
                
                {{-- Anggota 3: Zinedine Daffa Izaaz --}}
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: var(--dimsai-red);">Zinedine Daffa Izaaz</h5>
                        <small class="text-secondary">2310120014</small>
                    </div>
                    <div>
                        <span class="badge bg-secondary">Member</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection