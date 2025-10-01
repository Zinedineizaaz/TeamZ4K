<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimsaykuu | @yield('title', 'UMKM F&B')</title>

    {{-- Link Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Bootstrap Icons (Dibutuhkan untuk halaman About) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    {{-- Custom CSS untuk Tema Warna Dimsaykuu --}}
    <style>
        /* Definisi Variabel Warna Khusus */
        :root {
            --dimsai-red: #B83227; /* Merah Bata Agak Gelap */
            --dimsai-yellow: #FFC312; /* Kuning Mustard/Emas */
            --dimsai-bg-light: #FFF8E1; /* Kuning Sangat Pucat untuk latar belakang */
        }
        
        /* Terapkan Latar Belakang Pucat ke Body */
        body {
            background-color: var(--dimsai-bg-light);
        }

        /* Styling Custom Navbar (Merah Bata) */
        .navbar-dimsai {
            background-color: var(--dimsai-red) !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* Menggabungkan style navbar-brand agar teks dan logo berdampingan */
        .navbar-dimsai .navbar-brand {
            display: flex; /* Untuk menempatkan elemen sejajar */
            align-items: center; /* Untuk mensejajarkan vertikal */
            color: #ffffff !important; 
            transition: color 0.3s;
        }
        .navbar-dimsai .nav-link {
            color: #ffffff !important; 
            transition: color 0.3s;
        }
        .navbar-dimsai .nav-link:hover {
            color: var(--dimsai-yellow) !important; /* Hover Kuning Emas */
        }
        .navbar-logo-text {
            margin-left: 8px; /* Jarak antara logo dan teks */
            font-weight: bold;
            font-size: 1.5rem;
        }

        /* Styling Custom Footer (Merah Bata) */
        .footer-dimsai {
            background-color: var(--dimsai-red);
            color: #ffffff;
            padding: 1.5rem 0;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Styling Custom Button Primary (Kuning Mustard) */
        .btn-dimsai-primary {
            background-color: var(--dimsai-yellow);
            border-color: var(--dimsai-yellow);
            color: var(--dimsai-red); /* Teks Merah */
            font-weight: bold;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-dimsai-primary:hover {
            background-color: #e6b210; /* Sedikit lebih gelap saat hover */
            border-color: #e6b210;
            color: var(--dimsai-red);
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dimsai">
            <div class="container">
                
                {{-- PERUBAHAN DI SINI: Logo dan Teks Berdampingan --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- Gambar Logo --}}
                    <img src="{{ asset('images/logoku.png') }}" alt="Dimsaykuu Logo" style="height: 40px;"> 
                    {{-- Teks Dimsaykuu --}}
                    <span class="navbar-logo-text">Dimsaykuu</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/program') }}">Program</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/our-team') }}">Our Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact-us') }}">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-dimsai text-center">
        <div class="container">
            <p class="m-0">&copy; {{ date('Y') }} Dimsaykuu. Dimsum Lezat, Harga Bersahabat.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>