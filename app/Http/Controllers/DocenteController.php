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
use Illuminate\Support\Facades\Auth; // <-- ESTA LÍNEA ES LA QUE TE FALTA
use Illuminate\Support\Facades\Hash;

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
    
    // El "with" asegura que traigas la relación de materia y grupo
    $misClases = Asignaciones::with(['materia', 'grupo']) 
        ->where('id_docente', $docenteId)
        ->get();

    // CAMBIO CLAVE: Retorna 'clases_docente', NO el dashboard_maestro
    return view('docentes.clases_docente', compact('misClases'));
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

public function guardarCalificaciones(Request $request) 
{
    $datos = $request->input('notas'); 
    $id_asignacion = $request->input('id_asignacion');

    if (!$datos) return back()->with('error', 'No hay datos');

    // Buscamos la asignación para obtener el id_materia real
    $asignacion = \App\Models\Asignaciones::findOrFail($id_asignacion);

    foreach ($datos as $id_estudiante => $valores) {
        \App\Models\Calificaciones::updateOrCreate(
            [
                'id_estudiante' => $id_estudiante, 
                'id_asignacion' => $id_asignacion,
                'id_materia'    => $asignacion->id_materia // <-- Lo tomamos de la asignación
            ],
            [
                'p1_n1' => floatval($valores['n1'] ?? 0),
                'p1_n2' => floatval($valores['n2'] ?? 0),
                'p1_n3' => floatval($valores['n3'] ?? 0),
            ]
        );
    }
    return back()->with('success', '¡Lista del GDO actualizada correctamente!');
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
public function actualizarEstilo(Request $request, $id)
{
    // Buscamos la asignación (clase) por su ID
    $clase = \App\Models\Asignaciones::findOrFail($id);

    // Actualizamos los campos en la base de datos
    $clase->update([
        'color_card' => $request->color_card,
        'icono_card' => $request->icono_card
    ]);

    // Regresamos a la página anterior con un mensaje de éxito
    return back()->with('success', '¡Estilo de la clase actualizado correctamente!');
}
// Muestra la vista de configuración
public function configuracionD()
{
    $docente = Auth::guard('docente')->user();
    // Al estar en la raíz de 'views', solo ponemos el nombre del archivo
    return view('configuracionD', compact('docente'));
}

// Procesa el cambio de foto del docente
public function updateFotoD(Request $request)
{
    $docente = Auth::guard('docente')->user();

    $request->validate([
        'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('foto')) {
        // Borrar foto vieja si existe y no es la default
        if ($docente->foto && $docente->foto != 'default-docente.png') {
            $ruta = public_path('img/docentes/' . $docente->foto);
            if (file_exists($ruta)) {
                unlink($ruta);
            }
        }

        $nombreFoto = 'doc_' . time() . '.' . $request->foto->extension();
        $request->foto->move(public_path('img/docentes'), $nombreFoto);

        // Guardar en la base de datos
        $docente->foto = $nombreFoto;
        $docente->save();
    }

    return back()->with('success', '¡Foto de perfil actualizada!');
}

// Procesa el cambio de contraseña del docente
public function updatePasswordD(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $docente = Auth::guard('docente')->user();

    if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $docente->password)) {
        return back()->withErrors(['current_password' => 'La contraseña actual no coincide.']);
    }

    $docente->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
    $docente->save();

    return back()->with('success', '¡Contraseña actualizada correctamente!');
}
}