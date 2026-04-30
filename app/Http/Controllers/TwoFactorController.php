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
    public function store(Request $request)
{
    $request->validate([
        'two_factor_code' => 'required',
    ]);

    /** @var \App\Models\User $user */
$user = Auth::user();

    // Usamos === para mayor seguridad
    if ($request->two_factor_code === $user->two_factor_code) {
        
        // Limpiamos el código usando el método que ya tienes en User.php
        $user->resetTwoFactorCode();

        // Solo si entró aquí, lo mandamos al dashboard
        return redirect()->route('estudiante.dashboard');
    }

    // Si el código no fue igual, saltará hasta aquí
    return redirect()->back()->with('error', 'Código incorrecto. Revisa tu Gmail.');
}
}

