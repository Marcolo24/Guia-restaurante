<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'correo' => 'required|string|email|max:255|unique:users,correo',
            'contrasena' => 'required|string|min:8|confirmed',
            'id_rol' => 'required|in:1,2'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'id_rol' => $request->id_rol
        ]);

        return redirect()->route('usuarios.index')
            ->with('mensaje', 'El usuario ha sido creado correctamente')
            ->with('tipo', 'success');
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'correo')->ignore($usuario->id_usuario, 'id_usuario'),
            ],
            'id_rol' => 'required|in:1,2',
            'contrasena' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'id_rol' => $request->id_rol,
        ];

        if ($request->filled('contrasena')) {
            $data['contrasena'] = Hash::make($request->contrasena);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('mensaje', 'El usuario ha sido actualizado correctamente')
            ->with('tipo', 'success');
    }

    public function destroy(User $usuario)
    {
        // Evitar que el usuario se elimine a sí mismo
        if ($usuario->id_usuario === auth()->user()->id_usuario) {
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