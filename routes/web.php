<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionesController;
use App\Http\Controllers\TutorController; // IMPORTANTE: Agregar el nuevo controlador

// Panel principal
Route::get('/inicio', function () {
    return view('inicio'); 
})->name('inicio');
Route::get('/inicio', [EstudianteController::class, 'inicio'])->name('inicio');
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



