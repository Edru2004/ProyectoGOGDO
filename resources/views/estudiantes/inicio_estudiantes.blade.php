@extends('estudiantes.dashboard')

@section('content')
<!-- Dependencias de Google Fonts y FullCalendar -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }

    /* FRANJA GRIS DINÁMICA (Efecto de cambio de color) */
    .franja-institucional {
        background: linear-gradient(-45deg, #5c6e75, #708090, #4a5568, #2d3748);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        border-radius: 8px;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Gráfica Compacta */
    .contenedor-grafica-mini {
        height: 180px; /* Tamaño reducido */
        position: relative;
    }

    /* Estilo del Calendario */
    #calendar {
        background-color: white;
        padding: 20px;
        border-radius: 12px;
        height: 580px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .fc-toolbar-title { font-weight: bold; text-transform: capitalize !important; color: #2d3748; }
    .fc-button-primary { background-color: #0d6efd !important; border: none !important; transition: 0.3s; }
    .fc-button-primary:hover { background-color: #0b5ed7 !important; }

    .card-kpi { border: none; border-radius: 10px; color: white; transition: 0.3s; }
    .card-kpi:hover { transform: scale(1.02); }
</style>

<div class="container-fluid px-4 pb-5">
    
    <!-- ENCABEZADO CON MOVIMIENTO -->
    <div class="row mb-4 mt-3">
        <div class="col-12">
            <div class="franja-institucional">
                <div class="flex-grow-1 text-center">
                    <h2 class="text-white fw-bold mb-0" style="letter-spacing: 2px; font-size: 1.6rem;">
                        BACHILLERATO GENERAL OFICIAL GUSTAVO DIAZ ORDAZ
                    </h2>
                </div>
                <div class="bg-white p-1 rounded shadow-sm">
                    <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="GDO" style="height: 50px; width: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- TÍTULO Y BIENVENIDA -->
    <div class="text-center mb-4">
        <h1 class="fw-bold" style="color: #198754;">Panel de Inicio</h1>
        <p class="text-muted">Bienvenida al Sistema de Control Estudiantil - GDO, <strong>{{ Auth::guard('estudiante')->user()->nombre }}</strong>.</p>
    </div>

    <!-- TARJETAS Y GRÁFICA EN UNA FILA -->
    <div class="row mb-4">
        <!-- Columna de KPIs -->
        <div class="col-lg-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card card-kpi p-3 shadow-sm" style="background-color: #0d6efd;">
                        <small class="text-uppercase fw-bold opacity-75">Materias Cursadas</small>
                        <h2 class="fw-bold mb-0">12</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-kpi p-3 shadow-sm" style="background-color: #198754;">
                        <small class="text-uppercase fw-bold opacity-75">Promedio Actual</small>
                        <h2 class="fw-bold mb-0">9.2</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-kpi p-3 shadow-sm text-dark" style="background-color: #ffc107;">
                        <small class="text-uppercase fw-bold opacity-75">Faltas Registradas</small>
                        <h2 class="fw-bold mb-0">2</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Columna de Gráfica Pequeña -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-3 h-100">
                <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Rendimiento Semestral</h6>
                <div class="contenedor-grafica-mini">
                    <canvas id="graficaRendimiento"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- CALENDARIO E INTERACCIÓN -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div id='calendar'></div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Notas Rápidas</h5>
                <div id="formNota">
                    <input type="text" id="notaTitulo" class="form-control mb-2 border-0 bg-light" placeholder="¿Qué tarea hay hoy?">
                    <input type="date" id="notaFecha" class="form-control mb-3 border-0 bg-light">
                    <button type="button" id="btnAgregar" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Agendar a mi calendario
                    </button>
                </div>
                <hr class="my-4">
                <div class="alert alert-primary border-0 small py-2">
                    <i class="bi bi-info-circle me-1"></i> Haz clic en cualquier día del calendario para seleccionarlo automáticamente.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Funcionamiento -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. GRÁFICA MINI ---
        const ctx = document.getElementById('graficaRendimiento').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mat', 'Sis', 'Ing', 'Fis', 'Qui'],
                datasets: [{
                    data: [9.5, 10, 8.5, 9.9, 7.5],
                    backgroundColor: '#198754',
                    borderRadius: 4,
                    barPercentage: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 10 } }
            }
        });

        // --- 2. CALENDARIO INTERACTIVO (Igual al admin) ---
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            selectable: true,
            editable: true,
            dayMaxEvents: true,
            events: [
                { title: 'Examen de Redes', start: '2026-05-15', color: '#198754' }
            ],
            // Al hacer clic en un día, se pone la fecha en el formulario
            dateClick: function(info) {
                document.getElementById('notaFecha').value = info.dateStr;
                document.getElementById('notaTitulo').focus();
            }
        });
        calendar.render();

        // Lógica para agregar eventos al vuelo
        document.getElementById('btnAgregar').addEventListener('click', function() {
            let titulo = document.getElementById('notaTitulo').value;
            let fecha = document.getElementById('notaFecha').value;

            if (titulo && fecha) {
                calendar.addEvent({
                    title: titulo,
                    start: fecha,
                    allDay: true,
                    color: '#0d6efd'
                });
                document.getElementById('notaTitulo').value = '';
            } else {
                alert('Escribe una nota y selecciona una fecha');
            }
        });
    });
</script>
@endsection