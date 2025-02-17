<?php

namespace App\Http\Controllers;

use App\Models\TipoComida;
use App\Models\Restaurante;
use App\Models\Barrio; // Importa el modelo Barrio
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestauranteController extends Controller
{
    /**
     * Muestra la lista de restaurantes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener todos los restaurantes con la relación 'barrio'
        $restaurantes = Restaurante::with('barrio')->get(); // Carga la relación 'barrio'
        
        // Retornar la vista 'restaurantes.index' con los datos de los restaurantes
        return view('restaurantes.index', compact('restaurantes'));
    }

    public function create()
    {
        $tiposComida = TipoComida::all(); // Asegúrate de obtener los tipos de comida desde la base de datos.
        $barrios = Barrio::all(); // Obtener todos los barrios
        
        return view('restaurantes.create', compact('tiposComida', 'barrios')); // Pasar barrios a la vista
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio_medio' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'web' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'tipo_comida' => 'required|exists:tipo_comida,id_tipo_comida',
            'id_barrio' => 'required|exists:barrio,id_barrio',
        ]);

        // Guardar el restaurante
        $restaurante = new Restaurante();
        $restaurante->nombre = $request->nombre;
        $restaurante->descripcion = $request->descripcion;
        $restaurante->precio_medio = $request->precio_medio;
        $restaurante->direccion = $request->direccion;
        $restaurante->telefono = $request->telefono;
        $restaurante->web = $request->web;
        $restaurante->id_barrio = $request->id_barrio;
        
        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('restaurantes_fotos', 'public');
            $restaurante->imagen = $path;
        }
        
        $restaurante->save();

        // Asociar tipo de comida al restaurante
        $restaurante->tiposComida()->sync([$request->tipo_comida]);

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante creado con éxito.');
    }

    public function edit($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        $tiposComida = TipoComida::all();
        $barrios = Barrio::all();
        
        return view('restaurantes.edit', compact('restaurante', 'tiposComida', 'barrios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio_medio' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'web' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'tipo_comida' => 'required|exists:tipo_comida,id_tipo_comida',
            'id_barrio' => 'required|exists:barrio,id_barrio',
        ]);

        $restaurante = Restaurante::findOrFail($id);
        $restaurante->nombre = $request->nombre;
        $restaurante->descripcion = $request->descripcion;
        $restaurante->precio_medio = $request->precio_medio;
        $restaurante->direccion = $request->direccion;
        $restaurante->telefono = $request->telefono;
        $restaurante->web = $request->web;
        $restaurante->id_barrio = $request->id_barrio;

        if ($request->hasFile('imagen')) {
            $path = $request->imagen->store('restaurantes_fotos', 'public');
            $restaurante->imagen = $path;
        }

        $restaurante->save();

        // Actualizar tipo de comida
        $restaurante->tiposComida()->sync([$request->tipo_comida]);

        return redirect()->route('restaurantes.index')->with('success', 'Restaurante actualizado con éxito.');
    }

    public function destroy($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        
        // Eliminar la imagen si existe
        if ($restaurante->imagen) {
            Storage::disk('public')->delete($restaurante->imagen);
        }
        
        // Eliminar las relaciones con tipos de comida
        $restaurante->tiposComida()->detach();
        
        // Eliminar el restaurante
        $restaurante->delete();

        return redirect()->route('restaurantes.index')
            ->with('success', 'Restaurante eliminado con éxito.');
    }
}
