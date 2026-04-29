<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginEstudianteController extends Controller
{
    public function showLoginForm() {
        // Si ya está logueado como estudiante o docente, lo mandamos a su sitio
        if (Auth::guard('estudiante')->check()) {
            return redirect()->route('estudiante.dashboard');
        }
        if (Auth::guard('docente')->check()) {
            return redirect()->route('docente.dashboard');
        }
        
        return view('auth.login_estudiante');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // 1. Intentamos como Estudiante
    if (Auth::guard('estudiante')->attempt($credentials)) {
        $request->session()->regenerate();
        // Redirige al nombre de ruta que definiste: 'estudiante.dashboard'
        return redirect()->intended(route('estudiante.dashboard'));
    }

    // 2. Intentamos como Docente
    if (Auth::guard('docente')->attempt($credentials)) {
        $request->session()->regenerate();
        // Redirige al nombre de ruta que definiste: 'docente.dashboard'
        return redirect()->intended(route('docente.dashboard'));
    }

    return back()->withErrors([
        'email' => 'El correo o la contraseña no son correctos.',
    ])->withInput($request->only('email'));
}

   public function logout(Request $request) {
    // Cerramos sesión en ambos guards por seguridad
    Auth::guard('estudiante')->logout();
    Auth::guard('docente')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirigir a la pantalla de "GDO Plataforma Digital"
    return redirect()->route('estudiante.login'); 
}
}