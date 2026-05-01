<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Send2FACode;

class LoginEstudianteController extends Controller
{
    public function showLoginForm() {
        // Redirección si ya hay sesión activa
        if (Auth::guard('estudiante')->check()) {
            return redirect()->route('estudiante.dashboard');
        }
        if (Auth::guard('docente')->check()) {
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
            return $this->handleTwoFactor(Auth::guard('estudiante')->user(), $request);
        }

        // 2. Intentamos como Docente
        if (Auth::guard('docente')->attempt($credentials)) {
            return $this->handleTwoFactor(Auth::guard('docente')->user(), $request);
        }

        return back()->withErrors([
            'email' => 'El correo o la contraseña no son correctos.',
        ])->withInput($request->only('email'));
    }

    /**
     * Procesa el 2FA para no repetir código en el login
     */
    private function handleTwoFactor($user, $request) {
        $request->session()->regenerate();
        
        $user->generateTwoFactorCode();
        Mail::to($user->email)->send(new Send2FACode($user->two_factor_code));

        return redirect()->route('verify.index');
    }

    public function logout(Request $request) {
    Auth::guard('docente')->logout();
    Auth::guard('estudiante')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    
    return redirect()->route('login.escolar'); // El nombre que vimos en tu lista
}
}