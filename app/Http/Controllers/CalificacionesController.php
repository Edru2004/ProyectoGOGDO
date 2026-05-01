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
    public function guardar(Request $request) 
    {
        // El freno de mano debe ir AQUÍ adentro
        dd($request->all()); 

        $datos = $request->input('notas'); 
        $id_asignacion = $request->input('id_asignacion'); 

        if (!$datos) {
            return back()->withErrors(['error' => 'No se recibieron notas.']);
        }

        foreach ($datos as $id_estudiante => $valores) {
            \App\Models\Calificaciones::updateOrCreate(
                [
                    'id_estudiante' => $id_estudiante, 
                    'id_asignacion' => $id_asignacion 
                ],
                [
                    'p1_n1' => $valores['n1'] ?? 0,
                    'p1_n2' => $valores['n2'] ?? 0,
                    'p1_n3' => $valores['n3'] ?? 0,
                ]
            );
        }

        return back()->with('success', '¡Lista del GDO actualizada correctamente!');
    }
}