<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Muestra tu vista personalizada: login_admon.blade.php
    public function showLogin()
    {
        return view('auth.login_admon');
    }

    // Procesa el intento de entrada
    public function login(Request $request)
    {
        // Validamos que Dulce Rubi escriba algo
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Intentamos entrar con la tabla 'users'
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Si todo sale bien, al Panel de Inicio
            return redirect()->intended('inicio');
        }

        // Si se equivoca, lo mandamos de regreso con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login');
    }
}