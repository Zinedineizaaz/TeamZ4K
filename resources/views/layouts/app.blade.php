<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dimsaykuu | @yield('title', 'UMKM F&B')</title>

    {{-- Link CSS Eksternal --}}

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Link Bootstrap 5 CSS --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dimsai">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- Gambar Logo --}}
                    <img src="{{ asset('images/logoku.png') }}" alt="Dimsaykuu Logo" style="height: 40px;">
                    {{-- Teks Dimsaykuu --}}
                    <span class="navbar-logo-text">Dimsaykuu</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/program') }}">Program</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/menu') }}">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/our-team') }}">Our Team</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
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