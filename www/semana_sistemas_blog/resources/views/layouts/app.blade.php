<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog - Semana de Sistemas 2026 | UES FMO')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .hero-ues {
            background: linear-gradient(135deg, #8b1518 0%, #4a0b0d 60%, #1a1d20 100%);
        }
        .card-post {
            border-radius: 14px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-post:hover {
            transform: translateY(-6px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12) !important;
        }
        .badge-ues {
            background-color: #8b1518;
            color: #fff;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('blog.index') }}">
                <i class="bi bi-cpu-fill text-warning"></i>
                <span>Semana de Sistemas 2026</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#publicNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="publicNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('blog.index') }}">
                            <i class="bi bi-journal-richtext me-1"></i>Actividades
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm fw-semibold">
                            <i class="bi bi-speedometer2 me-1"></i>Panel Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Acceso Equipo
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-dark text-white-50 py-4 mt-5 border-top border-secondary">
        <div class="container text-center small">
            <p class="mb-1 text-white fw-semibold">
                <i class="bi bi-mortarboard-fill text-warning me-1"></i>
                Universidad de El Salvador — Facultad Multidisciplinaria Oriental
            </p>
            <p class="mb-0">Blog de Experiencias y Evidencias · Semana de Sistemas 2026 · Técnicas de Programación para Internet</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>