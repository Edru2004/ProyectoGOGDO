<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\TutorController; 
use App\Http\Controllers\DocenteLoginController;
use App\Http\Controllers\Auth\LoginEstudianteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFactorController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS DE ACCESO (LOGINS)
|--------------------------------------------------------------------------
*/

// --- ACCESO EXCLUSIVO ADMINISTRADOR (Dulce) ---
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');

// --- ACCESO COMPARTIDO (Docentes y Alumnos) ---
// Ambos entran por aquí y tu controlador los divide según su correo
Route::get('/login-escolar', [LoginEstudianteController::class, 'showLoginForm'])->name('login.escolar');
Route::post('/login-escolar', [LoginEstudianteController::class, 'login'])->name('login.escolar.post');

// Logout Único
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| 2. VERIFICACIÓN DE DOS PASOS (2FA)
|--------------------------------------------------------------------------
| Abierto para los 3 perfiles después de pasar el primer login.
*/
Route::middleware(['auth:web,docente,estudiante'])->group(function () {
    Route::get('verify', [TwoFactorController::class, 'index'])->name('verify.index');
    Route::post('verify', [TwoFactorController::class, 'store'])->name('verify.store');
});


/*
|--------------------------------------------------------------------------
| 3. PANEL ADMINISTRATIVO (Guard: web)
|--------------------------------------------------------------------------
| Solo tú como administradora tienes acceso a estas rutas de gestión.
*/
Route::middleware(['auth:web'])->group(function () {
    
    Route::get('/inicio', [EstudianteController::class, 'inicio'])->name('inicio');

    // --- Gestión de Estudiantes (Ordenado para evitar error 404) ---
    Route::get('/estudiantes/reporte-pdf', [EstudianteController::class, 'reporteGeneral'])->name('estudiantes.pdf_general');
    Route::get('/estudiantes/registrar', [EstudianteController::class, 'create'])->name('estudiantes.create');
    Route::get('/estudiantes/pdf/{id}', [EstudianteController::class, 'descargarPDF'])->name('estudiantes.pdf');
    
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/estudiantes/{id}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');

    // --- Gestión de Docentes ---
    Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
    Route::get('/docentes/registrar', [DocenteController::class, 'create'])->name('docentes.create');
    Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    Route::get('/docentes/{id}', [DocenteController::class, 'show'])->name('docentes.show');
    Route::get('/docentes/{id}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
    Route::put('/docentes/{id}', [DocenteController::class, 'update'])->name('docentes.update');
    Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
    
    Route::get('/docentes/{id}/horario', [DocenteController::class, 'crearHorario'])->name('docentes.crearHorario');
    Route::get('/docentes/{id}/descargar-horario', [DocenteController::class, 'descargarHorario'])->name('docentes.descargarHorario');

    // --- Gestión de Tutores ---
    Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
    Route::get('/tutores/registrar', [TutorController::class, 'create'])->name('tutores.create');
    Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
    Route::get('/tutores/{id}', [TutorController::class, 'show'])->name('tutores.show');
    Route::get('/tutores/{id}/edit', [TutorController::class, 'edit'])->name('tutores.edit');
    Route::put('/tutores/{id}', [TutorController::class, 'update'])->name('tutores.update');
    Route::delete('/tutores/{id}', [TutorController::class, 'destroy'])->name('tutores.destroy');

    // --- Asignaciones ---
    Route::post('/asignaciones', [AsignacionesController::class, 'store'])->name('asignaciones.store');
});


/*
|--------------------------------------------------------------------------
| 4. PANEL DE DOCENTES (Guard: docente)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/inicio', function () {
        return view('docentes.Inicio_docentes');
    })->name('inicio_docentes');

    Route::get('/mis-clases', [DocenteController::class, 'dashboard'])->name('clases_docente');
    Route::get('/lista/{id_asignacion}', [DocenteController::class, 'verlista'])->name('lista');
    Route::post('/guardar-calificaciones', [DocenteController::class, 'guardarCalificaciones'])->name('guardar_calificaciones');
    
    // Vistas adicionales
    Route::get('/alumnos', function () { return view('docentes.Alumnos'); })->name('alumnos');
    Route::get('/horario', function () { return view('docentes.Visualizar_horario'); })->name('visualizar_horario');
});


/*
|--------------------------------------------------------------------------
| 5. PANEL DE ESTUDIANTES (Guard: estudiante)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {    
    Route::get('/inicio', function () {
        return view('estudiantes.inicio_estudiantes');
    })->name('inicio_estudiantes');

    Route::get('/dashboard', function () {
        return view('estudiantes.inicio_estudiantes'); 
    })->name('dashboard');

    Route::get('/credencial', [EstudianteController::class, 'verCredencial'])->name('credencial');
    Route::get('/calificaciones', [EstudianteController::class, 'verCalificaciones'])->name('calificaciones');
});