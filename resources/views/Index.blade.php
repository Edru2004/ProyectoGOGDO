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

  <style>
    /* --- ESTILOS GLOBALES DE MODO OSCURO --- */
    
    /* 1. Fondos y Colores Base */
    body.dark-mode {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .contenido {
        background-color: #121212 !important;
    }

    /* 2. Tablas y Contenido de Datos */
    body.dark-mode .table, 
    body.dark-mode .table td, 
    body.dark-mode .table th,
    body.dark-mode .table tr,
    body.dark-mode .table td * {
        background-color: #1e1e1e !important;
        color: #ffffff !important; /* Blanco puro para nombres y datos */
        border-color: #333 !important;
    }

    /* 3. Tarjetas (Cards) */
    body.dark-mode .card:not(.bg-primary, .bg-success, .bg-warning) {
        background-color: #1e1e1e !important;
        border: 1px solid #333 !important;
        color: #ffffff !important;
    }

    /* 4. Formularios e Inputs */
    body.dark-mode .form-control, 
    body.dark-mode .form-select {
        background-color: #2d2d2d !important;
        border-color: #444 !important;
        color: #ffffff !important;
    }

    body.dark-mode .form-control::placeholder {
        color: #888 !important;
    }

    /* 5. Textos Secundarios y Pequeños */
    body.dark-mode .text-muted, 
    body.dark-mode small,
    body.dark-mode .info small {
        color: #bbbbbb !important; /* Gris claro para correos y descripciones */
    }

    /* 6. Botón de Cambio de Tema (Efectos) */
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
                        <span class="icon"><i class="bi bi-people-fill"></i></span> 
                        <span class="text">Padres de Familia</span>
                    </a>
                </li>
            </ul>

           <div class="mt-auto">
    <!-- Formulario oculto para el logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Enlace que activa el formulario -->
    <a href="#" 
       class="text-white text-decoration-none d-flex align-items-center p-2 opacity-75" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right fs-4"></i>
        <span class="text ms-3">Cerrar Sesión</span>
    </a>
</div>
        </nav>

        <main class="contenido" id="contenido">
            @yield('contenido_dinamico') 
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- LÓGICA DE SIDEBAR ---
        const btnToggle = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar');

        btnToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });

        // --- LÓGICA DE MODO OSCURO GLOBAL ---
        const btnTheme = document.getElementById('btn-theme');
        const themeIcon = document.getElementById('theme-icon');
        const body = document.body;

        // Función para aplicar el tema sin repetir código
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
                themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
            } else {
                body.classList.remove('dark-mode');
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
            }
        }

        // Leer preferencia al cargar la página
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