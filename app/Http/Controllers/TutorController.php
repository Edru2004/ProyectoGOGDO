<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutor;

class TutorController extends Controller {
    
    public function index() {
        $tutores = Tutor::orderBy('apellido_p', 'asc')->paginate(10);
        return view('tutores.tutores', compact('tutores'));
    }

    public function create() {
        return view('tutores.registrar_tutores'); 
    }

    public function store(Request $request) {
        $request->validate([
            'nombre'      => 'required|string|max:50',
            'apellido_p'  => 'required|string|max:50',
            'curp'        => 'required|string|size:18|unique:Tutor,curp', // Validación de CURP
            'no_telefono' => 'required|max:15',
            
        ]);

        $data = $request->all();

        // Lógica para el parentesco "Otro"
        if ($request->parentesco === 'Otro' && $request->filled('parentesco_otro')) {
            $data['parentesco'] = $request->parentesco_otro;
        }

        // Aseguramos que la CURP se guarde en mayúsculas
        $data['curp'] = strtoupper($request->curp);

        Tutor::create($data);

        return redirect()->route('tutores.index')->with('success', 'Tutor registrado correctamente.');
    }

    public function edit($id) {
        $tutor = Tutor::findOrFail($id);
        return view('tutores.editar_tutores', compact('tutor'));
    }

    public function update(Request $request, $id) {
        $tutor = Tutor::findOrFail($id);

        $request->validate([
            'nombre'      => 'required|string|max:50',
            'apellido_p'  => 'required|string|max:50',
            'curp'        => 'required|string|size:18|unique:Tutor,curp,' . $id . ',id_tutor', // Ignora el ID actual al validar único
            'no_telefono' => 'required|max:15',
        ]);

        $data = $request->all();

        // Lógica para parentesco personalizado en edición
        if ($request->parentesco === 'Otro' && $request->filled('parentesco_otro')) {
            $data['parentesco'] = $request->parentesco_otro;
        }

        $data['curp'] = strtoupper($request->curp);

        $tutor->update($data);

        return redirect()->route('tutores.index')->with('success', 'Información del tutor actualizada correctamente.');
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