<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - GDO</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212; /* Fondo oscuro por defecto */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 15px;
        }

        .card {
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header i {
            font-size: 50px;
            color: #6c993e; /* Tu verde */
        }

        .login-header h2 {
            color: #ffffff;
            font-weight: 600;
            margin-top: 10px;
        }

        .form-label {
            color: #bbb;
            font-size: 0.9rem;
        }

        .input-group-text {
            background: #2d2d2d;
            border-color: #444;
            color: #6c993e;
        }

        .form-control {
            background: #2d2d2d;
            border-color: #444;
            color: white;
        }

        .form-control:focus {
            background: #333;
            border-color: #6c993e;
            color: white;
            box-shadow: none;
        }

        .btn-admin {
            background: #6c993e;
            border: none;
            color: white;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-admin:hover {
            background: #5a8034;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 153, 62, 0.3);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid #dc3545;
            color: #ea868f;
            font-size: 0.85rem;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card">
        <div class="login-header">
            <i class="bi bi-person-badge-fill"></i>
            <h2>GDO Admin</h2>
            <p class="text-muted small">Ingresa tus credenciales de administrador</p>
        </div>

        <!-- Errores de Laravel -->
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@gdo.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn btn-admin w-100 mb-3">
                Entrar al Panel <i class="bi bi-arrow-right-short"></i>
            </button>
            
            <div class="text-center">
                <a href="/" class="text-muted text-decoration-none small">
                    <i class="bi bi-chevron-left"></i> Volver al inicio
                </a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>