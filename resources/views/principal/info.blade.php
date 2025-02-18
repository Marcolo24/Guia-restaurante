@extends('layouts.app')

@section('title', $restaurante->nombre)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <img src="{{ asset('storage/' . ($restaurante->imagen ?? 'restaurantes/default.jpg')) }}" 
                 class="img-fluid rounded" 
                 alt="{{ $restaurante->nombre }}"
                 style="max-height: 500px; width: 100%; object-fit: cover;">
        </div>
        <div class="col-md-4">
            <h1>{{ $restaurante->nombre }}</h1>
            <div class="current-rating mb-3">
                <div class="stars-display" data-rating="{{ number_format($valoracionMedia, 1) }}">
                    <div class="stars-foreground" style="width: {{ ($valoracionMedia/5)*100 }}%">★★★★★</div>
                </div>
                <span class="rating-value">{{ number_format($valoracionMedia, 1) }}/5</span>
                <small>({{ $restaurante->valoraciones->count() }} valoraciones)</small>
            </div>
            <p><strong>Tipo de comida:</strong> {{ $restaurante->tiposComida->first()->nombre ?? 'Sin especificar' }}</p>
            <p><strong>Precio medio:</strong> {{ $restaurante->precio_medio }}€</p>
            <p><strong>Barrio:</strong> {{ $restaurante->barrio->barrio ?? 'Sin especificar' }}</p>
            <p><strong>Dirección:</strong> {{ $restaurante->direccion }}</p>
            <p><strong>Teléfono:</strong> {{ $restaurante->telefono }}</p>
            @if($restaurante->web)
                <p><strong>Web:</strong> <a href="{{ $restaurante->web }}" target="_blank">{{ $restaurante->web }}</a></p>
            @endif
            <a href="{{ route('principal.index') }}" class="btn btn-secondary mt-3">Volver al listado</a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Valorar este restaurante</h3>
            @auth
                <div class="rating-form-container">
                    <form id="rating-form" action="{{ route('principal.valorar', $restaurante->id_restaurante) }}" method="POST">
                        @csrf
                        <div class="rating mb-3">
                            <input type="hidden" name="puntuacion" id="rating-value" value="0">
                            <div class="stars">
                                <button type="button" class="star" data-value="1">★</button>
                                <button type="button" class="star" data-value="2">★</button>
                                <button type="button" class="star" data-value="3">★</button>
                                <button type="button" class="star" data-value="4">★</button>
                                <button type="button" class="star" data-value="5">★</button>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="comentario" class="form-control" placeholder="Escribe tu opinión (opcional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar valoración</button>
                    </form>
                </div>
                <div class="comentarios mt-4">
                    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#comentariosCollapse" role="button" aria-expanded="false" aria-controls="comentariosCollapse" style="cursor: pointer;">
                        <h4 class="mb-0">Comentarios de usuarios</h4>
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-primary">Ver comentarios</span>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                        </div>
                    </div>
                    <div class="collapse" id="comentariosCollapse">
                        @if($restaurante->valoraciones->whereNotNull('comentario')->count() > 0)
                            @foreach($restaurante->valoraciones->whereNotNull('comentario') as $valoracion)
                                <div class="comentario border-bottom py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $valoracion->usuario->nombre ?? 'Usuario eliminado' }}</strong>
                                            <div class="stars-display" data-rating="{{ $valoracion->puntuacion }}">
                                                <span class="ms-2">({{ $valoracion->puntuacion }} estrellas)</span>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $valoracion->created_at->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mt-2 mb-0">{{ $valoracion->comentario }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No hay comentarios todavía.</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Inicia sesión</a> para valorar este restaurante.
                </div>
            @endauth
        </div>
    </div>
</div>

<style>
.stars {
    display: flex;
    gap: 5px;
}

.star {
    font-size: 30px;
    color: #ddd; /* Color de las estrellas no seleccionadas */
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: color 0.2s;
}

.star.selected {
    color: #ffd700; /* Color de las estrellas seleccionadas */
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('click', function(e) {
            e.preventDefault();
            const value = parseInt(this.dataset.value);

            // Limpiar todas las estrellas
            stars.forEach(s => s.classList.remove('selected'));

            // Marcar las estrellas hasta la seleccionada
            for (let i = 0; i < stars.length; i++) {
                if (parseInt(stars[i].dataset.value) <= value) {
                    stars[i].classList.add('selected');
                }
            }

            // Actualizar el valor del input oculto
            ratingInput.value = value;
            console.log('Valoración seleccionada:', value);
        });
    });
});
</script>
@endsection 