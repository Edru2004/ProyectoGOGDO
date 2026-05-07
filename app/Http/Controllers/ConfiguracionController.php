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
    // Apuntamos directamente al nombre del archivo
    return view('configuracion', compact('admin'));
}

   // ... arriba están tus otras funciones ...

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