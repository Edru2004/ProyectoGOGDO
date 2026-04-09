<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Estudiantil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

    <div class="sidebar" id="sidebar">
        <div class="profile-section">
            <div class="profile-avatar">
                <i class="fas fa-user-graduate"></i>
            </div>
            <p class="welcome-text mb-0">Bienvenido(a)</p>
            
      <p class="mb-0 text-white fw-bold" id="nombreEstudiante">
    Dulce Rubi </p>
<p class="mb-0 text-white" style="font-size: 0.9rem;">
    Usuario: <span id="usuarioLogin">Invitado GDO</span>
</p>
        </div>

        <h4><i class="fas fa-school me-2"></i>Panel Estudiantil</h4>

        <a href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i><span>Inicio</span></a>
        <a href="/estudiantes-view"><i class="fas fa-id-card me-2"></i><span>Información</span></a>
        <a href="#"><i class="fas fa-star me-2"></i><span>Calificaciones</span></a>
        <a href="#"><i class="fas fa-calendar me-2"></i><span>Horario</span></a>
        
        <form action="{{ route('logout') }}" method="POST" class="p-3">
    @csrf <button type="submit" class="btn btn-danger btn-sm w-100">
        <i class="fas fa-sign-out-alt"></i> Salir
    </button>
</form>
    </div>

    <div class="content">
        <nav class="navbar navbar-dark p-3 mb-4">
            <button id="toggleBtn" class="btn btn-light">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand ms-3">DASHBOARD</span>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card kpi-card-dashboard">
                        <i class="fas fa-star"></i>
                        <h6>Promedio</h6>
                        <h3>9.2</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card kpi-card-dashboard">
                        <i class="fas fa-calendar-check"></i>
                        <h6>Tareas Pendientes</h6>
                        <h3>4</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleBtn").onclick = function () {
            document.getElementById("sidebar").classList.toggle("closed");
            document.querySelector(".content").classList.toggle("full-width");
        }
    </script>

</body>
</html>