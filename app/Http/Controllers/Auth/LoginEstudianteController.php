<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginEstudianteController extends Controller
{
    public function showLoginForm() {
        // Si ya está logueado como estudiante o docente, lo mandamos a su sitio
        if (Auth::guard('estudiante')->check()) {
            return redirect()->route('estudiante.dashboard');
        }
       if (Auth::guard('docente')->check()) {
    // Cambiamos 'docente.dashboard' por 'docente.inicio_docentes'
    return redirect()->route('docente.inicio_docentes');

        }
        
        return view('auth.login_estudiante');
    }

  public function login(Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    // 1. Intentamos como Estudiante
    if (Auth::guard('estudiante')->attempt($credentials)) {
        $request->session()->regenerate();
        
        // Obtenemos al usuario que acaba de entrar
        /** @var \App\Models\User $user */
        $user = Auth::guard('estudiante')->user();

        // Generamos y enviamos el código (La lógica de tu modelo User.php)
        $user->generateTwoFactorCode();
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\Send2FACode($user->two_factor_code));

        // Redirigimos a la verificación, NO al dashboard directamente
        return redirect()->route('verify.index');
    }

    // 2. Intentamos como Docente
    if (Auth::guard('docente')->attempt($credentials)) {
        $request->session()->regenerate();

        /** @var \App\Models\User $user */
        $user = Auth::guard('docente')->user();

        $user->generateTwoFactorCode();
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\Send2FACode($user->two_factor_code));

        return redirect()->route('verify.index');
    }

    return back()->withErrors([
        'email' => 'El correo o la contraseña no son correctos.',
    ])->withInput($request->only('email'));
}

   public function logout(Request $request) {
    // Cerramos sesión en ambos guards por seguridad
    Auth::guard('estudiante')->logout();
    Auth::guard('docente')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirigir a la pantalla de "GDO Plataforma Digital"
    return redirect()->route('estudiante.login'); 
}
}