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
            
            if ($user->id_rol === 1) {
                return redirect()->intended('/admin/restaurantes');
            }
            
            return redirect()->intended('/');
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
        return redirect('/');
    }
} 