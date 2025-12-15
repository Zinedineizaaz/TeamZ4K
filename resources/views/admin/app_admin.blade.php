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
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dimsai-red mb-4">
        <div class="container">

            {{-- LOGO BRANDING UTAMA --}}
            <a class="navbar-brand text-white fw-bold" href="{{ route('admin.dashboard') }}">ADMIN
                Dimsaykuu</a>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto">

                    @auth
                        {{-- NAVIGASI JIKA SUDAH LOGIN (ADMIN) --}}
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.products.index') }}">Kelola Produk</a>
                        </li>
                        <li class="nav-item">
                            {{-- Ubah teks dari 'Kelola User' --}}
                            <a class="nav-link text-white" href="{{ route('admin.users') }}">Kelola Admin</a>
                        </li>

                        {{-- TOMBOL LOGOUT --}}
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-light ms-3" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </a>

                            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        {{-- NAVIGASI JIKA BELUM LOGIN (GUEST) --}}
                        {{-- PERHATIAN: Tautan ini akan muncul di halaman Login/Register itu sendiri --}}
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
