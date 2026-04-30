<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\Docente; // Agregado
use App\Models\Semestre;
use App\Models\Grupos;
use App\Models\Inscripciones;
use App\Models\Calificaciones;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth; // Verifica que esta línea esté al inicio del archivo

class EstudianteController extends Controller
{

    // MÉTODO PARA EL DASHBOARD (INICIO)
    public function inicio()
    {
        $totalEstudiantes = Estudiante::count();
        $totalDocentes = Docente::count();
        $totalTutores = Tutor::count();

        return view('inicio', compact('totalEstudiantes', 'totalDocentes', 'totalTutores'));
    }

    // LISTADO DE ESTUDIANTES
    // LISTADO DE ESTUDIANTES
    public function index(Request $request)
    {
        $query = Estudiante::with(['tutor', 'inscripcion.semestre', 'inscripcion.grupo']);

        // 1. Filtro por Grado (Año)
        if ($request->filled('grado')) {
            $grado = $request->grado;
            $semestres = [($grado * 2) - 1, $grado * 2]; // Ej: Grado 1 -> Semestres 1 y 2

            $query->whereHas('inscripcion', function ($q) use ($semestres) {
                $q->whereIn('id_semestre', $semestres);
            });
        }

        // 2. Filtro por Grupo (A o B) - NUEVA LÓGICA
        if ($request->filled('grupo')) {
            $grupoNombre = $request->grupo;
            $query->whereHas('inscripcion.grupo', function ($q) use ($grupoNombre) {
                $q->where('nombre_grupo', $grupoNombre);
            });
        }

        // 3. Filtro de Búsqueda General
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('apellido_p', 'LIKE', "%{$buscar}%")
                    ->orWhere('apellido_m', 'LIKE', "%{$buscar}%")
                    ->orWhere('curp', 'LIKE', "%{$buscar}%")
                    ->orWhere('email', 'LIKE', "%{$buscar}%");
            });
        }

        // Ordenar y Paginar
        // Importante: usamos appends para que la paginación no pierda los filtros de grado y grupo
        $estudiantes = $query->orderBy('apellido_p', 'asc')->paginate(10);

        return view('estudiantes.estudiantes', compact('estudiantes'));
    }

    public function create()
    {
        $tutores = Tutor::all();
        $semestres = Semestre::all();
        $grupos = Grupos::all();
        return view('estudiantes.registrar_estudiante', compact('tutores', 'semestres', 'grupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            // CAMBIA 'unique:estudiantes,curp' POR 'unique:estudiante,curp'
            'curp' => 'required|unique:estudiante,curp',
            'id_semestre' => 'required',
            'id_grupo' => 'required'
        ]);
        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $estudiante = Estudiante::create($data);

        Inscripciones::create([
            'id_estudiante' => $estudiante->id_estudiante,
            'id_semestre' => $request->id_semestre,
            'id_grupo' => $request->id_grupo,
            'ciclo_escolar' => '2024-2025',
            'estado_inscripcion' => 'Activo'
        ]);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante registrado.');
    }

    public function edit($id)
    {
        $estudiante = Estudiante::with('inscripcion')->findOrFail($id);
        $tutores = Tutor::all();
        $semestres = Semestre::all();
        $grupos = Grupos::all();
        return view('estudiantes.editar_estudiante', compact('estudiante', 'tutores', 'semestres', 'grupos'));
    }

    public function update(Request $request, $id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $estudiante->update($data);

        if ($estudiante->inscripcion) {
            $estudiante->inscripcion->update([
                'id_semestre' => $request->id_semestre,
                'id_grupo' => $request->id_grupo
            ]);
        }

        return redirect()->route('estudiantes.index')->with('success', 'Datos actualizados.');
    }

    public function show($id)
    {
        // Es vital el 'with' para que cargue los datos del tutor y la escuela
        $estudiante = Estudiante::with(['tutor', 'inscripcion.semestre', 'inscripcion.grupo'])->findOrFail($id);
        return view('estudiantes.ver_estudiante', compact('estudiante'));
    }

    public function destroy($id)
    {
        Estudiante::destroy($id);
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado.');
    }
    // Generar PDF de UN estudiante
    public function descargarPDF($id)
    {
        // Seguimos usando el 'with' para traer los datos del tutor
        $estudiante = Estudiante::with(['tutor', 'inscripcion.semestre'])->findOrFail($id);
        $pdf = Pdf::loadView('estudiantes.pdf', compact('estudiante'));
        return $pdf->download('Reporte_' . $estudiante->curp . '.pdf');
    }

    // Generar PDF de TODOS los estudiantes
    // El nombre debe ser reporteGeneral
    public function reporteGeneral()
    {
        $estudiantes = Estudiante::with(['tutor', 'inscripcion.semestre', 'inscripcion.grupo'])->get();
        $pdf = Pdf::loadView('estudiantes.pdf_general', compact('estudiantes'))
            ->setPaper('letter', 'landscape');
        return $pdf->download('Reporte_General_GDO.pdf');
    }
    public function verCredencial()
    {
        // 1. Obtenemos al usuario logueado
        $user = \Illuminate\Support\Facades\Auth::guard('estudiante')->user();

        // 2. Verificamos que no sea nulo
        if (!$user) {
            return redirect()->route('estudiante.login')->with('error', 'Sesión no válida');
        }

        /** @var \App\Models\Estudiante $user */
        // Al poner el comentario de arriba, la línea de abajo ya no debería marcar error en rojo
        $user->load('tutor');

        return view('estudiantes.credencial', ['estudiante' => $user]);
    }
    public function verCalificaciones()
    {
        // 1. Obtenemos el ID del estudiante logueado
        $estudianteId = auth()->guard('estudiante')->id();

        // 2. Traemos sus calificaciones con la información de la materia
        // Cambiamos 'materia' por 'asignacion.materia' y 'asignacion.docente'
      $calificaciones = \App\Models\Calificaciones::with(['asignacion.materia', 'asignacion.docente'])
    ->where('id_estudiante', $estudianteId)
    ->get();
        // 3. Retornamos la vista (asegúrate de que la ruta del archivo sea correcta)
        return view('estudiantes.calificaciones', compact('calificaciones'));
    }
}
