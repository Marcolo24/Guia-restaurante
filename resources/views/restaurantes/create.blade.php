@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Restaurante</h1>

    <form action="{{ route('restaurantes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="nombre_restaurante" class="form-label">Nombre del Restaurante</label>
            <input type="text" id="nombre_restaurante" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_restaurante" class="form-label">Descripción</label>
            <input type="text" id="descripcion_restaurante" name="descripcion" class="form-control" value="{{ old('descripcion') }}" required>
        </div>

        <div class="mb-3">
            <label for="precio_medio_restaurante" class="form-label">Precio Medio</label>
            <input type="number" id="precio_medio_restaurante" name="precio_medio" class="form-control" value="{{ old('precio_medio') }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion_restaurante" class="form-label">Dirección</label>
            <input type="text" id="direccion_restaurante" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
        </div>

        <div class="mb-3">
            <label for="telefono_restaurante" class="form-label">Teléfono</label>
            <input type="text" id="telefono_restaurante" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
        </div>

        <div class="mb-3">
            <label for="web_restaurante" class="form-label">Sitio Web</label>
            <input type="text" id="web_restaurante" name="web" class="form-control" value="{{ old('web') }}">
        </div>

        <div class="mb-3">
            <label for="imagen_restaurante" class="form-label">Foto del Restaurante</label>
            <input type="file" id="imagen_restaurante" name="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="id_barrio" class="form-label">Barrio</label>
            <select id="id_barrio" name="id_barrio" class="form-control" required>
                <option value="">Seleccione un barrio</option>
                @foreach ($barrios as $barrio)
                    <option value="{{ $barrio->id_barrio }}" {{ old('id_barrio') == $barrio->id_barrio ? 'selected' : '' }}>
                        {{ $barrio->barrio }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo_comida" class="form-label">Tipo de Comida</label>
            <select id="tipo_comida" name="tipo_comida" class="form-control" required>
                <option value="">Seleccione un tipo de comida</option>
            <label for="tipo_comida" class="form-label">Tipos de Comida</label>
            <select name="tipo_comida[]" class="form-control" multiple required>
                @foreach ($tiposComida as $tipo)
                    <option value="{{ $tipo->id_tipo_comida }}" {{ old('tipo_comida') == $tipo->id_tipo_comida ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crear Restaurante</button>
    </form>
</div>
@endsection
