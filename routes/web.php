<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\TutorController; // IMPORTANTE: Agregar el nuevo controlador
use App\Http\Controllers\DocenteLoginController;
use App\Http\Controllers\Auth\LoginEstudianteController;// IMPORTANTE: Agregar el nuevo controlador

// Panel principal
Route::get('/inicio', function () {
    return view('inicio'); 
})->name('inicio');
Route::get('/inicio', [EstudianteController::class, 'inicio'])->name('inicio');



// --- AGREGAR ESTO AL PRINCIPIO ---

// Esta ruta es para que Laravel no marque error si intenta redireccionar al login por defecto
Route::get('/login', [LoginEstudianteController::class, 'showLoginForm'])->name('login');
Route::get('/login-docente', [DocenteLoginController::class, 'showLoginForm'])->name('docente.login');
Route::post('/login-docente', [DocenteLoginController::class, 'login'])->name('docente.login.submit');

// Rutas específicas para el acceso de tus alumnos
Route::get('/login-estudiante', [LoginEstudianteController::class, 'showLoginForm'])->name('estudiante.login');
Route::post('/login-estudiante', [LoginEstudianteController::class, 'login'])->name('estudiante.login.post');
Route::post('/logout-estudiante', [LoginEstudianteController::class, 'logout'])->name('estudiante.logout');

// Dashboard protegido (Solo para alumnos logueados)
Route::middleware(['auth:estudiante'])->group(function () {
    Route::get('/estudiante/dashboard', function () {
       return view('estudiantes.dashboard');
    })->name('estudiante.dashboard');
});

Route::get('/mis-calificaciones', [EstudianteController::class, 'verCalificaciones'])->name('estudiante.calificaciones');

// --- EL RESTO DE TUS RUTAS SIGUE ABAJO IGUALITO ---
// ---------------------------------------------------------
// CRUD de Estudiantes
// ---------------------------------------------------------
Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
Route::get('/estudiantes/registrar', [EstudianteController::class, 'create'])->name('estudiantes.create');
Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');
Route::get('/estudiantes/{id}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');

// Reportes PDF (Ponlas antes de las rutas de {id})
// EN WEB.PHP (Ponlas así para que no se confundan)
// Cambia 'descargarTodosPDF' por 'reporteGeneral'
Route::get('/estudiantes/reporte-pdf', [EstudianteController::class, 'reporteGeneral'])->name('estudiantes.pdf_general');
Route::get('/estudiantes/pdf/{id}', [EstudianteController::class, 'descargarPDF'])->name('estudiantes.pdf');

// El resto de tus rutas...


// ---------------------------------------------------------
// CRUD de Docentes
// ---------------------------------------------------------
Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
Route::get('/docentes/registrar', [DocenteController::class, 'create'])->name('docentes.create');
Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
Route::get('/docentes/{id}', [DocenteController::class, 'show'])->name('docentes.show');
Route::get('/docentes/{id}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
Route::put('/docentes/{id}', [DocenteController::class, 'update'])->name('docentes.update');
Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
Route::get('/docentes/{id}/horario', [DocenteController::class, 'crearHorario'])->name('docentes.horario');
// Esta línea es la que le da nombre a la ruta para que el botón funcione

Route::resource('docentes', App\Http\Controllers\DocenteController::class);
Route::get('/docentes/{id}/horario', [DocenteController::class, 'crearHorario'])->name('docentes.crearHorario');
// ---------------------------------------------------------
// CRUD de Tutores (Añadido)
// ---------------------------------------------------------
// Usamos Route::resource para simplificar o puedes definirlas una por una como las anteriores:
Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
Route::get('/tutores/registrar', [TutorController::class, 'create'])->name('tutores.create');
Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
Route::get('/tutores/{id}', [TutorController::class, 'show'])->name('tutores.show');
Route::get('/tutores/{id}/edit', [TutorController::class, 'edit'])->name('tutores.edit');
Route::put('/tutores/{id}', [TutorController::class, 'update'])->name('tutores.update');
Route::delete('/tutores/{id}', [TutorController::class, 'destroy'])->name('tutores.destroy');
// ---------------------------------------------------------
// Asignaciones / Horarios
// ---------------------------------------------------------
Route::post('/asignaciones', [AsignacionesController::class, 'store'])->name('asignaciones.store');



// Fíjate que el nombre coincida con lo que escribes en el navegador
Route::get('/estudiante/credencial', [EstudianteController::class, 'verCredencial'])->name('estudiante.credencial');
Route::get('/estudiante/calificaciones', [EstudianteController::class, 'verCalificaciones'])->name('estudiante.calificaciones');

// RUTAS DE ACCESO
// Dentro de routes/web.php

Route::middleware(['auth:docente'])->prefix('docente')->name('docente.')->group(function () {
    
    // Dashboard principal del maestro
    Route::get('/dashboard', [DocenteController::class, 'dashboard'])->name('dashboard');

    // Lista de alumnos de una materia específica
    Route::get('/lista/{id_asignacion}', [DocenteController::class, 'verlista'])->name('lista');

    // Acción de guardar las calificaciones del formulario
    Route::post('/guardar-calificaciones', [DocenteController::class, 'guardarCalificaciones'])->name('guardar_calificaciones');
    
    // Cerrar sesión
    Route::post('/logout', [DocenteLoginController::class, 'logout'])->name('logout');
});