<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dimsaykuu | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .dimsai-red { color: #dc3545; }
        .bg-dimsai-red { background-color: #dc3545 !important; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dimsai-red mb-4">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="{{ route('admin.dashboard') }}">ADMIN Dimsaykuu</a>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.products.index') }}">Kelola Produk</a></li>
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