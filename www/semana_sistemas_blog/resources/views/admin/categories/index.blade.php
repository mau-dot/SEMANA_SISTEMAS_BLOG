@extends('layouts.admin')

@section('title', 'Categorías')
@section('heading', 'Gestión de Categorías')

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Nueva Categoría
    </a>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr class="table-active">
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Entradas asociadas</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-body-secondary small">{{ $category->slug }}</td>
                        <td><span class="badge text-bg-info">{{ $category->posts_count }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta categoría y sus entradas asociadas?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-body-secondary py-4">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection