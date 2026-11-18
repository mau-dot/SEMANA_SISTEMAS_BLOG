@extends('layouts.admin')

@section('title', 'Nueva Entrada')
@section('heading', 'Nueva Entrada')

@section('content')
<div class="card shadow-sm">
    <div class="card-header fw-bold">Registrar Nueva Actividad</div>
    <div class="card-body">

        @include('partials.form-errors')

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-8">
                    <label for="title" class="form-label">Título de la actividad *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="form-control @error('title') is-invalid @enderror"
                           placeholder="Ej. Ponencias de Inteligencia Artificial y Ciberseguridad" required>
                </div>
                <div class="col-md-4">
                    <label for="category_id" class="form-label">Categoría *</label>
                    <select name="category_id" id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">Seleccione...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="activity_date" class="form-label">Fecha de la actividad *</label>
                    <input type="date" name="activity_date" id="activity_date" value="{{ old('activity_date') }}"
                           class="form-control @error('activity_date') is-invalid @enderror" required>
                </div>
                <div class="col-md-5">
                    <label for="authors" class="form-label">Autores (Nombres de ambos integrantes) *</label>
                    <input type="text" name="authors" id="authors" value="{{ old('authors') }}"
                           class="form-control @error('authors') is-invalid @enderror"
                           placeholder="Ej. Manuel Pérez y Carlos López" required>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Estado *</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="borrador" {{ old('status') === 'borrador' ? 'selected' : '' }}>Borrador (Privado)</option>
                        <option value="publicado" {{ old('status') === 'publicado' ? 'selected' : '' }}>Publicado (Público)</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="main_image" class="form-label">Imagen Principal (Portada)</label>
                    <input type="file" name="main_image" id="main_image"
                           class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                </div>

                <div class="col-12">
                    <label for="content" class="form-label">Crónica, desarrollo y reflexión propia *</label>
                    <textarea name="content" id="content" rows="6"
                              class="form-control @error('content') is-invalid @enderror"
                              placeholder="Describe los hechos reales, expositores/herramientas y tu aprendizaje..."
                              required>{{ old('content') }}</textarea>
                </div>

                <hr class="my-4">
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="h6 mb-0 fw-bold">Evidencias Individuales de Participación</h5>
                        <small class="text-body-secondary">Agrega fotografías propias o constancias identificando a cada integrante.</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="add-evidence">
                        <i class="bi bi-plus-lg me-1"></i>Agregar otra evidencia
                    </button>
                </div>

                <div id="evidence-container" class="col-12">
                    <div class="row g-2 mb-2 p-3 border rounded bg-body-tertiary evidence-row">
                        <div class="col-md-4">
                            <label class="form-label small">Archivo de evidencia (Foto/Constancia)</label>
                            <input type="file" name="evidence_images[]" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Integrante acreditado</label>
                            <input type="text" name="evidence_participants[]" class="form-control form-control-sm" placeholder="Nombre del integrante">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Descripción breve</label>
                            <input type="text" name="evidence_captions[]" class="form-control form-control-sm" placeholder="Ej. Asistencia al taller de redes">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Entrada</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('add-evidence').addEventListener('click', function () {
        const container = document.getElementById('evidence-container');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 p-3 border rounded bg-body-tertiary evidence-row';
        row.innerHTML = `
            <div class="col-md-4">
                <label class="form-label small">Archivo de evidencia (Foto/Constancia)</label>
                <input type="file" name="evidence_images[]" class="form-control form-control-sm" accept="image/*">
            </div>
            <div class="col-md-4">
                <label class="form-label small">Integrante acreditado</label>
                <input type="text" name="evidence_participants[]" class="form-control form-control-sm" placeholder="Nombre del integrante">
            </div>
            <div class="col-md-3">
                <label class="form-label small">Descripción breve</label>
                <input type="text" name="evidence_captions[]" class="form-control form-control-sm" placeholder="Ej. Constancia o selfie en evento">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-evidence" aria-label="Quitar evidencia">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-evidence');
        if (btn) {
            btn.closest('.evidence-row').remove();
        }
    });
</script>
@endpush