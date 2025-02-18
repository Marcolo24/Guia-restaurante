@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-5 color subtitulo">Editar Restaurante</h1>
            <div>
                <a href="{{ route('restaurantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
        <form class="size" action="{{ route('restaurantes.update', $restaurante->id_restaurante) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre_restaurante" class="form-label">Nombre del Restaurante</label>
                <input type="text" id="nombre_restaurante" name="nombre" class="form-control" value="{{ old('nombre', $restaurante->nombre) }}" required>
            </div>
            <div class="mb-3">
                <label for="descripcion_restaurante" class="form-label">Descripción</label>
                <input type="text" id="descripcion_restaurante" name="descripcion" class="form-control" value="{{ old('descripcion', $restaurante->descripcion) }}" required>
            </div>
            <div class="mb-3">
                <label for="precio_medio_restaurante" class="form-label">Precio Medio</label>
                <input type="number" id="precio_medio_restaurante" name="precio_medio" class="form-control" value="{{ old('precio_medio', $restaurante->precio_medio) }}" required>
            </div>
            <div class="mb-3">
                <label for="direccion_restaurante" class="form-label">Dirección</label>
                <input type="text" id="direccion_restaurante" name="direccion" class="form-control" value="{{ old('direccion', $restaurante->direccion) }}" required>
            </div>
            <div class="mb-3">
                <label for="telefono_restaurante" class="form-label">Teléfono</label>
                <input type="text" id="telefono_restaurante" name="telefono" class="form-control" value="{{ old('telefono', $restaurante->telefono) }}" required>
            </div>
            <div class="mb-3">
                <label for="web_restaurante" class="form-label">Sitio Web</label>
                <input type="text" id="web_restaurante" name="web" class="form-control" value="{{ old('web', $restaurante->web) }}">
            </div>
            <div class="mb-3">
                <label for="imagen_restaurante" class="form-label">Foto del Restaurante</label>
                <input type="file" id="imagen_restaurante" name="imagen" class="form-control">
                @if($restaurante->imagen)
                    <img src="{{ asset('storage/' . $restaurante->imagen) }}" alt="Imagen actual" class="mt-2" style="max-width: 200px;">
                @endif
            </div>
            <div class="mb-3">
                <label for="id_barrio" class="form-label">Barrio</label>
                <select id="id_barrio" name="id_barrio" class="form-control" required>
                    <option value="">Seleccione un barrio</option>
                    @foreach ($barrios as $barrio)
                        <option value="{{ $barrio->id_barrio }}" {{ old('id_barrio', $restaurante->id_barrio) == $barrio->id_barrio ? 'selected' : '' }}>
                            {{ $barrio->barrio }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tipo_comida" class="form-label">Tipo de Comida</label>
                <select id="tipo_comida" name="tipo_comida" class="form-control" required>
                    <option value="">Seleccione un tipo de comida</option>
                    @foreach ($tiposComida as $tipo)
                        <option value="{{ $tipo->id_tipo_comida }}" {{ old('tipo_comida', $restaurante->tiposComida->first()->id_tipo_comida ?? '') == $tipo->id_tipo_comida ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Actualizar Restaurante</button>
        </form>
    </div>
@endsection
