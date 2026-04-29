@extends('index')

@section('contenido_dinamico')
<div class="container-fluid px-4">
    {{-- Encabezado --}}
    <div class="row mt-5 mb-4 position-relative">
              <div style="position: absolute; right: -1300px; top: -70px; z-index: 10;">
            <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" 
                 style="max-height: 120px; width: auto; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));">
        </div>

        <div class="col-12 text-center position-relative">
    {{-- Botón de Modo Oscuro --}}
  

        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-success mb-0" style="font-family: 'Poppins', sans-serif;">
                Panel de Inicio
            </h1>
            <p class="lead text-muted">Bienvenida al Sistema de Control Estudiantil - GDO, Dulce Rubi.</p>
            <hr class="mx-auto" style="width: 15%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">
        </div>
    </div>


    {{-- Tarjetas con botón de Inspeccionar --}}
    <div class="row mb-5">
        <!-- Alumnos -->
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow-sm border-0 h-100 overflow-hidden">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Total Alumnos</h6>
                            <h2 class="fw-bold mb-0">{{ $totalEstudiantes }}</h2>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-50"></i>
                    </div>
                </div>
                <button onclick="verGrafica('alumnos')" class="btn btn-primary border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                    <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                </button>
            </div>
        </div>

        <!-- Docentes -->
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow-sm border-0 h-100 overflow-hidden">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Personal Docente</h6>
                            <h2 class="fw-bold mb-0">{{ $totalDocentes }}</h2>
                        </div>
                        <i class="bi bi-person-badge-fill fs-1 opacity-50"></i>
                    </div>
                </div>
                <button onclick="verGrafica('docentes')" class="btn btn-success border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                    <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                </button>
            </div>
        </div>

        <!-- Padres -->
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-dark shadow-sm border-0 h-100 overflow-hidden">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Padres de Familia</h6>
                            <h2 class="fw-bold mb-0">{{ $totalTutores }}</h2>
                        </div>
                        <i class="bi bi-shield-lock-fill fs-1 opacity-50"></i>
                    </div>
                </div>
                <button onclick="verGrafica('padres')" class="btn btn-warning border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                    <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                </button>
            </div>
        </div>
    </div>

    {{-- Búsqueda Rápida --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card p-4 shadow-sm border-0" style="background-color: #f8f9fa;">
                <h5 class="fw-bold mb-3"><i class="bi bi-search me-2"></i>Búsqueda Rápida de Alumnos</h5>
                <form action="{{ route('estudiantes.index') }}" method="GET" class="input-group shadow-sm">
                    <input type="text" name="buscar" class="form-control border-0" placeholder="Nombre, apellido o matrícula..." style="padding: 12px;">
                    <button class="btn btn-success px-4" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Accesos Directos --}}
    <div class="row text-center mb-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-people text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Estudiantes</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('estudiantes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-person-workspace text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Docentes</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('docentes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-shield-check text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Padres</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('tutores.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('tutores.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL PARA GRÁFICAS --}}
<div class="modal fade" id="modalGraficas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="tituloModal">Estadísticas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div style="min-height: 300px;">
                    <canvas id="miGraficaCanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance = null;

    function verGrafica(tipo) {
        const ctx = document.getElementById('miGraficaCanvas').getContext('2d');
        const modal = new bootstrap.Modal(document.getElementById('modalGraficas'));
        const titulo = document.getElementById('tituloModal');

        if (chartInstance) { chartInstance.destroy(); }

        let config = {
            type: 'bar', // Todas serán de barras para mantener el diseño
            data: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    backgroundColor: '#0d6efd', // El azul vibrante de tu imagen
                    borderRadius: 5 // Bordes ligeramente redondeados en las barras
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 } // Para que no salgan decimales si no quieres
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        };

        if (tipo === 'alumnos') {
            titulo.innerHTML = '<i class="bi bi-people me-2"></i>Distribución de Alumnos por Grado';
            config.data.labels = ['1er Semestre', '3er Semestre', '5to Semestre'];
            config.data.datasets[0].label = 'Alumnos';
            config.data.datasets[0].data = [4, 2, 2]; // Datos de ejemplo
        } 
        else if (tipo === 'docentes') {
            titulo.innerHTML = '<i class="bi bi-person-badge me-2"></i>Estatus del Personal Docente';
            config.data.labels = ['Activos', 'En Curso', 'Inactivos'];
            config.data.datasets[0].label = 'Docentes';
            config.data.datasets[0].data = [3, 0, 0]; // Datos de ejemplo
        } 
        else if (tipo === 'padres') {
            titulo.innerHTML = '<i class="bi bi-shield-lock me-2"></i>Parentesco de Tutores';
            config.data.labels = ['Madre', 'Padre', 'Abuelo/a', 'Otro'];
            config.data.datasets[0].label = 'Padres';
            config.data.datasets[0].data = [1, 1, 1, 0]; // Datos de ejemplo
        }

        chartInstance = new Chart(ctx, config);
        modal.show();
    }

    // --- Lógica del Modo Oscuro ---
const btnTheme = document.getElementById('btn-theme');
const themeIcon = document.getElementById('theme-icon');
const body = document.body;

// 1. Revisar si ya existe una preferencia guardada
if (localStorage.getItem('theme') === 'dark') {
    body.classList.add('dark-mode');
    themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
}

// 2. Escuchar el click del botón
btnTheme.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    
    if (body.classList.contains('dark-mode')) {
        themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
        localStorage.setItem('theme', 'dark');
    } else {
        themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
        localStorage.setItem('theme', 'light');
    }
});
</script>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; }
    .btn-dark.bg-opacity-10:hover { background-color: rgba(0,0,0,0.2) !important; color: white; }
</style>
@endsection