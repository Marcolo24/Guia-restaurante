<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
</head>
<body>

    <header>
        <h1>Bienvenidos a la Guía de Restaurantes</h1>
    </header>

    <main>
        @yield('content') <!-- Aquí se inyectará el contenido de las vistas hijas -->
    </main>

</body>
</html>
