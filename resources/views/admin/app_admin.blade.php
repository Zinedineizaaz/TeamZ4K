<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dimsaykuu | @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        .dimsai-red {
            color: #dc3545;
        }

        .bg-dimsai-red {
            background-color: #dc3545 !important;
            color: white;
        }

        /* Gaya tambahan untuk tombol Login/Register agar terlihat bagus */
        .btn-dimsai-outline {
            color: white;
            border-color: white;
        }

        .btn-dimsai-outline:hover {
            color: #dc3545;
            background-color: white;
        }

        /* Highlight menu aktif */
        .nav-link.active {
            font-weight: bold;
            text-decoration: underline;
            text-underline-offset: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dimsai-red mb-4 shadow-sm">
        <div class="container">

            {{-- LOGO BRANDING UTAMA --}}
            <a class="navbar-brand text-white fw-bold" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock-fill me-2"></i>ADMIN Dimsaykuu
            </a>

            <button class="navbar-toggler text-white border-white" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto">

                    @auth
                        {{-- 1. DASHBOARD --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                               Dashboard
                            </a>
                        </li>

                        {{-- 2. KELOLA PRODUK --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                               href="{{ route('admin.products.index') }}">
                               Kelola Produk
                            </a>
                        </li>

                        {{-- 3. KELOLA PELANGGAN (User Biasa) --}}
                        {{-- Ini pengganti 'Kelola Admin' yang error tadi --}}
                        <li class="nav-item">
                            <a class="nav-link text-white {{ request()->routeIs('admin.manage.users') ? 'active' : '' }}" 
                               href="{{ route('admin.manage.users') }}">
                               Data Pelanggan
                            </a>
                        </li>

                        {{-- 4. KELOLA TIM ADMIN (HANYA POLICE/SUPERADMIN) --}}
                        @if(Auth::user()->role == 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold {{ request()->routeIs('admin.manage.admins') ? 'active' : '' }}" 
                               href="{{ route('admin.manage.admins') }}">
                               <i class="bi bi-shield-shaded me-1"></i> Tim Internal
                            </a>
                        </li>
                        @endif
{{-- === TOMBOL BARU: LIHAT WEBSITE === --}}
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold border border-warning rounded px-3 ms-2 me-2" 
                               href="{{ url('/') }}" target="_blank">
                                <i class="bi bi-globe me-1"></i> Lihat Website
                            </a>
                        </li>
                        {{-- ================================== --}}

                        {{-- 5. TOMBOL LOGOUT --}}
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-light ms-lg-3 mt-1" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>

                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        {{-- NAVIGASI JIKA BELUM LOGIN --}}
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

    <main class="container my-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>