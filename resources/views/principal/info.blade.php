@extends('layouts.app')

@section('title', $restaurante->nombre)

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <img src="{{ asset('storage/' . ($restaurante->imagen ?? 'restaurantes/default.jpg')) }}" 
                 class="img-fluid rounded" 
                 alt="{{ $restaurante->nombre }}"
                 style="max-height: 400px; width: 100%; object-fit: cover;">
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
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Valorar este restaurante</h3>
            @auth
                <div class="rating-form-container">
                    <form id="rating-form" action="{{ route('restaurantes.valorar', $restaurante->id_restaurante) }}" method="POST">
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
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="clear-rating">
                                Limpiar valoración
                            </button>
                        </div>
                        <div class="form-group mb-3">
                            <textarea name="comentario" class="form-control" placeholder="Escribe tu opinión (opcional)"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar valoración</button>
                    </form>
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
.rating {
    display: inline-block;
    margin-bottom: 20px;
}

.stars {
    display: flex;
    gap: 5px;
}

.star {
    font-size: 30px;
    color: #ddd;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    transition: color 0.2s;
}

.star:hover,
.star.active {
    color: #ffd700;
}

.star.active ~ .star {
    color: #ffd700;
}

#clear-rating {
    font-size: 12px;
    padding: 2px 8px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('rating-form');
    const stars = document.querySelectorAll('.star');
    const ratingInput = document.getElementById('rating-value');
    const clearButton = document.getElementById('clear-rating');
    let selectedRating = 0;

    function updateStars(value) {
        selectedRating = value;
        ratingInput.value = value;
        
        stars.forEach(star => {
            const starValue = parseInt(star.dataset.value);
            if (starValue <= value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });

        console.log('Puntuación seleccionada:', value);
    }

    // Limpiar valoración
    clearButton.addEventListener('click', function() {
        updateStars(0);
    });

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            updateStars(value);
        });
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = {
            puntuacion: selectedRating, // Ahora puede ser 0
            comentario: this.querySelector('textarea[name="comentario"]').value,
            _token: document.querySelector('meta[name="csrf-token"]').content
        };

        console.log('Enviando datos:', formData); // Debug

        fetch(this.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la valoración media mostrada
                const ratingValue = document.querySelector('.rating-value');
                const ratingCount = document.querySelector('.current-rating small');
                const starsForeground = document.querySelector('.stars-foreground');
                
                if (ratingValue) {
                    ratingValue.textContent = `${data.valoracionMedia.toFixed(1)}/5`;
                }
                
                if (ratingCount) {
                    ratingCount.textContent = `(${data.totalValoraciones} valoraciones)`;
                }
                
                if (starsForeground) {
                    starsForeground.style.width = `${(data.valoracionMedia/5)*100}%`;
                }
                
                alert('Valoración guardada correctamente');
                this.querySelector('textarea[name="comentario"]').value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar la valoración');
        });
    });
});
</script>
@endpush
@endsection 