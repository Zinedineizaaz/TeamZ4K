<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dimsaykuu | @yield('title', 'UMKM F&B')</title>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* === STYLE TOMBOL LOGIN & REGISTER ANDA === */
        .btn-dimsai-login {
            color: #fff !important;
            border: 2px solid #fff;
            border-radius: 50px;
            padding: 5px 20px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
        }
        .btn-dimsai-login:hover {
            background-color: #fff;
            color: #d32f2f !important;
        }

        .btn-dimsai-register {
            background-color: #ffc107;
            color: #000 !important;
            border: 2px solid #ffc107;
            border-radius: 50px;
            padding: 5px 20px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        .btn-dimsai-register:hover {
            background-color: #ffca2c;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
        }

        .profile-trigger {
            border: 1px solid rgba(255,255,255,0.5);
            background-color: rgba(255,255,255,0.1);
            color: #fff !important;
            border-radius: 50px;
            padding: 5px 15px 5px 5px;
            transition: 0.3s;
        }
        .profile-trigger:hover {
            background-color: rgba(255,255,255,0.2);
            border-color: #fff;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-dimsai">
            <div class="container">

                {{-- LOGO --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logoku.png') }}" alt="Dimsaykuu Logo" height="40">
                    <span class="navbar-logo-text ms-2 text-white fw-bold">Dimsaykuu</span>
                </a>

                {{-- TOGGLER --}}
                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- NAVBAR CONTENT --}}
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">

                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/program') }}">Program</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/menu') }}">Menu</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/our-team') }}">Our Team</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/contact-us') }}">Contact Us</a></li>

                        <div class="vr mx-3 d-none d-lg-block text-white opacity-50"></div>

                        {{-- ========== AUTH GUEST ========== --}}
                        @guest
                            <li class="nav-item mb-2 mb-lg-0">
                                <a class="btn-dimsai-login me-2" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn-dimsai-register" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus-fill me-2"></i>Register
                                </a>
                            </li>
                        @endguest

                        {{-- ========== AUTH USER ========== --}}
                        @auth
                            <li class="nav-item dropdown ms-lg-2">
                                <a class="nav-link dropdown-toggle d-flex align-items-center profile-trigger mt-2 mt-lg-0"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">

                                    {{-- Avatar User --}}
                                    <img src="{{ Auth::user()->avatar
                                            ? asset('storage/' . Auth::user()->avatar)
                                            : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=ffc107&color=000' }}"
                                         class="rounded-circle me-2 border border-white"
                                         width="32"
                                         height="32"
                                         style="object-fit: cover;">

                                    {{-- Nama User --}}
                                    <span class="fw-bold small">{{ explode(' ', Auth::user()->name)[0] }}</span>
                                </a>

                                {{-- Isi Dropdown --}}
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                                    <li>
                                        <h6 class="dropdown-header text-danger fw-bold">
                                            Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋
                                        </h6>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    
                                    @if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                                        <li>
                                            <a class="dropdown-item fw-bold text-danger" href="{{ url('/admin/dashboard') }}">
                                                <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <i class="bi bi-person-circle me-2 text-danger"></i>Profile Saya
                                        </a>
                                    </li>

                                    {{-- MENU TAMBAHAN: RIWAYAT PESANAN --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.history') }}">
                                            <i class="bi bi-clock-history me-2 text-danger"></i>Riwayat Pesanan
                                        </a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>
    </header>

    {{-- ================= CONTENT ================= --}}
    <main class="container my-5">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    <footer class="footer-dimsai text-center">
        <div class="container">
            <p class="m-0">
                &copy; {{ date('Y') }} Dimsaykuu. Dimsum Lezat, Harga Bersahabat.
            </p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>