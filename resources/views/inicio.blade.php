@extends('index')

@section('contenido_dinamico')
<!-- FullCalendar CDN para que funcione el calendario -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="container-fluid px-0">
    {{-- Franja Superior con Movimiento (Gradiente Animado) --}}
    <div class="row g-0 align-items-center shadow-sm mb-4 header-animado" style="min-height: 100px;">
        <div class="col-md-2 d-none d-md-block"></div>

        <div class="col-12 col-md-8 text-center py-3">
            <h1 class="text-white fw-bold mb-0 text-uppercase" style="font-family: 'Poppins', sans-serif; letter-spacing: 2px; font-size: 1.8rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                Escuela Gabino Barreda Oriente
            </h1>
        </div>

        <div class="col-md-2 d-flex justify-content-center justify-content-md-end pe-md-4 py-2">
            <div class="bg-white p-1 rounded shadow-sm d-flex align-items-center justify-content-center logo-contenedor" style="width: 85px; height: 85px;">
                <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" 
                     class="img-fluid" 
                     style="max-height: 75px; width: auto;">
            </div>
        </div>
    </div>

    {{-- Contenido Principal --}}
    <div class="px-4">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold text-success mb-0" style="font-family: 'Poppins', sans-serif;">
                    Panel de Inicio
                </h2>
                <p class="lead text-muted mt-2">Bienvenida al Sistema de Control Estudiantil - GDO, Dulce Rubi.</p>
                <hr class="mx-auto" style="width: 10%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">
            </div>
        </div>

        {{-- Tarjetas de Estadísticas --}}
        <div class="row mb-5">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white shadow-sm border-0 h-100 overflow-hidden">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Total Alumnos</h6>
                            <h2 class="fw-bold mb-0">{{ $totalEstudiantes }}</h2>
                        </div>
                        <i class="bi bi-people-fill fs-1 opacity-50"></i>
                    </div>
                    <button onclick="verGrafica('alumnos')" class="btn btn-primary border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                        <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                    </button>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white shadow-sm border-0 h-100 overflow-hidden">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Personal Docente</h6>
                            <h2 class="fw-bold mb-0">{{ $totalDocentes }}</h2>
                        </div>
                        <i class="bi bi-person-badge-fill fs-1 opacity-50"></i>
                    </div>
                    <button onclick="verGrafica('docentes')" class="btn btn-success border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                        <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                    </button>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card bg-warning text-dark shadow-sm border-0 h-100 overflow-hidden">
                    <div class="p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase fw-bold opacity-75">Padres de Familia</h6>
                            <h2 class="fw-bold mb-0">{{ $totalTutores }}</h2>
                        </div>
                        <i class="bi bi-shield-lock-fill fs-1 opacity-50"></i>
                    </div>
                    <button onclick="verGrafica('padres')" class="btn btn-warning border-0 bg-dark bg-opacity-10 py-2 rounded-0">
                        <small><i class="bi bi-graph-up me-1"></i> Inspeccionar gráficas</small>
                    </button>
                </div>
            </div>
        </div>

        {{-- SECCIÓN DE CALENDARIO (REEMPLAZA LA BÚSQUEDA) --}}
        <div class="row mb-5">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 p-3">
                    <div id='calendar'></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 p-4 bg-light h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Notas Importantes</h5>
                    <div class="mb-3">
                        <input type="text" id="eventTitle" class="form-control mb-2" placeholder="¿Qué hay de nuevo?">
                        <input type="date" id="eventDate" class="form-control mb-2">
                        <button class="btn btn-success w-100" onclick="addNewEvent()">Agregar al Calendario</button>
                    </div>
                    <hr>
                    <div id="eventList" class="small text-muted">
                        <p>Haz clic en una fecha para añadir recordatorios.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Accesos Directos --}}
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 p-4 hover-card">
                    <i class="bi bi-people text-success fs-1"></i>
                    <h4 class="fw-bold mt-3">Estudiantes</h4>
                    <div class="d-flex gap-2 justify-content-center mt-auto">
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                        <a href="{{ route('estudiantes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 p-4 hover-card">
                    <i class="bi bi-person-workspace text-success fs-1"></i>
                    <h4 class="fw-bold mt-3">Docentes</h4>
                    <div class="d-flex gap-2 justify-content-center mt-auto">
                        <a href="{{ route('docentes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                        <a href="{{ route('docentes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 p-4 hover-card">
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
</div>

{{-- MODAL PARA GRÁFICAS --}}
<div class="modal fade" id="modalGraficas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="tituloModal">Estadísticas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div style="min-height: 350px;">
                    <canvas id="miGraficaCanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Lógica del Calendario
    var calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            themeSystem: 'bootstrap5',
            events: [
                { title: 'Entrega Proyecto GDO', start: '2026-05-15', color: '#198754' }
            ],
            dateClick: function(info) {
                document.getElementById('eventDate').value = info.dateStr;
            }
        });
        calendar.render();
    });

    function addNewEvent() {
        const title = document.getElementById('eventTitle').value;
        const date = document.getElementById('eventDate').value;
        if(title && date) {
            calendar.addEvent({ title: title, start: date, allDay: true });
            document.getElementById('eventTitle').value = '';
            alert("¡Nota guardada!");
        }
    }

    // Lógica de Gráficas
    let chartInstance = null;
    function verGrafica(tipo) {
        const ctx = document.getElementById('miGraficaCanvas').getContext('2d');
        const modalElement = document.getElementById('modalGraficas');
        const modal = new bootstrap.Modal(modalElement);
        const titulo = document.getElementById('tituloModal');

        if (chartInstance) { chartInstance.destroy(); }

        let config = {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{ label: 'Cantidad', data: [], backgroundColor: '#198754', borderRadius: 5 }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        };

        if (tipo === 'alumnos') {
            titulo.innerHTML = 'Alumnos por Semestre';
            config.data.labels = ['1ero', '3ero', '5to'];
            config.data.datasets[0].data = [4, 2, 2];
            config.data.datasets[0].backgroundColor = '#0d6efd';
        } else if (tipo === 'docentes') {
            titulo.innerHTML = 'Estatus Docentes';
            config.data.labels = ['Activos', 'En Curso'];
            config.data.datasets[0].data = [3, 0];
            config.data.datasets[0].backgroundColor = '#198754';
        } else if (tipo === 'padres') {
            titulo.innerHTML = 'Parentesco Tutores';
            config.data.labels = ['Madre', 'Padre', 'Otro'];
            config.data.datasets[0].data = [1, 1, 1];
            config.data.datasets[0].backgroundColor = '#ffc107';
        }

        chartInstance = new Chart(ctx, config);
        modal.show();
    }
</script>

<style>
    /* Estilos del Header Animado */
    .header-animado {
        background: linear-gradient(-45deg, #2c3e50, #7f8c8d, #34495e, #95a5a6);
        background-size: 400% 400%;
        animation: gradientMove 12s ease infinite;
    }
    @keyframes gradientMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Estilos Calendario */
    #calendar { max-height: 500px; font-size: 0.9rem; }
    .fc-header-toolbar { padding-top: 10px; }
    .fc-daygrid-day:hover { background-color: #f1f3f5; cursor: pointer; }

    .hover-card { transition: transform 0.3s ease; }
    .hover-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>
@endsection