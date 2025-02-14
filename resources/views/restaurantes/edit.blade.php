@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Restaurante</h1>
        <form action="{{ route('restaurantes.update', $restaurante->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $restaurante->nombre }}" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" required>{{ $restaurante->descripcion }}</textarea>
            </div>
            <div class="mb-3">
                <label for="precio_medio" class="form-label">Precio Medio</label>
                <input type="number" name="precio_medio" class="form-control" value="{{ $restaurante->precio_medio }}" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ $restaurante->direccion }}" required>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="tipos_comida" class="form-label">Tipos de Comida</label>
                <select name="tipos_comida[]" class="form-control" multiple required>
                    @foreach ($tiposComida as $tipo)
                        <option value="{{ $tipo->id }}" {{ in_array($tipo->id, $restaurante->tiposComida->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Restaurante</button>
        </form>
    </div>
@endsection
