<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AuthController;

// Ruta principal (página de inicio pública)
Route::get('/', [RestauranteController::class, 'principal'])->name('principal.index');

// Rutas para la gestión de restaurantes (admin)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes.index');
    Route::get('/restaurantes/create', [RestauranteController::class, 'create'])->name('restaurantes.create');
    Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
    Route::get('/restaurantes/{id}/edit', [RestauranteController::class, 'edit'])->name('restaurantes.edit');
    Route::put('/restaurantes/{id}', [RestauranteController::class, 'update'])->name('restaurantes.update');
    Route::delete('/restaurantes/{id}', [RestauranteController::class, 'destroy'])->name('restaurantes.destroy');
});

// Rutas de autenticación
Route::get('/login', function () {
    return view('principal.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Añadir ruta de logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
