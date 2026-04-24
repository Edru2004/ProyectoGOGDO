<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Personal Docente | GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #23972d 0%, #12662b 100%); min-height: 100vh; color: white; position: fixed; width: 250px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .nav-link { color: rgba(255,255,255,0.8); border-radius: 8px; margin: 5px 15px; transition: 0.3s; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
        .card-materia { border: none; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); transition: 0.3s; }
        .card-materia:hover { transform: translateY(-10px); }
        .icon-box { width: 50px; height: 50px; background: #e8f5e9; color: #118b2e; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    </style>
</head>
<body>

    <div class="sidebar shadow">
        <div class="p-4 text-center">
            <div class="bg-white rounded-circle d-inline-block p-3 mb-2">
                <i class="fas fa-chalkboard-teacher fa-2x text-success"></i>
            </div>
            <h5 class="fw-bold">GDO DOCENTE</h5>
            <small class="opacity-75">Panel Personal</small>
        </div>
        <hr class="mx-3">
        <nav class="nav flex-column">
            <a class="nav-link active" href="#"><i class="fas fa-th-large me-2"></i> Mis Clases</a>
            <a class="nav-link" href="#"><i class="fas fa-users me-2"></i> Mis Alumnos</a>
            <a class="nav-link" href="#"><i class="fas fa-clock me-2"></i> Mi Horario</a>
            
            <div class="mt-5 px-3">
                <form action="{{ route('docente.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100 border-0 text-start">
                        <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </nav>
    </div>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-0">Bienvenido, {{ Auth::guard('docente')->user()->nombre }}</h2>
                <p class="text-muted">Aquí tienes el control de tus asignaturas actuales.</p>
            </div>
            <div class="bg-white p-2 rounded shadow-sm fw-bold text-success">
                <i class="far fa-calendar-alt me-2"></i> 2025 - 2026
            </div>
        </header>

        <div class="row">
            @forelse($misClases as $clase)
                <div class="col-md-4 mb-4">
                    <div class="card card-materia h-100">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <div class="icon-box">
                                    <i class="fas fa-book fa-lg"></i>
                                </div>
                                <span class="badge bg-success-subtle text-success border border-success-subtle h-100">
                                    {{ $clase->grupo->nombre ?? 'S/G' }}
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $clase->materia->nombre ?? 'Asignatura' }}</h5>
                            <p class="text-muted small mb-4">Bachillerato Gustavo Díaz Ordaz</p>
                            
                            <div class="d-flex align-items-center text-secondary small mb-3">
                                <i class="fas fa-door-open me-2"></i> Aula: {{ $clase->aula }}
                            </div>
                            
                            <a href="{{ route('docente.lista', $clase->id_asignacion) }}" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 10px;">
                                <i class="fas fa-clipboard-check me-2"></i> Capturar Notas
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">No tienes clases registradas para este periodo.</h4>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>