<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;

class TutorController extends Controller {
    
    // Listado de tutores
    public function index() {
        $tutores = Tutor::orderBy('apellido_p', 'asc')->paginate(10);
        return view('tutores.tutores', compact('tutores'));
    }

    // Método para mostrar el formulario de registro (CORRECCIÓN)
    public function create() {
        return view('tutores.registrar_tutores'); 
    }

    // Guardar el tutor en la base de datos
    public function store(Request $request) {
    $request->validate([
        'nombre' => 'required',
        'apellido_p' => 'required',
        'no_telefono' => 'required', // CAMBIO: Debe coincidir con el "name" de tu input
        'municipio' => 'required',   // Agrega los que consideres obligatorios
    ]);

    Tutor::create($request->all());

    return redirect()->route('tutores.index')->with('success', 'Tutor registrado correctamente.');
}

    public function edit($id) {
        $tutor = Tutor::findOrFail($id);
        return view('tutores.editar_tutores', compact('tutor'));
    }

    public function update(Request $request, $id) {
        $tutor = Tutor::findOrFail($id);
        $tutor->update($request->all());
        return redirect()->route('tutores.index')->with('success', 'Tutor actualizado.');
    }

    public function show($id) {
        $tutor = Tutor::findOrFail($id);
        return view('tutores.ver_tutores', compact('tutor'));
    }

    public function destroy($id) {
        Tutor::destroy($id);
        return redirect()->route('tutores.index')->with('success', 'Tutor eliminado.');
    }
}