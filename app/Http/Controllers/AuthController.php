<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Agrega esto
use App\Mail\Send2FACode;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login_admon');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // 1. Generamos el código de 6 dígitos en la BD
            $user->generateTwoFactorCode();

            // 2. Enviamos el Gmail con el código
            Mail::to($user->email)->send(new Send2FACode($user->two_factor_code));

            // 3. Redirigimos a la pantalla de verificación
            return redirect()->route('verify.index');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // 1. Detectamos si es un administrador antes de cerrar la sesión
        $isAdmin = Auth::guard('web')->check();

        // 2. Cerramos la sesión en todos los guards por seguridad
        Auth::guard('web')->logout();
        Auth::guard('docente')->logout();
        Auth::guard('estudiante')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3. Redirección inteligente
        if ($isAdmin) {
            // Si era admin, lo mandamos a su login especial
            return redirect()->route('login');
        }

        // Si era cualquier otro (maestro/alumno), al escolar
        return redirect()->route('login.escolar');
    }
}
