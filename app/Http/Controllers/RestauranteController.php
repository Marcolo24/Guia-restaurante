<?php

namespace App\Http\Controllers;

use App\Models\TipoComida;
use App\Models\Restaurante;
use App\Models\Barrio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\Valoracion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RestauranteController extends Controller
{
    /**
     * Muestra la página principal pública con las cards de restaurantes
     */
    public function principal(Request $request)
    {
        // Iniciar la consulta con las relaciones necesarias
        $query = Restaurante::with(['barrio', 'tiposComida']);

        // Filtro por nombre/búsqueda general
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function($q) use ($busqueda) {
                $q->where('nombre', 'like', '%' . $busqueda . '%')
                  ->orWhere('descripcion', 'like', '%' . $busqueda . '%');
            });
        }

        // Filtro por tipo de comida
        if ($request->filled('tipo_comida')) {
            $query->whereHas('tiposComida', function($q) use ($request) {
                $q->where('nombre', $request->tipo_comida);
            });
        }

        // Filtro por barrio
        if ($request->filled('barrio')) {
            $query->whereHas('barrio', function($q) use ($request) {
                $q->where('barrio', $request->barrio);
            });
        }

        // Ejecutar la consulta
        $restaurantes = $query->get();
        
        // Obtener todos los tipos de comida y barrios para los selectores
        $tiposComida = TipoComida::all();
        $barrios = Barrio::all();

        return view('principal.index', compact('restaurantes', 'tiposComida', 'barrios'));
    }

    /**
     * Muestra la lista de restaurantes en el panel de administración
     */
    public function index(Request $request)
    {
        $query = Restaurante::query();

        // Aplicar filtros si están presentes
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('descripcion')) {
            $query->where('descripcion', 'like', '%' . $request->descripcion . '%');
        }

        if ($request->filled('barrio')) {
            $query->where('id_barrio', $request->barrio);
        }

        // Ordenar por precio medio si está presente
        if ($request->filled('orden_precio')) {
            $query->orderBy('precio_medio', $request->orden_precio);
        }

        $restaurantes = $query->get();
        $barrios = Barrio::all();

        return view('restaurantes.index', compact('restaurantes', 'barrios'));
    }

    public function create()
    {
        $tiposComida = TipoComida::all();
        $barrios = Barrio::all();
        return view('restaurantes.create', compact('tiposComida', 'barrios'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|min:3|unique:restaurante,nombre',
                'descripcion' => 'required|string|min:10',
                'precio_medio' => 'required|numeric|min:1',
                'direccion' => 'required|string|unique:restaurante,direccion',
                'telefono' => [
                    'required',
                    'regex:/^[0-9]{9}$/',
                    'unique:restaurante,telefono'
                ],
                'web' => 'required|string|unique:restaurante,web',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'id_barrio' => 'required|exists:barrio,id_barrio',
                'tipo_comida' => 'required|exists:tipo_comida,id_tipo_comida'
            ], [
                'nombre.unique' => 'Ya existe un restaurante con el nombre "' . $request->nombre . '". Por favor, elige otro nombre.',
                'direccion.unique' => 'Ya existe un restaurante en la dirección "' . $request->direccion . '". Por favor, verifica la dirección.',
                'telefono.unique' => 'El número de teléfono ' . $request->telefono . ' ya está registrado para otro restaurante.',
                'web.unique' => 'El sitio web ' . $request->web . ' ya está registrado para otro restaurante.',
                'telefono.regex' => 'El teléfono debe contener 9 dígitos numéricos.',
                'id_barrio.exists' => 'El barrio seleccionado no es válido.',
            ]);

            DB::transaction(function () use ($request) {
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
            });

            return redirect()->route('restaurantes.index')
                ->with('mensaje', 'El restaurante ha sido creado correctamente')
                ->with('tipo', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('mensaje', 'Error al crear el restaurante: ' . $e->getMessage())
                ->with('tipo', 'danger');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('mensaje', 'Error al crear el restaurante: ' . $e->getMessage())
                ->with('tipo', 'danger');
        }
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
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('restaurante', 'nombre')->ignore($id, 'id_restaurante')
            ],
            'descripcion' => 'required|string|max:255',
            'precio_medio' => 'required|numeric',
            'direccion' => [
                'required',
                'string',
                'max:255',
                Rule::unique('restaurante', 'direccion')->ignore($id, 'id_restaurante')
            ],
            'telefono' => [
                'required',
                'regex:/^[0-9]{9}$/',
                Rule::unique('restaurante', 'telefono')->ignore($id, 'id_restaurante')
            ],
            'web' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('restaurante', 'web')->ignore($id, 'id_restaurante')
            ],
            'imagen' => 'nullable|image|max:2048',
            'tipo_comida' => 'required|exists:tipo_comida,id_tipo_comida',
            'id_barrio' => 'required|exists:barrio,id_barrio',
        ], [
            'nombre.unique' => 'Ya existe un restaurante con el nombre especificado',
            'direccion.unique' => 'Ya existe un restaurante en la dirección especificada',
            'telefono.unique' => 'El número de teléfono ya está registrado para otro restaurante',
            'telefono.regex' => 'El teléfono debe contener 9 dígitos numéricos',
            'web.unique' => 'El sitio web ya está registrado para otro restaurante',
        ]);

        DB::transaction(function () use ($request, $id) {
            $restaurante = Restaurante::findOrFail($id);
            $restaurante->nombre = $request->nombre;
            $restaurante->descripcion = $request->descripcion;
            $restaurante->precio_medio = $request->precio_medio;
            $restaurante->direccion = $request->direccion;
            $restaurante->telefono = $request->telefono;
            $restaurante->web = $request->web;
            $restaurante->id_barrio = $request->id_barrio;

            if ($request->hasFile('imagen')) {
                // Eliminar la imagen anterior si existe
                if ($restaurante->imagen) {
                    Storage::disk('public')->delete($restaurante->imagen);
                }
                $path = $request->imagen->store('restaurantes_fotos', 'public');
                $restaurante->imagen = $path;
            }

            $restaurante->save();

            // Actualizar tipo de comida
            $restaurante->tiposComida()->sync([$request->tipo_comida]);
        });

        return redirect()->route('restaurantes.index')
            ->with('success', 'Restaurante actualizado con éxito.');
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $restaurante = Restaurante::findOrFail($id);
            
            if ($restaurante->imagen) {
                Storage::disk('public')->delete($restaurante->imagen);
            }
            
            $restaurante->tiposComida()->detach();
            $restaurante->delete();
        });

        return redirect()->route('restaurantes.index')
            ->with('success', 'Restaurante eliminado con éxito.');
    }

    public function show($id)
    {
        $restaurante = Restaurante::with(['barrio', 'tiposComida', 'valoraciones'])
            ->findOrFail($id);
        
        // Calcular la valoración media
        $valoracionMedia = $restaurante->valoraciones->avg('puntuacion') ?? 0;
        
        return view('principal.info', compact('restaurante', 'valoracionMedia'));
    }

    public function valorar(Request $request, $id)
    {
        try {
            $request->validate([
                'puntuacion' => 'required|numeric|min:0|max:5',
                'comentario' => 'nullable|string|max:255'
            ]);

            // Debug
            Log::info('Datos recibidos:', [
                'puntuacion' => $request->puntuacion,
                'comentario' => $request->comentario,
                'id_restaurante' => $id,
                'id_usuario' => Auth::id()
            ]);

            $restaurante = Restaurante::findOrFail($id);
            
            // Convertir la puntuación a float
            $puntuacion = (float) $request->puntuacion;
            
            $valoracion = Valoracion::updateOrCreate(
                [
                    'id_usuario' => Auth::id(),
                    'id_restaurante' => $id
                ],
                [
                    'puntuacion' => $puntuacion,
                    'comentario' => $request->comentario
                ]
            );

            // Recalcular la valoración media
            $valoracionMedia = $restaurante->valoraciones()->avg('puntuacion');
            $totalValoraciones = $restaurante->valoraciones()->count();

            return redirect()->route('principal.show', ['id' => $id])
                ->with('success', 'Valoración guardada con éxito. Nueva valoración media: ' . round($valoracionMedia, 1));

        } catch (\Exception $e) {
            Log::error('Error al guardar la valoración:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('principal.show', ['id' => $id])
                ->with('error', 'Error al guardar la valoración: ' . $e->getMessage());
        }
    }
}