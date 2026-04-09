<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Acceso Docentes - GDO</title>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow border-0" style="border-radius: 15px;">
                    <div class="card-header bg-success text-white text-center py-4" style="border-radius: 15px 15px 0 0;">
                        <h4 class="mb-0">SISTEMA GDO</h4>
                        <small>Módulo de Docentes</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('docente.login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Correo Institucional</label>
                                <input type="email" name="email" class="form-control" placeholder="ejemplo@gdo.com" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-muted">Contraseña</label>
                                <input type="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2 shadow-sm">
                                INICIAR SESIÓN
                            </button>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-0 text-center pb-4">
                        <a href="/" class="text-muted small">Regresar al inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>