<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dimsaykuu | @yield('title')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* === COLOR PALETTE === */
        .dimsai-red { color: #dc3545; }
        .bg-dimsai-red { background-color: #dc3545 !important; color: white; }

        /* === BUTTON STYLES === */
        .btn-dimsai-outline {
            color: white;
            border-color: white;
        }
        .btn-dimsai-outline:hover {
            color: #dc3545;
            background-color: white;
        }

        /* === NAVBAR ACTIVE STATE === */
        /* Biar menu yang lagi dipilih kelihatan beda */
        .nav-link.active {
            font-weight: 800; /* Lebih tebal */
            text-decoration: underline;
            text-underline-offset: 5px;
            color: #ffc107 !important; /* Warna Kuning dikit biar kontras */
        }
        
        /* Hover effect halus */
        .nav-link:hover {
            color: #ffc107 !important;
            transition: 0.3s;
        }
    </style>
</head>

<body class="bg-light"> {{-- Kasih bg-light biar konten utama kontras --}}

    {{-- ================= NAVBAR START ================= --}}
    <nav class="navbar navbar-expand-lg bg-dimsai-red mb-4 shadow sticky-top">
        <div class="container">

            {{-- LOGO BRANDING --}}
            <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock-fill fs-4 me-2"></i>
                <span>ADMIN Dimsaykuu</span>
            </a>

            {{-- TOGGLER (MOBILE) --}}
            <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            {{-- MENU ITEMS --}}
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto align-items-center"> {{-- align-items-center biar rapi vertikal --}}

                    @auth
                        {{-- === BAGIAN 1: MENU UTAMA === --}}
                        
                        {{-- 1. Dashboard --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                               Dashboard
                            </a>
                        </li>

                        {{-- 2. Kelola Produk --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                               href="{{ route('admin.products.index') }}">
                               Produk
                            </a>
                        </li>

                        {{-- 3. Data Pelanggan --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.manage.users') ? 'active' : '' }}" 
                               href="{{ route('admin.manage.users') }}">
                               Pelanggan
                            </a>
                        </li>

                        {{-- 4. Riwayat Game (BARU - Disatukan disini biar rapi) --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.game.history') ? 'active' : '' }}" 
                               href="{{ route('admin.game.history') }}">
                               Riwayat Game
                            </a>
                        </li>

                        {{-- 5. Tim Internal (Hanya Superadmin) --}}
                        @if(Auth::user()->role == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.manage.admins') ? 'active' : '' }}" 
                               href="{{ route('admin.manage.admins') }}">
                               <i class="bi bi-shield-shaded"></i> Internal
                            </a>
                        </li>
                        @endif

                        {{-- PEMBATAS VERTICAL (Hanya di Desktop) --}}
                        <li class="nav-item d-none d-lg-block mx-2">
                            <div class="vr h-100 text-white opacity-50"></div>
                        </li>

                        {{-- === BAGIAN 2: TOMBOL AKSI (EXIT & LOGOUT) === --}}

                        {{-- Lihat Website (Button Kuning Outline) --}}
                        <li class="nav-item mt-2 mt-lg-0">
                            <a class="btn btn-sm btn-outline-warning fw-bold rounded-pill px-3 me-2" 
                               href="{{ url('/') }}" target="_blank" title="Lihat Tampilan User">
                                <i class="bi bi-globe me-1"></i> Web
                            </a>
                        </li>

                        {{-- Logout (Button Putih Outline) --}}
                        <li class="nav-item mt-2 mt-lg-0">
                            <a class="btn btn-sm btn-outline-light rounded-pill px-3" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>
                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>

                    @else
                        {{-- === JIKA BELUM LOGIN (Login/Register) === --}}
                        <li class="nav-item">
                            <a class="btn btn-sm btn-dimsai-outline me-2" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-dimsai-outline" href="{{ route('register') }}">
                                <i class="bi bi-person-plus-fill me-1"></i> Register
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
    {{-- ================= NAVBAR END ================= --}}

    {{-- KONTEN UTAMA --}}
    <main class="container my-5 pb-5">
        {{-- Flash Message (Opsional: Kalau mau nampilin notifikasi sukses/gagal global) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Scripts Tambahan (Kalau ada chart/sweetalert di halaman admin) --}}
    @yield('scripts')
</body>

</html>