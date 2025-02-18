@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mt-5 color subtitulo">Gestión de Usuarios</h1>
        <div class="d-flex gap-2">

            <a href="{{ route('restaurantes.index') }}" class="btn btn-info text-white">
                Gestionar Restaurantes
            </a>
            <a href="{{ route('principal.index') }}" class="btn btn-secondary">
                Volver a Inicio
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Cerrar Sesión
                </button>
            </form>

        </div>
    </div>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
        Crear Nuevo Usuario
    </a>
    @if(session('mensaje'))
        <div class="alert alert-{{ session('tipo') }} alert-dismissible fade show" role="alert">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Correo</th>
                    <th class="py-3 px-6 text-left">Rol</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach($usuarios as $usuario)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            {{ $usuario->id_usuario }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $usuario->nombre }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $usuario->correo }}
                        </td>
                        <td class="py-3 px-6 text-left">
                            {{ $usuario->id_rol == 1 ? 'Admin' : 'Usuario' }}
                        </td>

                        <td class="py-3 px-6 text-center">
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