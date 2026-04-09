<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estudiantil - GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="profile-section">
            <div class="profile-avatar">
                <i class="fas fa-user-graduate"></i>
            </div>
            <p class="welcome-text mb-0">Bienvenido(a)</p>
            <p class="mb-0 text-white fw-bold">
                {{ Auth::guard('estudiante')->user()->nombre }}
            </p>
        </div>

        <a href="{{ route('estudiante.dashboard') }}"><i class="fas fa-home"></i><span>Inicio</span></a>

        <a href="{{ route('estudiante.credencial') }}"><i class="fas fa-id-card"></i><span>Mi Credencial</span></a>

        <a href="{{ route('estudiante.calificaciones') }}"> <i class="fas fa-star"></i><span>Mis Calificaciones</span></a>

        <form action="{{ route('estudiante.logout') }}" method="POST" id="logout-form">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                <i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span>
            </a>
        </form>
    </div>

    <div class="content">
        <nav class="navbar navbar-dark p-3 mb-4 shadow-sm">
            <div class="container-fluid">
                <button id="toggleBtn" class="btn btn-outline-light border-0">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand mb-0 h1 ms-3 text-white">SISTEMA CONTROL ESTUDIANTIL GDO</span>
            </div>
        </nav>

        <div class="container-fluid">
            {{-- EL PARCHE ESTÁ AQUÍ: Oculta si es credencial O si es calificaciones --}}
            @if(!Request::is('estudiante/credencial') && !Request::is('estudiante/calificaciones'))
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card kpi-card-dashboard shadow-sm text-center p-3">
                            <i class="fas fa-user-circle fa-2x text-success mb-2"></i>
                            <h6 class="text-muted small uppercase">CURP</h6>
                            <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">{{ Auth::guard('estudiante')->user()->curp }}</h6>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card kpi-card-dashboard shadow-sm text-center p-3">
                            <i class="fas fa-star fa-2x text-warning mb-2"></i>
                            <h6 class="text-muted small uppercase">Promedio</h6>
                            <h3 class="fw-bold text-success mb-0">9.2</h3>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Aquí se cargará el contenido de cada sección --}}
            <div class="section-container">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleBtn").onclick = function () {
            document.getElementById("sidebar").classList.toggle("closed");
        }
    </script>
</body>
</html>