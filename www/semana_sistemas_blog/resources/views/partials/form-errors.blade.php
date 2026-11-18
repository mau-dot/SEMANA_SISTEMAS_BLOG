{{-- Resumen de errores de validación. Usar dentro de <form>: @include('partials.form-errors') --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <p class="fw-semibold mb-2">Revisa los siguientes campos:</p>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
