@extends('layouts.app')
{{-- Poner los titulos de las paginas --}}
@section('title', 'Menu principal')
@section('content')
    <div id="div-filtros">
        <div>
            <h1 id="titulo">Elige entre los mejores restaurantes de Barcelona</h1>
            <h2 id="subtitulo">El directorio foodie de Barcelona</h2>
        </div>
        <div id="divfiltros">
            <form action="">
                <img class="imgfiltro" src="{{ asset('images/lupablack.png') }}" alt="">
                <input type="text" placeholder="Que buscas?">
                <img class="imgfiltro" src="{{ asset('images/lupablack.png') }}" alt="">
                <select name="tipo_comida" class="form-select">
                    <option value="" selected>Tipo de comida</option>
                    <option value="italiana">Italiana</option>
                    <option value="japonesa">Japonesa</option>
                    <option value="mexicana">Mexicana</option>
                    <option value="mediterranea">Mediterránea</option>
                    <option value="china">China</option>
                </select>
                <img class="imgfiltro" src="{{ asset('images/lupablack.png') }}" alt="">
                <select name="barrio" class="form-select">
                    <option value="" selected>Buscar por barrio</option>
                    <option value="gracia">Gràcia</option>
                    <option value="eixample">Eixample</option>
                    <option value="sants">Sants</option>
                    <option value="gotico">Gótico</option>
                    <option value="born">Born</option>
                </select>
                <button type="submit" class="btn btn-danger">Buscar</button>
            </form>
        </div>
    </div>
    
<div>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center w-100 mt-5">
            @foreach ($restaurantes as $restaurante)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . ($restaurante->imagen ?? 'restaurantes/default.jpg')) }}" 
                             class="card-img-top" 
                             alt="{{ $restaurante->nombre }}"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurante->nombre }}</h5>
                            <p class="card-text">
                                <strong>Tipo de comida:</strong> 
                                {{ $restaurante->tiposComida->first()->nombre ?? 'Sin especificar' }}
                            </p>
                            <p class="card-text">
                                <strong>Precio medio:</strong> 
                                {{ $restaurante->precio_medio }}€
                            </p>
                            
                            <div class="rating">
                                <div class="stars">
                                    @guest
                                        <div class="text-muted mb-2">
                                            Inicia sesión para valorar
                                        </div>
                                    @else
                                        <form class="rating-form" action="{{ route('restaurantes.rate', $restaurante->id_restaurante) }}" method="POST">
                                            @csrf
                                            <div class="star-rating">
                                                @for ($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star{{ $i }}-{{ $restaurante->id_restaurante }}" 
                                                           name="rating" value="{{ $i }}">
                                                    <label for="star{{ $i }}-{{ $restaurante->id_restaurante }}">☆</label>
                                                @endfor
                                            </div>
                                        </form>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

    @push('scripts')
    <script>
    document.querySelectorAll('.rating-form input[type="radio"]').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
    </script>
    @endpush
@endsection
