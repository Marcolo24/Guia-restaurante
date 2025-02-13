<?php

namespace App\Http\Controllers;

use App\Models\Restaurante; // Asegúrate de que el modelo Restaurante esté importado

class RestauranteController extends Controller
{
    /**
     * Muestra la lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todos los restaurantes de la base de datos
        $restaurantes = Restaurante::all();
        
        // Retornar la vista 'restaurantes.index' con los datos de los restaurantes
        return view('restaurantes.index', compact('restaurantes'));
    }
}
