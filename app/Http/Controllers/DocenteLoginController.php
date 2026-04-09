<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteLoginController extends Controller
{
    // 1. Muestra la pantalla de login
    public function showLoginForm() {
        return view('docentes.login'); 
    }

    // 2. Valida los datos y deja entrar al docente
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Usamos el guard 'docente' que ya configuraste en auth.php
        if (Auth::guard('docente')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('docente.dashboard');
        }

        // Si falla, lo regresa con error
        return back()->withErrors(['email' => 'El correo o la contraseña no coinciden.']);
    }

    // 3. Cerrar sesión
    public function logout(Request $request) {
        Auth::guard('docente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('docente.login');
    }
}