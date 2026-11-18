{{-- El login NO usa layouts.app ni layouts.admin (no hay sesión ni navbar): extiende la base directamente --}}
@extends('layouts.base')

@section('title', 'Iniciar sesión')

@section('body')
<div class="d-flex align-items-center min-vh-100 bg-body text-body py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">

                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h4 text-center mb-1 fw-bold">
                            Semana de Sistemas <span class="text-warning">2026</span>
                        </h1>
                        <p class="text-body-secondary text-center small mb-4">Acceso Administrativo (FMO - UES)</p>

                        {{-- Mensajes de sesión (ej. "Sesión cerrada") --}}
                        @include('partials.flash')

                        @if($errors->any())
                            <div class="alert alert-danger py-2 small" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       autocomplete="email" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" name="password" id="password"
                                       class="form-control" autocomplete="current-password" required>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label small" for="remember">Mantener sesión iniciada</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Entrar al panel</button>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ url('/') }}" class="small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Volver al blog
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
