<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - GDO</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>
    <div class="contenedor">
        <nav class="menu" id="sidebar">
            <div class="menu-header">
                <button class="toggle-btn" id="btn-toggle-sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h2 class="menu-title">GDO Admin</h2>
            </div>

            <div class="user-panel">
                <div class="image-wrapper">
                    <img src="https://ui-avatars.com/api/?name=Dulce+Rubi&background=fff&color=6c993e" class="user-img" alt="User">
                </div>
                <div class="info">
                    <span class="user-name">Dulce Rubi</span>
                    <small style="color: rgba(255,255,255,0.7)">Administrador</small>
                </div>
            </div>

            <ul>
                <li>
                    <a href="{{ route('inicio') }}" class="{{ Request::is('inicio*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-grid-1x2-fill"></i></span> 
                        <span class="text">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('estudiantes.index') }}" class="{{ Request::is('estudiantes*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-person-video3"></i></span> 
                        <span class="text">Gestión Estudiantil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('docentes.index') }}" class="{{ Request::is('docentes*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-briefcase-fill"></i></span> 
                        <span class="text">Personal Docente</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tutores.index') }}" class="{{ Request::is('tutores*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-people text-fill fs-1"></i></span> 
                        <span class="text">Padres de Familia</span>
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                <a href="#" class="text-white text-decoration-none d-flex align-items-center p-2 opacity-75">
                    <i class="bi bi-box-arrow-right fs-4"></i>
                    <span class="text ms-3">Cerrar Sesión</span>
                </a>
            </div>
        </nav>

        <main class="contenido" id="contenido">
            @yield('contenido_dinamico') 
        </main>
    </div>

    <script>
        const btnToggle = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    </script>
</body>
</html>