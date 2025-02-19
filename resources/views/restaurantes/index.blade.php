@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-5 color subtitulo">Gestión de Restaurantes</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('principal.index') }}" class="btn btn-secondary">
                    Inicio
                </a>
                <a href="{{ route('usuarios.index') }}" class="btn btn-info text-white">
                    Gestionar Usuarios
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        @if(session('mensaje'))
            <div class="alert alert-{{ session('tipo') }} alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <a href="{{ route('restaurantes.create') }}" class="btn btn-primary">
            Crear Restaurante
        </a>
        <p class="subsubtitulo">Filtros:</p>

        <form method="GET" action="{{ route('restaurantes.index') }}" class="mb-4" style="font-size: 20px;">
            <div class="row" style="font-size: 20px;">
                <div class="col-md-2">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}" style="font-size: 20px;">
                </div>
                <div class="col-md-2">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción" value="{{ request('descripcion') }}" style="font-size: 20px;">
                </div>
                <div class="col-md-2">
                    <select name="barrio" class="form-control" style="font-size: 20px;">
                        <option value="">Barrio</option>
                        @foreach ($barrios as $barrio)
                            <option value="{{ $barrio->id_barrio }}" {{ request('barrio') == $barrio->id_barrio ? 'selected' : '' }}>
                                {{ $barrio->barrio }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="orden_precio" class="form-control" style="font-size: 20px;">
                        <option value="">Precio</option>
                        <option value="asc" {{ request('orden_precio') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                        <option value="desc" {{ request('orden_precio') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-success me-2" style="font-size: 20px;">Aplicar</button>
                    <a href="{{ route('restaurantes.index') }}" class="btn btn-danger" style="font-size: 20px; border-radius: 10px;">Limpiar filtros</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
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
                            <td data-label="Nombre">{{ $restaurante->nombre }}</td>
                            <td data-label="Descripción">{{ $restaurante->descripcion }}</td>
                            <td data-label="Precio Medio">{{ $restaurante->precio_medio }}</td>
                            <td data-label="Dirección">{{ $restaurante->direccion }}</td>
                            <td data-label="Teléfono">{{ $restaurante->telefono }}</td>
                            <td data-label="Web">{{ $restaurante->web }}</td>
                            <td data-label="Barrio">{{ $restaurante->barrio->barrio ?? 'Sin barrio' }}</td>
                            <td data-label="Tipo de Comida">{{ $restaurante->tiposComida->first()->nombre ?? 'Sin especificar' }}</td>
                            <td data-label="Acciones">
                                <div class="btn-group-vertical" role="group">
                                    <a href="{{ route('restaurantes.edit', $restaurante->id_restaurante) }}" 
                                       class="btn btn-warning btn-sm mb-1">Editar</a>
                                    
                                    <form action="{{ route('restaurantes.destroy', $restaurante->id_restaurante) }}" 
                                          method="POST" 
                                          style="display:inline;"
                                          onsubmit="confirmarEliminacion(event)">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmarEliminacion(event) {
            event.preventDefault();
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit();
                }
            });
        }
    </script>
@endsection