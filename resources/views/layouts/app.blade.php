<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
    </style>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Aquí se carga el CSS -->
</head>
<header>
    <div>
        <h1 id="titulo-principal">BCNFoodieGuide</h1>
    </div>
    <div>
        @auth
            @if(Auth::user()->id_rol === 1)
                <a href="{{ route('restaurantes.index') }}" title="Panel de administración">
                    <img class="img-header" src="{{ asset('images/lista.png') }}" alt="Panel de administración">
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0;" title="Cerrar sesión">
                    <img class="img-header" src="{{ asset('images/sesion.png') }}" alt="Cerrar sesión">
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" title="Iniciar sesión">
                <img class="img-header" src="{{ asset('images/sesion.png') }}" alt="Iniciar sesión">
            </a>
        @endauth
    </div>
</header>
<body>
    <main>
        @yield('content') <!-- Aquí se inyectará el contenido de las vistas hijas -->
    </main>
</body>
</html>