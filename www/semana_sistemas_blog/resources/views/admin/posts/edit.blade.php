@extends('layouts.admin')

@section('title', 'Editar Entrada - Semana de Sistemas 2026')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white fw-bold">Editar Actividad: {{ $post->title }}</div>
    <div class="card-body">
        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Título de la actividad *</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Categoría *</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Fecha de la actividad *</label>
                    <input type="date" name="activity_date" value="{{ old('activity_date', $post->activity_date->format('Y-m-d')) }}" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Autores (Nombres de ambos integrantes) *</label>
                    <input type="text" name="authors" value="{{ old('authors', $post->authors) }}" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado *</label>
                    <select name="status" class="form-select" required>
                        <option value="borrador" {{ old('status', $post->status) === 'borrador' ? 'selected' : '' }}>Borrador (Privado)</option>
                        <option value="publicado" {{ old('status', $post->status) === 'publicado' ? 'selected' : '' }}>Publicado (Público)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Cambiar Imagen Principal (Portada)</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*">
                    @if($post->main_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $post->main_image) }}" alt="Portada actual" class="rounded border" style="height: 100px;">
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <label class="form-label">Crónica, desarrollo y reflexión propia *</label>
                    <textarea name="content" rows="6" class="form-control" required>{{ old('content', $post->content) }}</textarea>
                </div>

                <hr class="my-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <h5 class="h6 mb-0 fw-bold">Agregar Nuevas Evidencias Individuales</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="add-evidence">+ Agregar evidencia</button>
                </div>

                <div id="evidence-container" class="col-12">
                    <div class="row g-2 mb-2 p-3 border rounded bg-light evidence-row">
                        <div class="col-md-4">
                            <label class="form-label small">Archivo de evidencia</label>
                            <input type="file" name="evidence_images[]" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Integrante acreditado</label>
                            <input type="text" name="evidence_participants[]" class="form-control form-control-sm" placeholder="Nombre del integrante">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Descripción breve</label>
                            <input type="text" name="evidence_captions[]" class="form-control form-control-sm" placeholder="Ej. Foto grupal o constancia">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary">Actualizar Entrada</button>
            </div>
        </form>
    </div>
</div>

@if($post->images->count() > 0)
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white fw-bold">Evidencias Guardadas Actualmente</div>
    <div class="card-body">
        <div class="row g-3">
            @foreach($post->images as $image)
                <div class="col-6 col-md-3">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" style="height: 140px; object-fit: cover;" alt="Evidencia">
                        <div class="card-body p-2">
                            <div class="fw-bold small">{{ $image->participant_name }}</div>
                            <div class="text-muted small mb-2">{{ $image->caption }}</div>
                            <form action="{{ route('admin.post-images.destroy', $image) }}" method="POST" onsubmit="return confirm('¿Eliminar esta evidencia?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">Eliminar foto</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    document.getElementById('add-evidence').addEventListener('click', function () {
        const container = document.getElementById('evidence-container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 p-3 border rounded bg-light evidence-row';
        row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label small">Archivo de evidencia</label>
                <input type="file" name="evidence_images[]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Integrante acreditado</label>
                <input type="text" name="evidence_participants[]" class="form-control form-control-sm" placeholder="Nombre del integrante">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Descripción breve</label>
                <input type="text" name="evidence_captions[]" class="form-control form-control-sm" placeholder="Ej. Constancia o selfie">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-evidence">X</button>
            </div>
        `;
        container.appendChild(row);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-evidence')) {
            e.target.closest('.evidence-row').remove();
        }
    });
</script>
@endpush