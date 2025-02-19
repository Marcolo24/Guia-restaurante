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
                    <a href="{{ route('principal.index') }}" class="btn btn-secondary">Limpiar_filtros</a>
                @endif
            </form>
        </div>
    </div>


    <div id="carouselExampleCaptions" class="carousel slide carousel-dark m-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($tiposComida->filter(fn($tipo) => $tipo->restaurantes->count() > 0)->chunk(5) as $index => $tipoChunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        @foreach($tipoChunk as $tipo)
                            <div class="col-2">
                                <a href="{{ route('principal.index', ['tipo_comida' => $tipo->nombre]) }}" class="text-decoration-none">
                                    <div class="card text-center">
                                        <img src="{{ asset('images/chicken-rice.png') }}" class="card-img-top card-restaurantes mx-auto d-block" alt="{{ $tipo->nombre }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $tipo->nombre }}</h5>
                                            <p class="card-text">Número de restaurantes: {{ $tipo->restaurantes->count() }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="carousel-indicators" style="position: relative; z-index: 1; margin-top: 10px;">
            @foreach($tiposComida->filter(fn($tipo) => $tipo->restaurantes->count() > 0)->chunk(5) as $index => $tipoChunk)
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
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

<div class="m-5 mb-0">
    <p class="subtitulo color"><strong>Últimos restaurantes y bares añadidos</strong></p>
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