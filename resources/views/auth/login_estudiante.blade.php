<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Estudiantes - GDO</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="animated-background"></div>
<div class="overlay"></div>

<div class="main-box active" id="mainBox">
    <div class="panel-wrapper">
        
        <div class="panel login-panel">
            <div class="login-content">
                <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo" class="logo-school">
                <h2>¡Hola de nuevo!</h2>
                <p style="color: #777; margin-bottom: 20px;">Ingresa tus datos para entrar</p>

                <form action="{{ route('estudiante.login.post') }}" method="POST">
                    @csrf
                    
                    @if ($errors->any())
                        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; font-size: 0.8rem; margin-bottom: 15px;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="input-group">
                        <label style="font-size: 0.8rem; font-weight: 700;">CORREO ELECTRÓNICO</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="alisonC@gmail.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label style="font-size: 0.8rem; font-weight: 700;">CONTRASEÑA</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        ENTRAR AL SISTEMA <i class="fas fa-chevron-right"></i>
                    </button>

                    <p id="btnBack" style="margin-top: 20px; cursor: pointer; color: #888; font-size: 0.9rem;">
                        <i class="fas fa-arrow-left"></i> Volver
                    </p>
                </form>
            </div>
        </div>

        <div class="panel welcome-panel">
            <div class="welcome-content">
                <div class="icon-box"><i class="fas fa-graduation-cap"></i></div>
                <h1>GDO Digital</h1>
                <p>Tu portal escolar para consultar calificaciones y horarios.</p>
                <button class="btn-slide" id="btnGoLogin">EMPEZAR AHORA</button>
            </div>
        </div>
    </div>
</div>

<script>
    const mainBox = document.getElementById('mainBox');
    document.getElementById('btnGoLogin').onclick = () => mainBox.classList.remove('active');
    document.getElementById('btnBack').onclick = () => mainBox.classList.add('active');
</script>
</body>
</html>