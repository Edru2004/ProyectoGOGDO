<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificaciones; // Importante importar el modelo
use Illuminate\Support\Facades\Auth;

class CalificacionesController extends Controller
{
    public function misCalificaciones()
    {
        // Obtenemos el ID del estudiante autenticado
        $id_estudiante = Auth::user()->id_estudiante; 

        // Cargamos las calificaciones con sus relaciones anidadas
        $calificaciones = Calificaciones::with([
            'asignacion.materia', 
            'asignacion.docente'
        ])
        ->where('id_estudiante', $id_estudiante)
        ->get();

        return view('estudiantes.calificaciones', compact('calificaciones'));
    }
}