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
    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required',
        ]);

        /** @var \App\Models\User|\App\Models\Docente|\App\Models\Estudiante $user */
        $user = Auth::user();

        // Comparamos el código (puedes usar == por si uno es string y el otro int)
        if ($request->two_factor_code == $user->two_factor_code) {
            
            // Limpiamos el código
            $user->resetTwoFactorCode();

            // --- REDIRECCIÓN INTELIGENTE ---

            // 1. Si es el Administrador (Guard por defecto 'web')
            if (Auth::guard('web')->check()) {
                return redirect()->route('inicio');
            }

            // 2. Si es Docente
            if (Auth::guard('docente')->check()) {
                return redirect()->route('docente.inicio_docentes');
            }

            // 3. Si es Estudiante
            if (Auth::guard('estudiante')->check()) {
                return redirect()->route('estudiante.inicio_estudiantes');
            }
        }

        // Si el código no fue igual
        return redirect()->back()->with('error', 'Código incorrecto. Revisa tu correo.');
    }
}

