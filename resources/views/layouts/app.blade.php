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
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-dimsai">
            <div class="container">

                {{-- LOGO --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logoku.png') }}" alt="Dimsaykuu Logo" height="40">
                    <span class="navbar-logo-text ms-2">Dimsaykuu</span>
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

                        {{-- MENU --}}
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/program') }}">Program</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/menu') }}">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/our-team') }}">Our Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/contact-us') }}">Contact Us</a></li>

                        {{-- ========== AUTH ========== --}}
                        @guest
                            <li class="nav-item ms-3">
                                <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>
                            <li class="nav-item ms-2">
                                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item dropdown ms-3">
                                <a class="nav-link dropdown-toggle d-flex align-items-center"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown">

                                    <img src="{{ Auth::user()->avatar
                                        ? asset('storage/avatars/' . Auth::user()->avatar)
                                        : asset('images/default-avatar.png') }}"
                                        class="rounded-circle me-2"
                                        width="32"
                                        height="32"
                                        style="object-fit: cover;">

                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth
                        {{-- ========== END AUTH ========== --}}

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
