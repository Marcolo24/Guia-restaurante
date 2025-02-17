<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

Route::get('/', [RestauranteController::class, 'index'])->name('restaurantes.index');
Route::get('restaurantes/create', [RestauranteController::class, 'create'])->name('restaurantes.create');
Route::post('restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
Route::get('restaurantes/{id}/edit', [RestauranteController::class, 'edit'])->name('restaurantes.edit');
Route::put('restaurantes/{id}', [RestauranteController::class, 'update'])->name('restaurantes.update');
Route::delete('restaurantes/{id}', [RestauranteController::class, 'destroy'])->name('restaurantes.destroy');
