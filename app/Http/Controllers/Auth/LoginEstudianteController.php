<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginEstudianteController extends Controller
{
    public function showLoginForm() {
        if (Auth::guard('estudiante')->check()) {
            return redirect()->route('estudiante.dashboard');
        }
        return view('auth.login_estudiante');
    }

    public function login(Request $request) {
        // Validamos usando 'email' y 'password'
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Intentamos el login con el guard 'estudiante'
        if (Auth::guard('estudiante')->attempt($credentials)) {
            $request->session()->regenerate();
            // Redirección al Dashboard
            return redirect()->intended(route('estudiante.dashboard'));
        }

        // Si falla, regresamos con error específico en el campo email
        return back()->withErrors([
            'email' => 'El correo o la contraseña no son correctos.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request) {
        Auth::guard('estudiante')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('estudiante.login');
    }
}