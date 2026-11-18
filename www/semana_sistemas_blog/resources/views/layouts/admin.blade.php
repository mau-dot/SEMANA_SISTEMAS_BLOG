{{-- Layout del área administrativa: dashboard, posts/* y categories/* --}}
{{-- OJO: admin/auth/login NO usa este layout (no hay sesión). Usa layouts.base --}}
@extends('layouts.base')

@section('body')
    @php
        // AJUSTA los nombres a los de tu routes/web.php.
        $link = fn (string $name, array $params = []) => Route::has($name) ? route($name, $params) : '#';

        $menu = [
            ['label' => 'Panel',      'route' => 'admin.dashboard',        'active' => 'admin.dashboard'],
            ['label' => 'Entradas',   'route' => 'admin.posts.index',      'active' => 'admin.posts.*'],
            ['label' => 'Categorías', 'route' => 'admin.categories.index', 'active' => 'admin.categories.*'],
        ];
    @endphp

    <div class="container-fluid bg-body text-body">
        <div class="row">

            {{-- ========== Sidebar (offcanvas en móvil, fijo a la pantalla en escritorio) ========== --}}
            <aside class="col-lg-2 p-0 bg-body border-end">
                {{-- CAMBIO 1: se agregan sticky-lg-top y vh-100 --}}
                <div class="offcanvas-lg offcanvas-start bg-body text-body sticky-lg-top vh-100" tabindex="-1"
                    id="adminSidebar" aria-labelledby="adminSidebarLabel">

                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="adminSidebarLabel">Administración</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#adminSidebar" aria-label="Cerrar menú"></button>
                    </div>

                    {{-- CAMBIO 2: min-vh-100 se reemplaza por h-100 y overflow-y-auto --}}
                    <div class="offcanvas-body d-flex flex-column p-3 h-100 overflow-y-auto">
                        <a class="d-none d-lg-block text-body text-decoration-none fw-bold fs-5 mb-4"
                        href="{{ $link('admin.dashboard') }}">
                            Semana de Sistemas <span class="text-warning">2026</span>
                        </a>

                        <ul class="nav nav-pills flex-column gap-1">
                            @foreach ($menu as $item)
                                <li class="nav-item">
                                    {{-- El enlace activo usa el color del pill; los demás, text-body --}}
                                    <a class="nav-link {{ request()->routeIs($item['active']) ? 'active' : 'text-body' }}"
                                    href="{{ $link($item['route']) }}">{{ $item['label'] }}</a>
                                </li>
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link text-body" href="{{ $link('blog.index') }}"
                                target="_blank" rel="noopener">Ver el blog</a>
                            </li>
                        </ul>

                        <div class="mt-auto pt-3 border-top">
                            <div class="small mb-2">{{ auth()->user()->name ?? 'Usuario' }}</div>
                            <form method="POST" action="{{ $link('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- ========== Contenido ========== --}}
            <div class="col-lg-10 px-0">
                <header class="d-flex align-items-center gap-3 bg-body border-bottom px-4 py-3">
                    <button class="btn btn-outline-secondary d-lg-none" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#adminSidebar"
                            aria-controls="adminSidebar">Menú</button>

                    <h1 class="h4 mb-0">@yield('heading', 'Panel')</h1>

                    {{-- Botones de la página (ej. "Nueva entrada") --}}
                    <div class="ms-auto">@yield('actions')</div>
                </header>

                <main class="p-4">
                    @include('partials.flash')
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
@endsection