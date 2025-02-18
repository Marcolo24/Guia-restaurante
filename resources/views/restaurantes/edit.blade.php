@extends('layouts.app')

@section('content')
    <div class="container mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mt-5 color subtitulo">Editar Restaurante</h1>
            <div>
                <a href="{{ route('restaurantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </div>
        <form class="size" action="{{ route('restaurantes.update', $restaurante->id_restaurante) }}" method="POST" enctype="multipart/form-data" id="editForm">
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
                <label for="nombre_restaurante" class="form-label">Nombre del Restaurante</label>
                <input type="text" id="nombre_restaurante" name="nombre" class="form-control" value="{{ old('nombre', $restaurante->nombre) }}" required onblur="validateNombre(this)">
                <div id="nombreError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="descripcion_restaurante" class="form-label">Descripción</label>
                <input type="text" id="descripcion_restaurante" name="descripcion" class="form-control" value="{{ old('descripcion', $restaurante->descripcion) }}" required onblur="validateDescripcion(this)">
                <div id="descripcionError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="precio_medio_restaurante" class="form-label">Precio Medio</label>
                <input type="number" id="precio_medio_restaurante" name="precio_medio" class="form-control" value="{{ old('precio_medio', $restaurante->precio_medio) }}" required onblur="validatePrecio(this)">
                <div id="precioError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="direccion_restaurante" class="form-label">Dirección</label>
                <input type="text" id="direccion_restaurante" name="direccion" class="form-control" value="{{ old('direccion', $restaurante->direccion) }}" required onblur="validateDireccion(this)">
                <div id="direccionError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="telefono_restaurante" class="form-label">Teléfono</label>
                <input type="text" id="telefono_restaurante" name="telefono" class="form-control" value="{{ old('telefono', $restaurante->telefono) }}" required onblur="validateTelefono(this)">
                <div id="telefonoError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="web_restaurante" class="form-label">Sitio Web</label>
                <input type="text" id="web_restaurante" name="web" class="form-control" value="{{ old('web', $restaurante->web) }}" required onblur="validateWeb(this)">
                <div id="webError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="imagen_restaurante" class="form-label">Foto del Restaurante</label>
                <input type="file" id="imagen_restaurante" name="imagen" class="form-control" onchange="validateImagen(this)">
                <div id="imagenError" class="error-message"></div>
                @if($restaurante->imagen)
                    <img src="{{ asset('storage/' . $restaurante->imagen) }}" alt="Imagen actual" class="mt-2" style="max-width: 200px;">
                @endif
            </div>

            <div class="mb-3">
                <label for="id_barrio" class="form-label">Barrio</label>
                <select id="id_barrio" name="id_barrio" class="form-control" required onblur="validateBarrio(this)">
                    <option value="">Seleccione un barrio</option>
                    @foreach ($barrios as $barrio)
                        <option value="{{ $barrio->id_barrio }}" {{ old('id_barrio', $restaurante->id_barrio) == $barrio->id_barrio ? 'selected' : '' }}>
                            {{ $barrio->barrio }}
                        </option>
                    @endforeach
                </select>
                <div id="barrioError" class="error-message"></div>
            </div>

            <div class="mb-3">
                <label for="tipo_comida" class="form-label">Tipo de Comida</label>
                <select id="tipo_comida" name="tipo_comida" class="form-control" required onblur="validateTipoComida(this)">
                    <option value="">Seleccione un tipo de comida</option>
                    @foreach ($tiposComida as $tipo)
                        <option value="{{ $tipo->id_tipo_comida }}" {{ old('tipo_comida', $restaurante->tiposComida->first()->id_tipo_comida ?? '') == $tipo->id_tipo_comida ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                <div id="tipoComidaError" class="error-message"></div>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Actualizar Restaurante</button>
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

function validateDescripcion(input) {
    const errorDiv = document.getElementById('descripcionError');
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'La descripción es requerida';
        return false;
    } else if (input.value.length < 10) {
        input.classList.add('error');
        errorDiv.textContent = 'La descripción debe tener al menos 10 caracteres';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validatePrecio(input) {
    const errorDiv = document.getElementById('precioError');
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'El precio es requerido';
        return false;
    } else if (input.value <= 0) {
        input.classList.add('error');
        errorDiv.textContent = 'El precio debe ser mayor que 0';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateDireccion(input) {
    const errorDiv = document.getElementById('direccionError');
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'La dirección es requerida';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateTelefono(input) {
    const errorDiv = document.getElementById('telefonoError');
    const telefonoRegex = /^[0-9]{9}$/;
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'El teléfono es requerido';
        return false;
    } else if (!telefonoRegex.test(input.value)) {
        input.classList.add('error');
        errorDiv.textContent = 'El teléfono debe tener 9 dígitos';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateWeb(input) {
    const errorDiv = document.getElementById('webError');
    const webRegex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
    if (input.value.trim() === '') {
        input.classList.add('error');
        errorDiv.textContent = 'El sitio web es requerido';
        return false;
    } else if (!webRegex.test(input.value)) {
        input.classList.add('error');
        errorDiv.textContent = 'Introduce una URL válida';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateImagen(input) {
    const errorDiv = document.getElementById('imagenError');
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (input.files.length > 0) {
        const file = input.files[0];
        if (!allowedTypes.includes(file.type)) {
            input.classList.add('error');
            errorDiv.textContent = 'Solo se permiten archivos JPG, JPEG o PNG';
            return false;
        } else if (file.size > maxSize) {
            input.classList.add('error');
            errorDiv.textContent = 'La imagen no debe superar los 5MB';
            return false;
        } else {
            input.classList.remove('error');
            errorDiv.textContent = '';
            return true;
        }
    }
    return true;
}

function validateBarrio(input) {
    const errorDiv = document.getElementById('barrioError');
    if (input.value === '') {
        input.classList.add('error');
        errorDiv.textContent = 'Debes seleccionar un barrio';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

function validateTipoComida(input) {
    const errorDiv = document.getElementById('tipoComidaError');
    if (input.value === '') {
        input.classList.add('error');
        errorDiv.textContent = 'Debes seleccionar un tipo de comida';
        return false;
    } else {
        input.classList.remove('error');
        errorDiv.textContent = '';
        return true;
    }
}

// Validación del formulario completo
document.getElementById('editForm').addEventListener('submit', function(event) {
    let isValid = true;
    
    isValid = validateNombre(document.getElementById('nombre_restaurante')) && isValid;
    isValid = validateDescripcion(document.getElementById('descripcion_restaurante')) && isValid;
    isValid = validatePrecio(document.getElementById('precio_medio_restaurante')) && isValid;
    isValid = validateDireccion(document.getElementById('direccion_restaurante')) && isValid;
    isValid = validateTelefono(document.getElementById('telefono_restaurante')) && isValid;
    isValid = validateWeb(document.getElementById('web_restaurante')) && isValid;
    isValid = validateImagen(document.getElementById('imagen_restaurante')) && isValid;
    isValid = validateBarrio(document.getElementById('id_barrio')) && isValid;
    isValid = validateTipoComida(document.getElementById('tipo_comida')) && isValid;

    if (!isValid) {
        event.preventDefault();
    }
});
</script>
@endsection
