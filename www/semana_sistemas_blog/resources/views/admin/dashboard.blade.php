@extends('layouts.admin')

{{-- layouts.base ya agrega " | Semana de Sistemas 2026" al final --}}
@section('title', 'Dashboard')

{{-- Título y botón de acción: los pinta el encabezado de layouts.admin --}}
@section('heading', 'Panel de Control')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nueva Entrada
    </a>
@endsection

@section('content')

<!-- Resumen -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 h-100">
            <div class="text-body-secondary small">Total Entradas</div>
            <div class="fs-2 fw-bold">{{ $totalPosts }} <span class="fs-6 text-body-secondary">/ 7</span></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 h-100">
            <div class="text-body-secondary small">Publicadas</div>
            <div class="fs-2 fw-bold text-success-emphasis">{{ $publishedPosts }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 h-100">
            <div class="text-body-secondary small">Borradores</div>
            <div class="fs-2 fw-bold text-warning-emphasis">{{ $draftPosts }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm text-center p-3 h-100">
            <div class="text-body-secondary small">Categorías</div>
            <div class="fs-2 fw-bold text-primary-emphasis">{{ $totalCategories }}</div>
        </div>
    </div>
</div>

<!-- Últimas entradas -->
<div class="card shadow-sm">
    <div class="card-header fw-bold">Últimas entradas registradas</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-active">
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Fecha Actividad</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPosts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td><span class="badge text-bg-secondary">{{ $post->category->name }}</span></td>
                        <td>{{ $post->activity_date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $post->status === 'publicado' ? 'text-bg-success' : 'text-bg-warning' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-body-secondary py-4">
                            Aún no hay publicaciones registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
