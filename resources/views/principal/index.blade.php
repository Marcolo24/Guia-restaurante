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
            <form action="{{ route('principal.index') }}" method="GET">
                <img class="imgfiltro" src="{{ asset('images/lupablack.png') }}" alt="">
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
                    <a href="{{ route('principal.index') }}" class="btn btn-secondary">Limpiar filtros</a>
                @endif
            </form>
        </div>
    </div>
    
<div>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center w-100 mt-5">
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