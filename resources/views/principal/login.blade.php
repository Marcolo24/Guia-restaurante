<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        input.error {
            border-color: red !important;
        }
    </style>
</head>
<body class="bg-black">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="row w-75">
            <!-- Columna de la imagen -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <img src="{{ asset('images/bcnfoodieguide.jpg') }}" alt="BCN Foodie Guide" class="img-fluid object-fit-cover h-75">
            </div>
            <!-- Columna del formulario -->
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card w-75">
                    <div class="card-header text-center">
                        <h4>Iniciar Sesión</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" name="nombre" value="{{ old('nombre') }}" required
                                       onblur="validateNombre(this)">
                                <div id="nombreError" class="error-message"></div>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('contrasena') is-invalid @enderror" 
                                       id="contrasena" name="contrasena" required
                                       onblur="validateContrasena(this)">
                                <div id="contrasenaError" class="error-message"></div>
                                @error('contrasena')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary mb-2">Iniciar Sesión</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
                        </div>
                        <a href="{{ route('principal.index') }}" class="btn btn-secondary mt-2">Página principal</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts -->
    <script>
        function validateNombre(input) {
            const errorDiv = document.getElementById('nombreError');
            if (input.value.trim() === '') {
                input.classList.add('error');
                errorDiv.textContent = 'El nombre es requerido';
            } else if (input.value.length < 3) {
                input.classList.add('error');
                errorDiv.textContent = 'El nombre debe tener al menos 3 caracteres';
            } else {
                input.classList.remove('error');
                errorDiv.textContent = '';
            }
        }

        function validateContrasena(input) {
            const errorDiv = document.getElementById('contrasenaError');
            if (input.value.trim() === '') {
                input.classList.add('error');
                errorDiv.textContent = 'La contraseña es requerida';
            } else if (input.value.length < 6) {
                input.classList.add('error');
                errorDiv.textContent = 'La contraseña debe tener al menos 6 caracteres';
            } else {
                input.classList.remove('error');
                errorDiv.textContent = '';
            }
        }
    </script>
</body>
</html>
