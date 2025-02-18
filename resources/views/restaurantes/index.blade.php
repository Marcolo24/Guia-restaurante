@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-5 color subtitulo">Lista de Restaurantes</h1>
            <div>
                <a href="{{ route('principal.index') }}" class="btn btn-secondary">Volver a Principal</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <a href="{{ route('restaurantes.create') }}" class="btn btn-primary mb-3">Crear Restaurante</a>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <table class="table mt-3 text-center align-middle crud">
            <thead class="align-middle">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio Medio</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Web</th>
                    <th>Barrio</th>
                    <th>Tipo de Comida</th>
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
                        <td>{{ $restaurante->tiposComida->first()->nombre ?? 'Sin especificar' }}</td>
                        <td>
                            <div class="btn-group-vertical" role="group">
                                <a href="{{ route('restaurantes.edit', $restaurante->id_restaurante) }}" 
                                   class="btn btn-warning btn-sm mb-1">Editar</a>
                                
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