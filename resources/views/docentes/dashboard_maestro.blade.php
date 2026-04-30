<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Docente - GDO</title>
    <!-- Google Fonts & Bootstrap -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Archivo CSS del Proyecto -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <style>
        /* MODO OSCURO */
        body.dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .contenido {
            background-color: #121212 !important;
        }

        body.dark-mode .card {
            background-color: #1e1e1e !important;
            border: 1px solid #333 !important;
            color: #ffffff !important;
        }

        body.dark-mode .text-muted {
            color: #b0b0b0 !important;
        }

        /* Estilos específicos para elementos del docente */
        .icon-box {
            width: 50px;
            height: 50px;
            background: #e8f5e9;
            color: #118b2e;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }

        #btn-theme {
            transition: transform 0.3s ease;
        }

        #btn-theme:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <script>
        /* Aplicar tema antes de que cargue el body para evitar parpadeos */
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        })();
    </script>

    {{-- BOTÓN FLOTANTE DE MODO OSCURO --}}
    <div style="position: fixed; right: 30px; top: 15px; z-index: 9999;">
        <button id="btn-theme" class="btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
        </button>
    </div>

    <div class="contenedor">
        <!-- SIDEBAR -->
        <nav class="menu" id="sidebar">
            <div class="menu-header">
                <button class="toggle-btn" id="btn-toggle-sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h2 class="menu-title">GDO Docente</h2>
            </div>

            <!-- Panel de Perfil del Maestro -->
            <div class="user-panel">
                <div class="image-wrapper">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::guard('docente')->user()->nombre }}&background=118b2e&color=fff" class="user-img" alt="Docente">
                </div>
                <div class="info">
                    <span class="user-name">{{ Auth::guard('docente')->user()->nombre }}</span>
                    <small style="color: rgba(0,0,0,0.6)">Personal Docente</small>
                </div>
            </div>

            <!-- Lista de Navegación Actualizada -->
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('docente.inicio_docentes') }}" class="{{ Request::is('docente/inicio*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-house-door-fill"></i></span>
                        <span class="text">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('docente.clases_docente') }}" class="{{ Request::is('docente/mis-clases*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-grid-fill"></i></span>
                        <span class="text">Mis Clases</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('docente.alumnos') }}" class="{{ Request::is('docente/alumnos*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-people-fill"></i></span>
                        <span class="text">Mis Alumnos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('docente.visualizar_horario') }}" class="{{ Request::is('docente/horario*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-calendar3"></i></span>
                        <span class="text">Mi Horario</span>
                    </a>
                </li>
            </ul>

            <!-- Cerrar Sesión -->
            <div class="mt-auto">
                <form id="logout-form" action="{{ route('docente.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="text-decoration-none d-flex align-items-center p-2 opacity-75"
                    style="color: var(--sidebar-text)"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon"><i class="bi bi-box-arrow-right"></i></span>
                    <span class="text ms-3">Cerrar Sesión</span>
                </a>
            </div>
        </nav>

        <!-- CONTENIDO PRINCIPAL -->
        <main class="contenido" id="contenido">
            <header class="d-flex justify-content-between align-items-center mb-4 px-3 pt-3">
                <div>
                    <h2 class="fw-bold mb-0">Panel de Control</h2>
                    <p class="text-muted small">Bachillerato Gustavo Díaz Ordaz</p>
                </div>
                <div class="bg-success p-2 rounded shadow-sm fw-bold text-white">
                    <i class="bi bi-calendar-check me-2"></i> Ciclo 2025-2026
                </div>
            </header>

            <div class="container-fluid">
                {{-- AQUÍ SE CARGARÁ EL CONTENIDO DE LAS OTRAS VISTAS --}}
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lógica de Sidebar
        const btnToggle = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Lógica de Cambio de Tema
        const btnTheme = document.getElementById('btn-theme');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
            } else {
                body.classList.remove('dark-mode');
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
            }
        }

        btnTheme.addEventListener('click', () => {
            const isDark = body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            applyTheme(isDark ? 'dark' : 'light');
        });

        // Carga inicial del icono
        if (localStorage.getItem('theme') === 'dark') {
            themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
        }
    </script>
</body>

</html>