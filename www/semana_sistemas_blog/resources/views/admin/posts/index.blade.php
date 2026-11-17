@extends('layouts.admin')

@section('title', 'Entradas del Blog - Semana de Sistemas 2026')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">Entradas del Blog ({{ $posts->count() }} / 7 actividades)</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">+ Nueva Entrada</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Portada</th>
                    <th>Actividad / Título</th>
                    <th>Categoría</th>
                    <th>Fecha</th>
                    <th>Autores</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td style="width: 70px;">
                            @if($post->main_image)
                                <img src="{{ asset('storage/' . $post->main_image) }}" alt="Portada" class="rounded" style="width: 55px; height: 40px; object-fit: cover;">
                            @else
                                <span class="badge bg-light text-muted border">Sin foto</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $post->title }}</td>
                        <td><span class="badge bg-secondary">{{ $post->category->name }}</span></td>
                        <td>{{ $post->activity_date->format('d/m/Y') }}</td>
                        <td class="small">{{ $post->authors }}</td>
                        <td>
                            <span class="badge {{ $post->status === 'publicado' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta publicación y todas sus evidencias?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No hay entradas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection