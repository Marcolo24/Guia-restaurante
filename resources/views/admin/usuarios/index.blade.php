@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-5 color subtitulo">Gestión de Usuarios</h1>
            <div>
                <a href="{{ route('restaurantes.index') }}" class="btn btn-info text-white">Gestionar Restaurantes</a>
                <a href="{{ route('principal.index') }}" class="btn btn-secondary">Volver a Inicio</a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Crear Nuevo Usuario</a>
        
        <!-- Filtros -->
        <p class="subsubtitulo">Filtros:</p>
        <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4" style="font-size: 20px;">
            <div class="row" style="font-size: 20px;">
                <div class="col-md-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}" style="font-size: 20px;">
                </div>
                <div class="col-md-3">
                    <input type="text" name="correo" class="form-control" placeholder="Correo" value="{{ request('correo') }}" style="font-size: 20px;">
                </div>
                <div class="col-md-3">
                    <select name="rol" class="form-control" style="font-size: 20px;">
                        <option value="">Rol</option>
                        <option value="1" {{ request('rol') == '1' ? 'selected' : '' }}>Admin</option>
                        <option value="2" {{ request('rol') == '2' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex">
                    <button type="submit" class="btn btn-success me-2" style="font-size: 20px;">Aplicar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-danger" style="font-size: 20px; border-radius: 10px;">Limpiar filtros</a>
                </div>
            </div>
        </form>

        @if(session('mensaje'))
            <div class="alert alert-{{ session('tipo') }} alert-dismissible fade show" role="alert">
                {{ session('mensaje') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table mt-3 text-center align-middle crud">
                <thead class="align-middle">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td data-label="ID">{{ $usuario->id_usuario }}</td>
                            <td data-label="Nombre">{{ $usuario->nombre }}</td>
                            <td data-label="Correo">{{ $usuario->correo }}</td>
                            <td data-label="Rol">{{ $usuario->id_rol == 1 ? 'Admin' : 'Usuario' }}</td>
                            <td data-label="Acciones">
                                <div class="btn-group-vertical" role="group">
                                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" 
                                       class="btn btn-warning btn-sm mb-1">Editar</a>
                                    
                                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" 
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

        @if($usuarios->hasPages())
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        @endif
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