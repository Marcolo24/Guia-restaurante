@extends('layouts.app')
{{-- Poner los titulos de las paginas --}}
@section('title', 'Menu principal')
@section('content')
    <div id="div-filtros">
        <div>
            <h1 class="titulo">Elige entre los mejores restaurantes de Barcelona</h1>
            <h2 class="subtitulo">El directorio foodie de Barcelona</h2>
        </div>
        <div id="divfiltros">
            <form action="{{ route('principal.index') }}" method="GET">
                <img class="imgfiltro" src="{{ asset('images/lupa.png') }}" alt="">
                <input type="text" name="busqueda" placeholder="Que buscas?" value="{{ request('busqueda') }}">
                
                <img class="imgfiltro" src="{{ asset('images/hamburguesa.png') }}" alt="">
                <select name="tipo_comida" class="form-select">
                    <option value="">Tipo de comida</option>
                    @foreach($tiposComida as $tipo)
                        <option value="{{ $tipo->nombre }}" {{ request('tipo_comida') == $tipo->nombre ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                
                <img class="imgfiltro" src="{{ asset('images/edificio.png') }}" alt="">
                <select name="barrio" class="form-select">
                    <option value="">Buscar por barrio</option>
                    @foreach($barrios as $barrio)
                        <option value="{{ $barrio->barrio }}" {{ request('barrio') == $barrio->barrio ? 'selected' : '' }}>
                            {{ $barrio->barrio }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="btn btn-danger">Buscar</button>
                
                @if(request('busqueda') || request('tipo_comida') || request('barrio'))
                    <a href="{{ route('principal.index') }}" class="btn btn-secondary">Reiniciar_Filtros</a>
                @endif
            </form>
        </div>
    </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center m-3">
            @if(isset($mensaje))
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        {{ $mensaje }}
                    </div>
                </div>
            @endif

            @foreach ($restaurantes as $restaurante)
                <div class="col">
                    <a href="{{ route('principal.show', $restaurante->id_restaurante) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 hover-shadow">
                            <img src="{{ asset('storage/' . ($restaurante->imagen ?? 'restaurantes/default.jpg')) }}" 
                                 class="card-img-top" 
                                 alt="{{ $restaurante->nombre }}">
                            <div class="card-body">
                                <h5 class="card-title"><strong>{{ $restaurante->nombre }}</strong></h5>
                                <p class="card-text">
                                    <strong>Tipo de comida:</strong> 
                                    {{ $restaurante->tiposComida->first()->nombre ?? 'Sin especificar' }}
                                </p>
                                <p class="card-text">
                                    <strong>Precio medio:</strong> 
                                    {{ $restaurante->precio_medio }}€
                                </p>
                                <p class="card-text">
                                    <strong>Barrio:</strong> 
                                    {{ $restaurante->barrio->barrio ?? 'Sin especificar' }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="carouselExampleCaptions" class="carousel slide carousel-dark">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="row justify-content-center">
                @for ($i = 1; $i <= 5; $i++)
                <div class="col-2">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card {{ $i }}</h5>
                            <p class="card-text">Contenido representativo para la tarjeta {{ $i }}.</p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="carousel-item">
            <div class="row justify-content-center">
                @for ($i = 6; $i <= 10; $i++)
                <div class="col-2">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card {{ $i }}</h5>
                            <p class="card-text">Contenido representativo para la tarjeta {{ $i }}.</p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
        <div class="carousel-item">
            <div class="row justify-content-center">
                @for ($i = 11; $i <= 15; $i++)
                <div class="col-2">
                    <div class="card">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card {{ $i }}</h5>
                            <p class="card-text">Contenido representativo para la tarjeta {{ $i }}.</p>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
    <div class="carousel-indicators" style="position: relative; z-index: 1; margin-top: 10px;">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <button class="carousel-control-prev flecha-carousel-izquierda" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next flecha-carousel-derecha" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
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