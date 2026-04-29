<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupos;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Asignaciones; // Asegúrate de importar el modelo
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Calificaciones;

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
 // app/Http/Controllers/DocenteController.php

public function show($id)
{
    // Buscamos al docente (ej. Petra García) por su ID
    $docente = Docente::findOrFail($id);

    // Buscamos todas sus clases asignadas y traemos de una vez la materia y el grupo
    $asignaciones = Asignaciones::where('id_docente', $id)
                        ->with(['materia', 'grupo'])
                        ->get();

    // Enviamos a la vista 'ver_docente.blade.php' tanto al docente como sus asignaciones
    return view('docentes.ver_docente', compact('docente', 'asignaciones'));
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
public function dashboard()
{
    $docenteId = auth()->guard('docente')->id();
    
    // El "with" es lo que hace que el nombre de la materia NO salga vacío
    $misClases = Asignaciones::with(['materia', 'grupo']) 
        ->where('id_docente', $docenteId)
        ->get();

    return view('docentes.dashboard_maestro', compact('misClases'));
}

// LISTA DE ALUMNOS (Para poner los 3 puntos de la foto)
// ... (tus otros métodos index, show, dashboard, etc.)

public function verlista($id_asignacion) {
    $asignacion = Asignaciones::with(['materia', 'grupo'])->findOrFail($id_asignacion);

    // Buscamos alumnos y cargamos sus calificaciones para esta materia específica
    $alumnos = Estudiante::whereHas('inscripcion', function($query) use ($asignacion) {
        $query->where('id_grupo', $asignacion->id_grupo);
    })
    ->with(['calificaciones' => function($query) use ($asignacion) {
        $query->where('id_materia', $asignacion->id_materia);
    }])
    ->orderBy('apellido_p')->get();

    return view('docentes.captura_calificaciones', compact('alumnos', 'asignacion'));
}

public function guardarCalificaciones(Request $request) {
    $notas = $request->input('notas');
    $id_materia = $request->input('id_materia');

    foreach ($notas as $id_estudiante => $valores) {
        \App\Models\Calificaciones::updateOrCreate(
            [
                'id_estudiante' => $id_estudiante, 
                'id_materia' => $id_materia
            ],
            [
                'p1_n1' => $valores['n1'] ?? 0, 
                'p1_n2' => $valores['n2'] ?? 0, 
                'p1_n3' => $valores['n3'] ?? 0,
            ]
        );
    }
    return redirect()->back()->with('success', '¡Lista del GDO actualizada!');
}
 // No olvides importar esto arriba

public function descargarHorario($id)
{
    $docente = Docente::findOrFail($id);
    $asignaciones = Asignaciones::where('id_docente', $id)
                        ->with(['materia', 'grupo.semestre'])
                        ->get();

    // Cargamos una vista especial para el PDF
    $pdf = Pdf::loadView('docentes.pdf_horario', compact('docente', 'asignaciones'));

    // Descarga el archivo con el nombre del maestro
    return $pdf->download('Horario_'.$docente->apellido_p.'.pdf');
}
}