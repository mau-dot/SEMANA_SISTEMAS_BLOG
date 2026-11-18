@extends('layouts.app')

@section('title', 'Bitácora de actividades')

{{-- ========== Portada a ancho completo (la pinta layouts.app antes del contenedor) ========== --}}
@section('hero')
<section class="bg-body text-body border-bottom py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-warning fw-semibold px-3 py-2 mb-3">
                    <i class="bi bi-building me-1"></i>UES · Facultad Multidisciplinaria Oriental
                </span>
                <h1 class="display-5 fw-bold mb-3">Bitácora Semana de Sistemas 2026</h1>
                <p class="lead text-body-secondary mb-0">
                    Crónicas reales, aprendizajes técnicos y evidencias individuales de participación en las actividades académicas, tecnológicas, deportivas y de convivencia.
                </p>
            </div>

            <div class="col-lg-4">
                @php $percent = min(100, round(($posts->total() / 7) * 100)); @endphp
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Actividades publicadas</span>
                            <span class="fw-bold">{{ $posts->total() }} / 7</span>
                        </div>
                        <div class="progress mb-2" role="progressbar" aria-label="Actividades publicadas"
                             aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="small text-body-secondary">
                            <i class="bi bi-people-fill me-1"></i>Equipo: Luis &amp; Mauricio
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- ========== Contenido (ya dentro de .container, no se repite) ========== --}}
@section('content')

    <!-- Buscador y filtro por categorías -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('blog.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                               placeholder="Buscar por título, actividad, contenido o autores..."
                               aria-label="Buscar entradas">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select" aria-label="Filtrar por categoría">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->posts_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i>Filtrar
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-x-lg"></i>
                            <span class="visually-hidden">Limpiar filtros</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Listado cronológico inverso -->
    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">

                    <div class="position-relative">
                        @if($post->main_image)
                            <div class="ratio ratio-16x9">
                                <img src="{{ asset('storage/' . $post->main_image) }}"
                                     class="card-img-top object-fit-cover" alt="{{ $post->title }}">
                            </div>
                        @else
                            <div class="ratio ratio-16x9 bg-body-tertiary">
                                <div class="d-flex flex-column align-items-center justify-content-center text-body-secondary">
                                    <i class="bi bi-image fs-1"></i>
                                    <span class="small mt-1">Sin imagen de portada</span>
                                </div>
                            </div>
                        @endif
                        <span class="badge text-bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 shadow-sm">
                            {{ $post->category->name }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="text-body-secondary small mb-2">
                            <i class="bi bi-calendar-event me-1"></i>{{ $post->activity_date->format('d/m/Y') }}
                        </div>

                        <h5 class="card-title fw-bold mb-2">{{ $post->title }}</h5>
                        <p class="card-text text-body-secondary small flex-grow-1">
                            {{ Str::limit($post->content, 130) }}
                        </p>

                        <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                            <small class="text-body-secondary text-truncate me-2" title="{{ $post->authors }}">
                                <i class="bi bi-person-check-fill me-1"></i>{{ $post->authors }}
                            </small>
                            <a href="{{ route('blog.show', $post) }}" class="btn btn-sm btn-primary rounded-pill px-3 flex-shrink-0">
                                Leer más <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-journal-x fs-1 text-body-secondary"></i>
                        <h5 class="fw-bold mt-3">No se encontraron actividades publicadas</h5>
                        <p class="text-body-secondary small mb-0">
                            Cambia el estado de tus entradas a <strong>"Publicado"</strong> desde el panel administrativo para que aparezcan aquí.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endsection