@extends('layouts.app')

{{-- layouts.base ya agrega " | Semana de Sistemas 2026" al final --}}
@section('title', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">

        <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Volver a todas las actividades
        </a>

        <article class="card shadow-sm overflow-hidden">

            @if($post->main_image)
                <div class="ratio ratio-21x9">
                    <img src="{{ asset('storage/' . $post->main_image) }}" class="object-fit-cover"
                         alt="{{ $post->title }}">
                </div>
            @endif

            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    <span class="badge text-bg-primary fs-6">{{ $post->category->name }}</span>
                    <span class="text-body-secondary small">
                        Fecha de realización: <strong>{{ $post->activity_date->format('d/m/Y') }}</strong>
                    </span>
                </div>

                <h1 class="fw-bold mb-3">{{ $post->title }}</h1>

                <div class="p-3 bg-body-tertiary rounded border-start border-4 border-primary mb-4">
                    <div class="small text-body-secondary">Autores y participantes del equipo:</div>
                    <div class="fw-semibold">{{ $post->authors }}</div>
                </div>

                {{-- nl2br(e(...)) respeta los saltos de línea del texto y escapa el HTML --}}
                <div class="fs-5 lh-lg mb-5">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @if($post->images->count() > 0)
                    <hr class="my-4">
                    <h4 class="fw-bold mb-1">Evidencias de participación individual</h4>
                    <p class="text-body-secondary small mb-4">
                        Registro fotográfico y comprobantes de asistencia de los integrantes del equipo.
                    </p>

                    <div class="row g-3">
                        @foreach($post->images as $image)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank"
                                       rel="noopener" class="ratio ratio-4x3">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             class="card-img-top object-fit-cover"
                                             alt="Evidencia de {{ $image->participant_name }}">
                                    </a>
                                    <div class="card-body bg-body-tertiary">
                                        <span class="badge text-bg-secondary mb-1">{{ $image->participant_name }}</span>
                                        @if($image->caption)
                                            <p class="card-text small text-body-secondary mb-0">{{ $image->caption }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </article>
    </div>
</div>
@endsection
