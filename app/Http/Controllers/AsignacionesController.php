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
    // Validamos que el día sea uno de los permitidos
    $request->validate([
        'dia_semana' => 'required|string|max:20',
        'hora_inicio' => 'required',
        'hora_fin' => 'required',
        'id_docente' => 'required|exists:docente,id_docente',
    ]);

    // Si pasa la validación, guardamos
    Asignaciones::create($request->all());

    return redirect()->route('docentes.index')->with('status', 'Horario asignado con éxito');
}
}