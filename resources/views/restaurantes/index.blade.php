@extends('layouts.app')
{{-- Poner los titulos de las paginas --}}
@section('title', 'Menu principal')
@section('content')
    <div class="container">
        <h1>Lista de Restaurantes</h1>
        <a href="{{ route('restaurantes.create') }}" class="btn btn-primary">Crear Restaurante</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Medio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurantes as $restaurante)
                    <tr>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->descripcion }}</td>
                        <td>{{ $restaurante->precio_medio }}</td>
                        <td>
                            <a href="{{ route('restaurantes.edit', $restaurante->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('restaurantes.destroy', $restaurante->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
