<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Estudiante;

class EstudianteConfiguracionController extends Controller
{
    public function index()
    {
        // Asumiendo que el estudiante está autenticado
        $estudiante = Auth::guard('estudiante')->user(); 
        return view('configuracionE', compact('estudiante'));
    }

    public function updateProfile(Request $request)
    {
        $estudiante = Auth::guard('estudiante')->user();

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Eliminar foto vieja
            if ($estudiante->foto && $estudiante->foto != 'default-student.png') {
                $rutaAnterior = public_path('img/estudiantes/' . $estudiante->foto);
                if (File::exists($rutaAnterior)) {
                    File::delete($rutaAnterior);
                }
            }

            // Guardar nueva foto
            $nombreFoto = 'est_' . time() . '_' . $estudiante->id_estudiante . '.' . $request->foto->extension();
            $request->foto->move(public_path('img/estudiantes'), $nombreFoto);
            
            // Usamos el modelo para actualizar
            $estudiante->update(['foto' => $nombreFoto]);
        }

        return back()->with('success', '¡Foto de perfil actualizada!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $estudiante = Auth::guard('estudiante')->user();

        if (!Hash::check($request->current_password, $estudiante->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $estudiante->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Contraseña actualizada con éxito.');
    }
}