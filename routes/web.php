<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

Route::get('/', [RestauranteController::class, 'index'])->name('restaurantes.index');
Route::get('restaurantes/create', [RestauranteController::class, 'create'])->name('restaurantes.create');
Route::post('restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
