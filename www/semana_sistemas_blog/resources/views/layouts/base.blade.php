<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme = "dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tema claro/oscuro: aplica el tema guardado antes de pintar la página --}}
    <script>
        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
    </script>

    <title>@yield('title', 'Inicio') | {{ config('app.name', 'Blog Semana de Sistemas 2026') }}</title>
    <meta name="description" content="@yield('meta_description', 'Blog con las experiencias de la Semana de Sistemas 2026, Facultad Multidisciplinaria Oriental.')">

    {{-- Bootstrap 5 (único framework de estilos) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

     <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">


    {{-- Solo si más adelante hace falta un ajuste puntual: @push('styles') ... @endpush --}}
    @stack('styles')
</head>
<body class="bg-body-tertiary">

    {{-- Cada layout hijo (app / admin) rellena esta sección --}}
    @yield('body')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const root = document.documentElement;

            // Actualiza icono y textos de todos los botones de tema
            function updateButtons(theme) {
                document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
                    const label = theme === 'dark' ? 'Cambiar a tema claro' : 'Cambiar a tema oscuro';
                    btn.querySelector('i').className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
                    btn.setAttribute('aria-label', label);
                    btn.setAttribute('title', label);
                });
            }

            function setTheme(theme) {
                root.setAttribute('data-bs-theme', theme);
                try { localStorage.setItem('theme', theme); } catch (e) {}
                updateButtons(theme);
            }

            // Estado inicial (el script del <head> ya aplicó el tema guardado)
            updateButtons(root.getAttribute('data-bs-theme'));

            // Delegación de eventos: funciona con cualquier botón [data-theme-toggle]
            document.addEventListener('click', function (e) {
                if (e.target.closest('[data-theme-toggle]')) {
                    setTheme(root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
                }
            });
        })();
    </script>

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>


    {{-- JS específico de una vista: @push('scripts') ... @endpush --}}
    @stack('scripts')
</body>
</html>
