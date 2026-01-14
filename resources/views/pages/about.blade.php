@extends('layouts.app')

@section('title', 'About Us')

@section('content')

    {{-- ========================================== --}}
    {{-- BAGIAN 1: DESAIN ASLI KAMU (TIDAK DIUBAH)  --}}
    {{-- ========================================== --}}

    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center mb-5">
            <h2 class="display-4 fw-bold" style="color: var(--dimsai-red);">Mengenal Dimsaykuu Lebih Dekat</h2>
            <p class="lead text-muted">Kami hadir untuk menghadirkan pengalaman kuliner dimsum yang tak terlupakan dengan kualitas terbaik.</p>
        </div>
    </div>

    {{-- Section 1: Perkenalan dan Visi --}}
    <div class="row mb-5 p-4 rounded-3 shadow-sm" style="background-color: white;">
        <div class="col-md-6 mb-4 mb-md-0">
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-shop me-2"></i>Tentang Dimsaykuu</h3>
            <p class="text-secondary">Dimsaykuu adalah UMKM di bidang Food & Beverage yang berfokus pada penyediaan dimsum berkualitas dengan cita rasa **autentik dan harga terjangkau**. Kami berkomitmen menghadirkan pengalaman kuliner yang menyenangkan dengan menu dimsum yang bervariasi, higienis, dan sesuai selera masyarakat Indonesia.</p>
            
            <p class="mt-4">Kami percaya bahwa makanan berkualitas harus dapat dinikmati oleh semua kalangan, didukung oleh semangat tim yang solid dan inovasi rasa.</p>
            
            <a href="{{ url('/contact-us') }}" class="btn btn-dimsai-primary mt-3">
                <i class="bi bi-chat-dots-fill me-2"></i> Hubungi Kami Sekarang!
            </a>
        </div>
        <div class="col-md-6 border-start ps-md-5">
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-star-fill me-2"></i>Visi Kami</h3>
            <blockquote class="blockquote border-start border-3 ps-3 alert alert-dimsai-yellow" style="border-color: var(--dimsai-yellow) !important; background-color: #FFFBEA;">
                <p class="mb-0 fw-bold text-dark">"Menjadi brand dimsum lokal yang dipercaya dan dicintai konsumen di seluruh Indonesia."</p>
                <footer class="blockquote-footer mt-1 text-secondary">Dimsaykuu Commitment</footer>
            </blockquote>
            
            <h3 style="color: var(--dimsai-red);"><i class="bi bi-bookmark-check-fill me-2"></i>Misi Kami</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item bg-transparent">Menyediakan produk lezat dan sehat.</li>
                <li class="list-group-item bg-transparent">Memberikan pelayanan yang ramah dan cepat.</li>
                <li class="list-group-item bg-transparent">Terus berinovasi dalam menu dan layanan.</li>
            </ul>
        </div>
    </div>
    
    <hr class="my-5">

    {{-- Section 2: Nilai Kami dengan Ikon --}}
    <div class="row text-center mb-5">
        <div class="col-lg-12 mb-4">
            <h2 style="color: var(--dimsai-red);">Nilai Inti Dimsaykuu</h2>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <i class="bi bi-hand-thumbs-up-fill display-3 mb-3" style="color: var(--dimsai-red);"></i>
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Kualitas Bahan</h5>
                <p class="card-text text-muted">Kami hanya menggunakan bahan-bahan segar dan terbaik untuk menjamin rasa dimsum yang maksimal.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <i class="bi bi-check-circle-fill display-3 mb-3" style="color: var(--dimsai-yellow);"></i> 
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Higienis</h5>
                <p class="card-text text-muted">Proses pembuatan dan penyajian dimsum dilakukan sesuai standar kebersihan yang ketat dan terjamin.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 border-0 shadow-sm h-100">
                <i class="bi bi-tags-fill display-3 mb-3" style="color: var(--dimsai-red);"></i>
                <h5 class="card-title fw-bold" style="color: var(--dimsai-red);">Harga Kompetitif</h5>
                <p class="card-text text-muted">Menyediakan dimsum lezat berkualitas dengan harga yang sangat terjangkau untuk semua kalangan.</p>
            </div>
        </div>
    </div>

    {{-- ========================================== --}}
    {{-- BAGIAN 2: TAMBAHAN BARU (BIAR LEBIH RAME) --}}
    {{-- ========================================== --}}

    {{-- Section 3: Meet Our Team (Tim Kami) --}}
    <div class="py-5 bg-light rounded-4 mb-5 px-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--dimsai-red);">Tim Dibalik Layar 👨‍🍳</h2>
            <p class="text-muted">Orang-orang hebat yang meracik kebahagiaan untukmu.</p>
        </div>
        <div class="row justify-content-center">
            {{-- Zinedine --}}
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white p-4 rounded-3 shadow-sm h-100">
                    <img src="https://ui-avatars.com/api/?name=Achmad+Kholiq&background=d32f2f&color=fff&size=150" class="rounded-circle mb-3 shadow-sm border border-4 border-white" alt="Zinedine">
                    <h4 class="fw-bold">Achmad Kholiq</h4>
                    <p class="text-danger fw-bold">Founder & CEO</p>
                    <p class="text-muted small">"Memastikan setiap dimsum yang keluar dari dapur memiliki standar kualitas tertinggi."</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 4: FAQ (Pertanyaan Umum) --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <h2 class="text-center mb-4" style="color: var(--dimsai-red);">Sering Ditanyakan (FAQ)</h2>
            <div class="accordion shadow-sm" id="faqAccordion">
                
                {{-- FAQ 1 --}}
                <div class="accordion-item border-0 mb-2 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                            Apakah Dimsaykuu 100% Halal?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary">
                            <strong>Tentu saja!</strong> Seluruh bahan yang kami gunakan mulai dari daging ayam, udang, hingga bumbu-bumbu dijamin Halal dan tidak mengandung bahan non-halal.
                        </div>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="accordion-item border-0 mb-2 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                            Apakah bisa pesan untuk acara besar/catering?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary">
                            Bisa banget! Kami menyediakan paket <strong>Party Platter</strong> untuk acara ulang tahun, rapat kantor, atau kumpul keluarga. Hubungi WhatsApp kami untuk penawaran spesial.
                        </div>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="accordion-item border-0 mb-2 rounded overflow-hidden">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold text-dark bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                            Berapa lama dimsum tahan disimpan di kulkas?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-secondary">
                            Untuk dimsum frozen, bisa tahan hingga <strong>1 bulan</strong> di dalam freezer. Jika ditaruh di kulkas biasa (chiller), sebaiknya dikonsumsi dalam waktu 2 hari.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection