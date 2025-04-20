<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laptop SMART - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .navbar-brand { font-weight: 600; }
        .main-container { min-height: 80vh; }
        .card-criteria { transition: transform 0.2s; }
        .card-criteria:hover { transform: translateY(-5px); }
        .progress { height: 25px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('bobot.create') }}">
                <i class="bi bi-laptop"></i> Laptop SMART
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bobot.create') }}">
                            <i class="bi bi-sliders"></i> Bobot Kriteria
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laptops.create') }}">
                            <i class="bi bi-plus-circle"></i> Tambah Laptop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('laptops.ranking') }}">
                            <i class="bi bi-trophy"></i> Ranking
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-container py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-light py-3 mt-4">
        <div class="container text-center">
            <p class="mb-0 text-muted">
                Sistem Pendukung Keputusan Pemilihan Laptop dengan Metode SMART
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>