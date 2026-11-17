@extends('layouts.admin')

@section('title', 'Dashboard - Semana de Sistemas 2026')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Panel de Control</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ Nueva Entrada</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="text-muted small">Total Entradas</div>
            <div class="fs-2 fw-bold">{{ $totalPosts }} <span class="fs-6 text-muted">/ 7</span></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="text-muted small">Publicadas</div>
            <div class="fs-2 fw-bold text-success">{{ $publishedPosts }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="text-muted small">Borradores</div>
            <div class="fs-2 fw-bold text-warning">{{ $draftPosts }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="text-muted small">Categorías</div>
            <div class="fs-2 fw-bold text-primary">{{ $totalCategories }}</div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Últimas entradas registradas</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
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
                        <td><span class="badge bg-secondary">{{ $post->category->name }}</span></td>
                        <td>{{ $post->activity_date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $post->status === 'publicado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aún no hay publicaciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection