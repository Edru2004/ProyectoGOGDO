<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorController extends Controller
{
    // Muestra la pantalla donde el alumno escribe el código
    public function index()
    {
        return view('auth.two_factor');
    }

    // Recibe el código de la pantalla y lo revisa
   // Recibe el código de la pantalla y lo revisa
  public function store(Request $request) {
    $request->validate(['two_factor_code' => 'required']);

    // Buscamos quién está intentando entrar
    $user = Auth::guard('web')->user() 
            ?? Auth::guard('docente')->user() 
            ?? Auth::guard('estudiante')->user();

    if (!$user) {
        return redirect()->route('login.escolar')->withErrors(['error' => 'Sesión expirada']);
    }

    if ($request->two_factor_code == $user->two_factor_code) {
        // AHORA SÍ: Esta función ya existe en todos los modelos
        $user->resetTwoFactorCode();

        // Redirecciones por nombre de ruta oficial (vistos en tu terminal)
        if (Auth::guard('web')->check()) {
            return redirect()->route('inicio');
        }
        
        if (Auth::guard('docente')->check()) {
            return redirect()->route('docente.inicio_docentes');
        }

        if (Auth::guard('estudiante')->check()) {
            return redirect()->route('estudiante.inicio_estudiantes');
        }
    }

    return back()->withErrors(['two_factor_code' => 'El código es incorrecto']);
}
}

