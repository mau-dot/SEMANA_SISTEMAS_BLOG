@extends('layouts.app')

@section('content')
<section class="hero-ues text-white py-5 mb-4 shadow-sm">
    <div class="container py-2">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge bg-warning text-dark fw-semibold px-3 py-2 mb-3">
                    <i class="bi bi-building me-1"></i>UES · Facultad Multidisciplinaria Oriental
                </span>
                <h1 class="display-5 fw-bold mb-3">Bitácora Semana de Sistemas 2026</h1>
                <p class="lead text-white-50 mb-0">
                    Crónicas reales, aprendizajes técnicos y evidencias individuales de participación en las actividades académicas, tecnológicas, deportivas y de convivencia.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="card bg-dark bg-opacity-50 border-secondary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between small mb-1">
                            <span>Actividades publicadas</span>
                            <span class="fw-bold text-warning">{{ $posts->total() }} / 7</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            @php $percent = min(100, round(($posts->total() / 7) * 100)); @endphp
                            <div class="progress-bar bg-warning" style="width: {{ $percent }}%"></div>
                        </div>
                        <div class="small text-white-50">
                            <i class="bi bi-people-fill me-1"></i>Equipo: Luis &amp; Mauricio
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <!-- Buscador y Filtro por Categorías -->
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('blog.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Buscar por título, actividad, contenido o autores...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->posts_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="bi bi-funnel me-1"></i>Filtrar
                    </button>
                    @if(request()->filled('search') || request()->filled('category'))
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Listado Cronológico Inverso -->
    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm card-post">
                    <div class="position-relative">
                        @if($post->main_image)
                            <img src="{{ asset('storage/' . $post->main_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 210px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex flex-column align-items-center justify-content-center" style="height: 210px;">
                                <i class="bi bi-image fs-1 opacity-50"></i>
                                <span class="small mt-1">Sin imagen de portada</span>
                            </div>
                        @endif
                        <span class="badge badge-ues position-absolute top-0 start-0 m-3 px-3 py-2 shadow-sm">
                            {{ $post->category->name }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="text-muted small mb-2">
                            <i class="bi bi-calendar-event me-1"></i>{{ $post->activity_date->format('d/m/Y') }}
                        </div>

                        <h5 class="card-title fw-bold mb-2">{{ $post->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($post->content, 130) }}
                        </p>

                        <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                            <small class="text-muted text-truncate me-2" title="{{ $post->authors }}">
                                <i class="bi bi-person-check-fill text-dark me-1"></i>{{ $post->authors }}
                            </small>
                            <a href="{{ route('blog.show', $post) }}" class="btn btn-sm btn-dark rounded-pill px-3 flex-shrink-0">
                                Leer más <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-journal-x fs-1 text-muted"></i>
                        <h5 class="fw-bold text-muted mt-3">No se encontraron actividades publicadas</h5>
                        <p class="text-muted small mb-0">
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
</div>
@endsection