<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignaciones;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupos;

class AsignacionesController extends Controller
{
    public function create()
    {
        // Necesitamos enviar las listas para los selects del formulario
        $docentes = Docente::all();
        $materias = Materia::all();
        $grupos = Grupos::all();
        
     return view('docentes.horario_docentes', compact('docente', 'materias', 'grupos'));
}

    public function store(Request $request)
    {
        // Guardamos la asignación (el horario)
        Asignaciones::create($request->all());
        
        return redirect()->route('docentes.index')->with('status', 'Horario asignado con éxito');
    }
}