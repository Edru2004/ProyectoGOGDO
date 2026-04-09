<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo - GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <div class="contenedor"> <nav class="menu" id="sidebar"> <div class="menu-header">
                <button class="toggle-btn" id="btn-toggle-sidebar">☰</button>
                <h2 class="menu-title">Admin Panel</h2>
            </div>

            <div class="user-panel">
                <div class="image-wrapper">
                    <img src="https://ui-avatars.com/api/?name=Dulce+Rubi&background=0d6efd&color=fff" class="user-img" alt="User">
                </div>
                <div class="info">
                    <span class="user-name">Dulce Rubi</span>
                </div>
            </div>
            <hr class="sidebar-divider">

            <ul>
               <li>
  <a href="{{ route('inicio') }}">
    <span class="icon"><i class="bi bi-house-door"></i></span> 
    <span class="text">Inicio</span>
</a>
</li>
                <li>
                    <a href="{{ route('estudiantes.index') }}" class="text-decoration-none">
                        <span class="icon"><i class="bi bi-people"></i></span> 
                        <span class="text">Personal Estudiantil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('docentes.index') }}" class="text-decoration-none">
                        <span class="icon"><i class="bi bi-people"></i></span> 
                        <span class="text">Personal Docente</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tutores.index') }}" class="text-decoration-none">
                        <span class="icon"><i class="bi bi-people"></i></span> 
                        <span class="text">Personal padres de Familia</span>
                    </a>
                </li>
            </ul>
        </nav>

        <main class="contenido" id="contenido">
            @yield('contenido_dinamico') 
        </main>
    </div>

    <script>
        // Script para el toggle que definiste en tu CSS (.collapsed)
        document.getElementById('btn-toggle-sidebar').onclick = function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        };
    </script>
</body>
</html>