<?php
namespace App\Http\Controllers;

use App\Models\TipoComida;  // Importa el modelo TipoComida
use App\Models\Restaurante;
use Illuminate\Http\Request;

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
    public function create()
{
    $tiposComida = TipoComida::all(); // Asegúrate de obtener los tipos de comida desde la base de datos.
    
    return view('restaurantes.create', compact('tiposComida'));
}
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'foto' => 'nullable|image|max:2048', // Validación para la imagen
        'tipos_comida' => 'required|array',
        'tipos_comida.*' => 'exists:tipos_comida,id', // Validar que los tipos de comida existan
    ]);

    // Guardar el restaurante
    $restaurante = new Restaurante();
    $restaurante->nombre = $request->nombre;
    $restaurante->direccion = $request->direccion;
    
    // Subir la foto si existe
    if ($request->hasFile('foto')) {
        $path = $request->foto->store('restaurantes_fotos', 'public');
        $restaurante->foto = $path;
    }
    
    $restaurante->save();

    // Asociar tipos de comida al restaurante
    $restaurante->tiposComida()->sync($request->tipos_comida);

    return redirect()->route('restaurantes.index')->with('success', 'Restaurante creado con éxito.');
}

}