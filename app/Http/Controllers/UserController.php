<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Aplicar filtros si están presentes
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('correo')) {
            $query->where('correo', 'like', '%' . $request->correo . '%');
        }

        if ($request->filled('rol')) {
            $query->where('id_rol', $request->rol);
        }

        $usuarios = $query->paginate(10); // Puedes ajustar el número de resultados por página
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|min:3|unique:users,nombre',
                'correo' => 'required|string|email|unique:users,correo',
                'contrasena' => 'required|string|min:8|confirmed',
                'id_rol' => 'required|in:1,2'
            ], [
                'nombre.unique' => 'El nombre de usuario "' . $request->nombre . '" ya está en uso. Por favor, elige otro.',
                'correo.unique' => 'El correo electrónico "' . $request->correo . '" ya está registrado.',
                'contrasena.confirmed' => 'Las contraseñas no coinciden.',
                'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'nombre.required' => 'El nombre de usuario es obligatorio.',
                'correo.required' => 'El correo electrónico es obligatorio.',
                'correo.email' => 'El formato del correo electrónico no es válido.',
                'id_rol.required' => 'Debes seleccionar un rol.',
                'id_rol.in' => 'El rol seleccionado no es válido.'
            ]);

            User::create([
                'nombre' => $request->nombre,
                'correo' => $request->correo,
                'contrasena' => Hash::make($request->contrasena),
                'id_rol' => $request->id_rol
            ]);

            return redirect()->route('usuarios.index')
                ->with('mensaje', 'Usuario creado exitosamente')
                ->with('tipo', 'success');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('mensaje', 'Error al crear el usuario: ' . $e->getMessage())
                ->with('tipo', 'danger');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('mensaje', 'Error al crear el usuario: ' . $e->getMessage())
                ->with('tipo', 'danger');
        }
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => [
                    'required',
                    'string',
                    'min:3',
                    Rule::unique('users', 'nombre')->ignore($id, 'id_usuario')
                ],
                'correo' => [
                    'required',
                    'email',
                    Rule::unique('users', 'correo')->ignore($id, 'id_usuario')
                ],
                'contrasena' => 'nullable|min:8',
                'contrasena_confirmation' => 'required_with:contrasena|same:contrasena',
                'id_rol' => 'required|in:1,2'
            ], [
                'nombre.required' => 'El nombre es requerido',
                'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
                'nombre.unique' => 'El nombre de usuario ya está en uso',
                'correo.required' => 'El correo electrónico es requerido',
                'correo.email' => 'El formato del correo electrónico no es válido',
                'correo.unique' => 'Este correo electrónico ya está registrado',
                'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres',
                'contrasena_confirmation.same' => 'Las contraseñas no coinciden',
                'id_rol.required' => 'El rol es requerido',
                'id_rol.in' => 'El rol seleccionado no es válido'
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('mensaje', 'Error al actualizar el usuario')
                    ->with('tipo', 'danger');
            }

            DB::transaction(function () use ($request, $id) {
                $usuario = User::findOrFail($id);
                $usuario->nombre = $request->nombre;
                $usuario->correo = $request->correo;
                if ($request->filled('contrasena')) {
                    $usuario->contrasena = Hash::make($request->contrasena);
                }
                $usuario->id_rol = $request->id_rol;
                $usuario->save();
            });

            return redirect()
                ->route('usuarios.index')
                ->with('mensaje', 'Usuario actualizado correctamente')
                ->with('tipo', 'success');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('mensaje', 'Error al actualizar el usuario: ' . $e->getMessage())
                ->with('tipo', 'danger');
        }
    }

    public function destroy(User $usuario)
    {
        // Evitar que el usuario se elimine a sí mismo
        if ($usuario->id === auth()->user()->id) {
            return redirect()->route('usuarios.index')
                ->with('mensaje', 'No puedes eliminar tu propio usuario')
                ->with('tipo', 'danger');
        }

        $usuario->delete();
        
        return redirect()->route('usuarios.index')
            ->with('mensaje', 'El usuario ha sido eliminado correctamente')
            ->with('tipo', 'success');
    }
} 