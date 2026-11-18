@extends('layouts.admin')

@section('title', 'Entradas del Blog')
@section('heading', 'Entradas del Blog (' . $posts->count() . ' / 7 actividades)')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nueva Entrada
    </a>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-active">
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
                        <td>
                            @if($post->main_image)
                                <img src="{{ asset('storage/' . $post->main_image) }}" alt="Portada"
                                     width="55" height="40" class="rounded object-fit-cover">
                            @else
                                <span class="badge bg-body-tertiary text-body-secondary border">Sin foto</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $post->title }}</td>
                        <td><span class="badge text-bg-secondary">{{ $post->category->name }}</span></td>
                        <td>{{ $post->activity_date->format('d/m/Y') }}</td>
                        <td class="small">{{ $post->authors }}</td>
                        <td>
                            <span class="badge {{ $post->status === 'publicado' ? 'text-bg-success' : 'text-bg-warning' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta publicación y todas sus evidencias?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-body-secondary py-4">No hay entradas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection