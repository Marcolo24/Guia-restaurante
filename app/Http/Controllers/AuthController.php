<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nombre' => 'required',
            'contrasena' => 'required',
        ]);

        // Buscar el usuario por nombre
        $user = User::where('nombre', $credentials['nombre'])->first();

        // Verificar si el usuario existe y la contraseña coincide
        if ($user && password_verify($credentials['contrasena'], $user->contrasena)) {
            Auth::login($user);
            $request->session()->regenerate();
            
            // Siempre redirigir a la página principal
            return redirect()->route('principal.index');
        }

        return back()->withErrors([
            'nombre' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('principal.index')->with('success', 'Has cerrado sesión correctamente');
    }

    public function showRegisterForm()
    {
        return view('principal.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:users',
            'correo' => 'required|string|email|max:255|unique:users',
            'contrasena' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->correo = $request->correo;
        $user->contrasena = password_hash($request->contrasena, PASSWORD_BCRYPT);
        $user->id_rol = 2;
        $user->save();

        Auth::login($user);

        return redirect('/');
    }
} 