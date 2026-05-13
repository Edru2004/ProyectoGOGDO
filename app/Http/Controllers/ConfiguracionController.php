<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('configuracion', compact('admin'));
    }

    /**
     * Esta es la función que faltaba y causaba el error 500
     */
    /**
 * Cambiamos el nombre de 'update' a 'updateProfile' 
 * para que coincida con tu web.php
 */
/**
 * Asegúrate de que el nombre aquí sea 'update'
 * para que coincida con lo que Laravel busca en image_7edea5.png
 */
public function update(Request $request) 
{
    $admin = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $admin->name = $request->name;

    if ($request->hasFile('foto')) {
        $destinationPath = public_path('img/perfiles');

        // Borramos la foto anterior si no es la default
        if ($admin->foto && $admin->foto !== 'default-avatar.png') {
            $oldPath = $destinationPath . '/' . $admin->foto;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        
        $admin->foto = $filename;
    }

    $admin->save();

    return back()->with('success', '¡Información actualizada con éxito!');
}
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        return back()->with('success', '¡Contraseña actualizada con éxito!');
    }
}