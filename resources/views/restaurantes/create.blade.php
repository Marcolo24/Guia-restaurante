@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Restaurante</h1>

    <form action="{{ route('restaurantes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Restaurante</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto del Restaurante</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tipos_comida" class="form-label">Tipos de Comida</label>
            <select name="tipos_comida[]" class="form-control" multiple required>
                @foreach ($tiposComida as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crear Restaurante</button>
    </form>
</div>
@endsection
