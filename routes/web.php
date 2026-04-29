<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\TutorController; 
use App\Http\Controllers\DocenteLoginController;
use App\Http\Controllers\Auth\LoginEstudianteController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| 1. RUTAS DE ACCESO (LOGINS PÚBLICOS)
|--------------------------------------------------------------------------
*/

// --- Administrador (Tabla: users) ---
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Docentes (Tabla: docente) ---
Route::get('/login-docente', [DocenteLoginController::class, 'showLoginForm'])->name('docente.login');
Route::post('/login-docente', [DocenteLoginController::class, 'login'])->name('docente.login.submit');

// --- Estudiantes (Tabla: estudiante) ---
Route::get('/login-estudiante', [LoginEstudianteController::class, 'showLoginForm'])->name('estudiante.login');
Route::post('/login-estudiante', [LoginEstudianteController::class, 'login'])->name('estudiante.login.post');


/*
|--------------------------------------------------------------------------
| 2. PANEL ADMINISTRATIVO (Protegido por Middleware 'auth')
|--------------------------------------------------------------------------
| Estas rutas son exclusivas para el Administrador (Dulce Rubi).
*/

Route::middleware(['auth'])->group(function () {

    // Inicio General
    Route::get('/inicio', [EstudianteController::class, 'inicio'])->name('inicio');

    // --- CRUD ESTUDIANTES ---
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/estudiantes/registrar', [EstudianteController::class, 'create'])->name('estudiantes.create');
    Route::post('/estudiantes', [EstudianteController::class, 'store'])->name('estudiantes.store');
    Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiantes.show');
    Route::get('/estudiantes/{id}/edit', [EstudianteController::class, 'edit'])->name('estudiantes.edit');
    Route::put('/estudiantes/{id}', [EstudianteController::class, 'update'])->name('estudiantes.update');
    Route::delete('/estudiantes/{id}', [EstudianteController::class, 'destroy'])->name('estudiantes.destroy');
    
    // Reportes PDF Estudiantes
    Route::get('/estudiantes/reporte-pdf', [EstudianteController::class, 'reporteGeneral'])->name('estudiantes.pdf_general');
    Route::get('/estudiantes/pdf/{id}', [EstudianteController::class, 'descargarPDF'])->name('estudiantes.pdf');

    // --- CRUD DOCENTES ---
    Route::get('/docentes', [DocenteController::class, 'index'])->name('docentes.index');
    Route::get('/docentes/registrar', [DocenteController::class, 'create'])->name('docentes.create');
    Route::post('/docentes', [DocenteController::class, 'store'])->name('docentes.store');
    Route::get('/docentes/{id}', [DocenteController::class, 'show'])->name('docentes.show');
    Route::get('/docentes/{id}/edit', [DocenteController::class, 'edit'])->name('docentes.edit');
    Route::put('/docentes/{id}', [DocenteController::class, 'update'])->name('docentes.update');
    Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])->name('docentes.destroy');
    
    // Horarios y Descargas de Docentes
    Route::get('/docentes/{id}/horario', [DocenteController::class, 'crearHorario'])->name('docentes.crearHorario');
    Route::get('/docentes/{id}/descargar-horario', [DocenteController::class, 'descargarHorario'])->name('docentes.descargarHorario');

    // --- CRUD TUTORES ---
    Route::get('/tutores', [TutorController::class, 'index'])->name('tutores.index');
    Route::get('/tutores/registrar', [TutorController::class, 'create'])->name('tutores.create');
    Route::post('/tutores', [TutorController::class, 'store'])->name('tutores.store');
    Route::get('/tutores/{id}', [TutorController::class, 'show'])->name('tutores.show');
    Route::get('/tutores/{id}/edit', [TutorController::class, 'edit'])->name('tutores.edit');
    Route::put('/tutores/{id}', [TutorController::class, 'update'])->name('tutores.update');
    Route::delete('/tutores/{id}', [TutorController::class, 'destroy'])->name('tutores.destroy');

    // --- ASIGNACIONES ---
    Route::post('/asignaciones', [AsignacionesController::class, 'store'])->name('asignaciones.store');

});


/*
|--------------------------------------------------------------------------
| 3. PANEL DE DOCENTES (Protegido por Middleware 'auth:docente')
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:docente'])->prefix('docente')->name('docente.')->group(function () {
    
    Route::get('/dashboard', [DocenteController::class, 'dashboard'])->name('dashboard');
    Route::get('/lista/{id_asignacion}', [DocenteController::class, 'verlista'])->name('lista');
    Route::post('/guardar-calificaciones', [DocenteController::class, 'guardarCalificaciones'])->name('guardar_calificaciones');
    
    // Logout específico para docente
    Route::post('/logout', [DocenteLoginController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| 4. PANEL DE ESTUDIANTES (Protegido por Middleware 'auth:estudiante')
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:estudiante'])->group(function () {
    
    Route::get('/estudiante/dashboard', function () { 
        return view('estudiantes.dashboard'); 
    })->name('estudiante.dashboard');

    Route::get('/estudiante/credencial', [EstudianteController::class, 'verCredencial'])->name('estudiante.credencial');
    Route::get('/estudiante/calificaciones', [EstudianteController::class, 'verCalificaciones'])->name('estudiante.calificaciones');
    
    // Logout específico para estudiante
    Route::post('/logout-estudiante', [LoginEstudianteController::class, 'logout'])->name('estudiante.logout');
});