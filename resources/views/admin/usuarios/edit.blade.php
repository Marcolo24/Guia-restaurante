@extends('layouts.app')

@section('content')
<div class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mt-5 color subtitulo">Editar Usuario</h1>
        <div>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    @if(session('mensaje'))
        <div class="alert alert-{{ session('tipo') }} alert-dismissible fade show" role="alert">
            {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form class="size" action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')
        <style>
            .error-message {
                color: red;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }

            input.error, select.error {
                border-color: red !important;
            }
        </style>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}" required onblur="validateNombre(this)">
            <div id="nombreError" class="error-message"></div>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" id="correo" name="correo" class="form-control" value="{{ old('correo', $usuario->correo) }}" required onblur="validateEmail(this)">
            <div id="emailError" class="error-message"></div>
        </div>

        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
            <input type="password" id="contrasena" name="contrasena" class="form-control" onblur="validatePassword(this)">
            <div id="passwordError" class="error-message"></div>
        </div>

        <div class="mb-3">
            <label for="contrasena_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" id="contrasena_confirmation" name="contrasena_confirmation" class="form-control">
            <div id="passwordConfirmationError" class="error-message"></div>
        </div>

        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select id="id_rol" name="id_rol" class="form-control" required onblur="validateRol(this)">
                <option value="">Seleccione un rol</option>
                <option value="1" {{ (old('id_rol', $usuario->id_rol) == '1') ? 'selected' : '' }}>Administrador</option>
                <option value="2" {{ (old('id_rol', $usuario->id_rol) == '2') ? 'selected' : '' }}>Usuario</option>
            </select>
            <div id="rolError" class="error-message"></div>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Actualizar Usuario</button>
    </form>
</div>

<script>
function validateNombre(input) {
    const errorDiv = document.getElementById('nombreError');
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'El nombre es requerido';
        return false;
    } else if (input.value.length < 3) {
        input.classList.add('error');
        errorDiv.textContent = 'El nombre debe tener al menos 3 caracteres';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateEmail(input) {
    const errorDiv = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'El correo electrónico es requerido';
        return false;
    } else if (!emailRegex.test(input.value)) {
        input.classList.add('error');
        errorDiv.textContent = 'Introduce un correo electrónico válido';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validatePassword(input) {
    const errorDiv = document.getElementById('passwordError');
    if (input.value.trim() !== '' && input.value.length < 8) {
        input.classList.add('error');
        errorDiv.textContent = 'La contraseña debe tener al menos 8 caracteres';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validatePasswordConfirmation(input) {
    const errorDiv = document.getElementById('passwordConfirmationError');
    const password = document.getElementById('contrasena').value;
    if (password.trim() !== '' && input.value !== password) {
        input.classList.add('error');
        errorDiv.textContent = 'Las contraseñas no coinciden';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateRol(input) {
    const errorDiv = document.getElementById('rolError');
    if (input.value === '') {
        input.classList.add('error');
        errorDiv.textContent = 'Debes seleccionar un rol';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

document.getElementById('editForm').addEventListener('submit', function(event) {
    let isValid = true;
    
    isValid = validateNombre(document.getElementById('nombre')) && isValid;
    isValid = validateEmail(document.getElementById('correo')) && isValid;
    
    const password = document.getElementById('contrasena');
    if (password.value.trim() !== '') {
        isValid = validatePassword(password) && isValid;
        isValid = validatePasswordConfirmation(document.getElementById('contrasena_confirmation')) && isValid;
    }
    
    isValid = validateRol(document.getElementById('id_rol')) && isValid;

    if (!isValid) {
        event.preventDefault();
    }
});
</script>
@endsection 