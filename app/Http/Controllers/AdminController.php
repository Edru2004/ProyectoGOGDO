<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('gestion_usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'admin', // Cambiamos 'tipo_de_usuario' por 'rol'
        ]);
        return back()->with('success', '¡Administrador creado con éxito!');
    }

    public function promoverUsuario($id)
    {
        $user = User::findOrFail($id);
        $user->rol = 'admin';
        $user->save();
        return back()->with('success', '¡Permisos actualizados!');
    }
}
