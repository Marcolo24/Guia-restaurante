<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AuthController;

// Rutas para la sección principal (pública)
Route::get('/', [RestauranteController::class, 'principal'])->name('principal.index');
Route::get('/principal/{id}', [RestauranteController::class, 'show'])->name('principal.show');
Route::post('/principal/{id}/valorar', [RestauranteController::class, 'valorar'])
    ->name('principal.valorar')
    ->middleware('auth');

// Rutas para la gestión de restaurantes (admin)
Route::middleware(['web', 'auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');
        Route::get('/restaurantes/create', [RestauranteController::class, 'create'])->name('restaurantes.create');
        Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
        Route::get('/restaurantes/{id}/edit', [RestauranteController::class, 'edit'])->name('restaurantes.edit');
        Route::put('/restaurantes/{id}', [RestauranteController::class, 'update'])->name('restaurantes.update');
        Route::delete('/restaurantes/{id}', [RestauranteController::class, 'destroy'])->name('restaurantes.destroy');
    });
});

// Rutas de autenticación
Route::get('/login', function () {
    return view('principal.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Añadir ruta de logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Nuevas rutas de registro
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
