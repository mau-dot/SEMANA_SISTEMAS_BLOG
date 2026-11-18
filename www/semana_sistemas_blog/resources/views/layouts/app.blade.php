{{-- Layout del área pública: lo usan welcome, blog/index y blog/show --}}
@extends('layouts.base')

@section('body')
    @php
        // Si una ruta aún no existe devuelve '#', así la vista no se rompe.
        // AJUSTA los nombres a los de tu routes/web.php.
        $link = fn (string $name, array $params = []) => Route::has($name) ? route($name, $params) : '#';
    @endphp

    <div class="d-flex flex-column min-vh-100 bg-body text-body">

        {{-- ========== Navbar ========== --}}
        <nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ $link('home') }}">
                    Semana de Sistemas <span class="text-warning">2026</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mainNav" aria-controls="mainNav"
                        aria-expanded="false" aria-label="Abrir menú">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                               href="{{ $link('home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                               href="{{ $link('blog.index') }}">Entradas</a>
                        </li>
                    </ul>

                    {{-- Búsqueda: envía ?q=... a blog.index --}}
                    <form class="d-flex me-lg-3 mb-2 mb-lg-0" role="search" method="GET"
                          action="{{ $link('blog.index') }}">
                        <input class="form-control form-control-sm" type="search" name="q"
                               value="{{ request('q') }}" placeholder="Buscar entradas"
                               aria-label="Buscar entradas">
                        <button class="btn btn-sm btn-warning ms-2" type="submit">Buscar</button>
                    </form>

                    <div class="d-flex">
                        <button type="button" class="btn btn-sm btn-outline-secondary me-2" data-theme-toggle aria-label="Cambiar tema" title="Cambiar tema">
                            <i class="bi bi-moon-stars-fill"></i>
                        </button>
                        @auth
                            <a href="{{ $link('admin.dashboard') }}" class="btn btn-warning btn-sm fw-semibold">
                                <i class="bi bi-speedometer2 me-1"></i>Panel Admin
                            </a>
                        @else
                            <a href="{{ $link('login') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Acceso Equipo
                            </a>
                        @endauth
                    </div>

                </div>
            </div>
        </nav>

        {{-- Bloque opcional a ancho completo (ej. portada de welcome) --}}
        @yield('hero')

        {{-- ========== Contenido ========== --}}
        <main class="flex-grow-1 py-4 py-lg-5">
            <div class="container">
                @include('partials.flash')
                @yield('content')
            </div>
        </main>

        {{-- ========== Footer ========== --}}
        <footer class="bg-body border-top small py-4">
            <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
                <span>Universidad de El Salvador, Facultad Multidisciplinaria Oriental</span>
                <span>Técnicas de Programación para Internet, {{ date('Y') }}</span>
            </div>
        </footer>
    </div>
@endsection