<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Estudiantil - GDO</title>
    <!-- Google Fonts & Bootstrap (Solo para componentes como tablas/cards) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Tus estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

    <style>
        /* --- AJUSTES EXTRA PARA MODO OSCURO SOBRE TUS ESTILOS --- */
        body.dark-mode {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .contenido {
            background-color: #121212 !important;
        }

        body.dark-mode .card:not(.bg-primary, .bg-success, .bg-warning) {
            background-color: #1e1e1e !important;
            border: 1px solid #333 !important;
            color: #ffffff !important;
        }

        body.dark-mode .table,
        body.dark-mode .table td,
        body.dark-mode .table th {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
            border-color: #333 !important;
        }

        /* Ajuste para el botón de tema */
        #btn-theme {
            transition: transform 0.3s ease;
        }

        #btn-theme:hover {
            transform: scale(1.1);
        }

        /* --- AGREGAR ESTO DENTRO DE body.dark-mode --- */

        /* Forzar que el texto de ayuda/muted sea legible */
        body.dark-mode .text-muted {
            color: #b0b0b0 !important;
            /* Un gris mucho más claro */
        }

        /* Ajuste para los nombres de usuario o textos secundarios en el sidebar */
        body.dark-mode .info small,
        body.dark-mode .user-panel small {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        /* Si usas la clase .lead de Bootstrap */
        body.dark-mode .lead {
            color: #e0e0e0 !important;
        }
    </style>
</head>

<body>
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('dark-mode');
            }
        })();
    </script>

    {{-- BOTÓN GLOBAL DE MODO OSCURO --}}
    <div style="position: fixed; right: 30px; top: 15px; z-index: 9999;">
        <button id="btn-theme" class="btn btn-success rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
            <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
        </button>
    </div>

    <div class="contenedor">
        <!-- SIDEBAR (Usa tus clases .menu) -->
        <nav class="menu" id="sidebar">
            <div class="menu-header">
                <button class="toggle-btn" id="btn-toggle-sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <h2 class="menu-title">GDO Estudiante</h2>
            </div>

            <!-- Panel de Perfil (Usa tus clases .user-panel) -->
            <div class="user-panel">
                <div class="image-wrapper">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::guard('estudiante')->user()->nombre }}&background=fff&color=6c993e" class="user-img" alt="User">
                </div>
                <div class="info">
                    <span class="user-name">{{ Auth::guard('estudiante')->user()->nombre }}</span>
                    <small style="color: rgba(0,0,0,0.6)">Estudiante</small>
                </div>
            </div>

            <!-- Lista de Navegación -->

            <!-- Lista de Navegación corregida -->
            <!-- Lista de Navegación corregida -->
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('estudiante.inicio_estudiantes') }}" class="{{ Request::is('estudiante/inicio*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-house-door-fill"></i></span>
                        <span class="text">Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('estudiante.credencial') }}" class="{{ Request::is('estudiante/credencial*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-person-badge-fill"></i></span>
                        <span class="text">Mi Credencial</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('estudiante.calificaciones') }}" class="{{ Request::is('estudiante/calificaciones*') ? 'active' : '' }}">
                        <span class="icon"><i class="bi bi-star-fill"></i></span>
                        <span class="text">Mis Calificaciones</span>
                    </a>
                </li>
            </ul>

            <!-- Botón de Cerrar Sesión -->
            <div class="mt-auto">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                </form>
                <a href="#" class="text-decoration-none d-flex align-items-center p-2 opacity-75"
                    style="color: var(--sidebar-text)"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="icon"><i class="bi bi-box-arrow-right"></i></span>
                    <span class="text ms-3">Cerrar Sesión</span>
                </a>
            </div>
        </nav>

        <!-- CONTENIDO (Usa tu clase .contenido) -->
        <main class="contenido" id="contenido">

            {{-- Sección de Bienvenida (Opcional, solo en dashboard) --}}





            <!-- CONTENIDO DINÁMICO -->
            @yield('content')

        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Lógica de Sidebar compatible con tus estilos
        const btnToggle = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // Lógica de Modo Oscuro
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

        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);

        btnTheme.addEventListener('click', () => {
            const isDark = body.classList.toggle('dark-mode');
            const newTheme = isDark ? 'dark' : 'light';
            localStorage.setItem('theme', newTheme);
            applyTheme(newTheme);
        });
    </script>
</body>

</html>