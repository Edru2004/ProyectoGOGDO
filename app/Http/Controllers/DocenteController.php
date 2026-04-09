<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupos;
use App\Models\Estudiante;
use App\Models\Tutor;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();
        // Busca en resources/views/docentes/docentes.blade.php
        return view('docentes.docentes', compact('docentes'));
    }

    public function create()
    {
        // Busca en resources/views/docentes/registrar_docente.blade.php
        return view('docentes.registrar_docente');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if($request->has('password')){
            $data['password'] = bcrypt($request->password);
        }
        
        Docente::create($data);
        return redirect()->route('docentes.index');
    }

    // Método para ver el expediente del docente
   public function show($id)
{
    // Eager Loading: Trae al docente con sus asignaciones, y de esas asignaciones trae la materia y el grupo
    $docente = Docente::with(['asignaciones.materia', 'asignaciones.grupo'])->findOrFail($id);
    
    return view('docentes.ver_docente', compact('docente'));
}

    // Método para mostrar el formulario de edición
    public function edit($id)
    {
        $docente = Docente::findOrFail($id);
        return view('docentes.editar_docente', compact('docente'));
    }

    // Método para procesar la actualización de datos
    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);
        $data = $request->all();

        // Si el usuario no ingresó una nueva contraseña, no la actualizamos
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $docente->update($data);
        return redirect()->route('docentes.index');
    }

    public function destroy($id)
    {
        Docente::destroy($id);
        return redirect()->route('docentes.index');
    }
  public function crearHorario($id)
{
    // 1. Datos necesarios
    $docente = Docente::with(['asignaciones.materia', 'asignaciones.grupo'])->findOrFail($id);
    $materias = Materia::all();
    $grupos = Grupos::all();

    // 2. Estadísticas para el layout Index (OBLIGATORIAS)
    $totalEstudiantes = \App\Models\Estudiante::count();
    $totalTutores = \App\Models\Tutor::count();
    $totalGrupos = \App\Models\Grupos::count();
    
    // Variables preventivas para el Dashboard
    $primero = 0; $segundo = 0; $tercero = 0;
    $recientes = collect();

    // 3. ¡EL CAMBIO IMPORTANTE! 
    // Retorna el archivo del formulario, NO el Index directamente.
    // Laravel se encarga de meter este archivo dentro de Index por el @extends
    return view('docentes.horario_docentes', compact(
        'docente', 'materias', 'grupos', 
        'totalEstudiantes', 'totalTutores', 'totalGrupos', 
        'primero', 'segundo', 'tercero', 'recientes'
    ));
}
}