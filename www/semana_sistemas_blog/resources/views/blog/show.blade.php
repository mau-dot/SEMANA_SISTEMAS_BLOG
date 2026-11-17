@extends('layouts.app')

@section('title', $post->title . ' - Semana de Sistemas 2026')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Volver a todas las actividades</a>

            <article class="card border-0 shadow-sm overflow-hidden">
                @if($post->main_image)
                    <img src="{{ asset('storage/' . $post->main_image) }}" class="w-100" alt="{{ $post->title }}" style="max-height: 440px; object-fit: cover;">
                @endif

                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <span class="badge bg-primary fs-6">{{ $post->category->name }}</span>
                        <span class="text-muted small">Fecha de realización: <strong>{{ $post->activity_date->format('d/m/Y') }}</strong></span>
                    </div>

                    <h1 class="fw-bold mb-3">{{ $post->title }}</h1>

                    <div class="p-3 bg-light rounded border-start border-4 border-primary mb-4">
                        <div class="small text-muted">Autores y participantes del equipo:</div>
                        <div class="fw-semibold">{{ $post->authors }}</div>
                    </div>

                    <div class="fs-5 lh-lg mb-5" style="white-space: pre-line;">
                        {{ $post->content }}
                    </div>

                    @if($post->images->count() > 0)
                        <hr class="my-4">
                        <h4 class="fw-bold mb-1">Evidencias de Participación Individual</h4>
                        <p class="text-muted small mb-4">Registro fotográfico y comprobantes de asistencia de los integrantes del equipo.</p>

                        <div class="row g-3">
                            @foreach($post->images as $image)
                                <div class="col-md-6">
                                    <div class="card h-100 border">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="Evidencia de {{ $image->participant_name }}" style="height: 240px; object-fit: cover;">
                                        </a>
                                        <div class="card-body bg-light">
                                            <span class="badge bg-dark mb-1">{{ $image->participant_name }}</span>
                                            @if($image->caption)
                                                <p class="card-text small text-muted mb-0">{{ $image->caption }}</p>
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
</div>
@endsection