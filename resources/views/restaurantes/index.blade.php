@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Restaurantes</h1>
        <a href="{{ route('restaurantes.create') }}" class="btn btn-primary">Crear Restaurante</a>
        
        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Medio</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Web</th>
                    <th>Barrio</th>
                    <th>Acciones</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($restaurantes as $restaurante)
                    <tr>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->descripcion }}</td>
                        <td>{{ $restaurante->precio_medio }}</td>
                        <td>{{ $restaurante->direccion }}</td>
                        <td>{{ $restaurante->telefono }}</td>
                        <td>{{ $restaurante->web }}</td>
                        <td>{{ $restaurante->barrio->barrio ?? 'Sin barrio' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('restaurantes.edit', $restaurante->id_restaurante) }}" 
                                   class="btn btn-warning btn-sm">Editar</a>
                                
                                <form action="{{ route('restaurantes.destroy', $restaurante->id_restaurante) }}" 
                                      method="POST" 
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este restaurante?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
