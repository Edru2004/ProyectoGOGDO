@extends('docentes.dashboard_maestro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Dependencias Visuales -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }

    /* FRANJA INSTITUCIONAL DINÁMICA (Estilo image_747ce0.png) */
    .franja-institucional {
        background: linear-gradient(-45deg, #5c6e75, #708090, #4a5568, #2d3748);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
        border-radius: 8px;
        padding: 20px;
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

    .card-kpi { border: none; border-radius: 10px; color: white; transition: 0.3s; height: 100px; display: flex; flex-direction: column; justify-content: center; padding-left: 20px; }
    .card-kpi:hover { transform: scale(1.02); }

    #calendar { background-color: white; padding: 20px; border-radius: 12px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    .fc-toolbar-title { font-weight: bold; text-transform: capitalize !important; }
</style>

<div class="container-fluid px-4 pb-5">
    
    <!-- ENCABEZADO INSTITUCIONAL -->
    <div class="row mb-4 mt-3">
        <div class="col-12 text-center">
            <div class="franja-institucional">
                <div class="flex-grow-1">
                    <h2 class="text-white fw-bold mb-0" style="letter-spacing: 2px; font-size: 1.6rem; text-transform: uppercase;">
                        BACHILLERATO GENERAL OFICIAL GUSTAVO DIAZ ORDAZ
                    </h2>
                </div>
                <div class="bg-white p-1 rounded shadow-sm">
                    <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="GDO" style="height: 60px; width: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- TÍTULO DE BIENVENIDA -->
    <div class="text-center mb-4">
        <h1 class="fw-bold" style="color: #198754; font-size: 2.5rem;">Panel de Inicio</h1>
        <p class="text-muted">Bienvenido al Sistema de Control Estudiantil - GDO, <strong>{{ Auth::guard('docente')->user()->nombre }}</strong>.</p>
    </div>

    <!-- SECCIÓN DE KPIs Y GRÁFICA (Igual a image_747ce0.png) -->
    <div class="row mb-4">
        <!-- Tarjetas Laterales -->
        <div class="col-lg-4">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card card-kpi shadow-sm" style="background-color: #0d6efd;">
                        <small class="text-uppercase fw-bold opacity-75">Grupos Asignados</small>
                        <h2 class="fw-bold mb-0">6</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-kpi shadow-sm" style="background-color: #198754;">
                        <small class="text-uppercase fw-bold opacity-75">Alumnos Totales</small>
                        <h2 class="fw-bold mb-0">180</h2>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-kpi shadow-sm text-dark" style="background-color: #ffc107;">
                        <small class="text-uppercase fw-bold opacity-75 text-dark">Pendientes de Evaluar</small>
                        <h2 class="fw-bold mb-0">15</h2>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráfica Central -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 12px;">
                <h6 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill me-2 text-success"></i>Promedio por Grupo</h6>
                <div style="height: 250px;">
                    <canvas id="graficaDocente"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- CALENDARIO Y NOTAS RÁPIDAS -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div id='calendar'></div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm p-4 h-100" style="border-radius: 12px;">
                <h5 class="fw-bold mb-4 text-dark"><i class="bi bi-pin-angle-fill text-danger me-2"></i>Notas Rápidas</h5>
                <div id="formNota">
                    <div class="mb-2">
                        <input type="text" id="notaTitulo" class="form-control border-0 bg-light" placeholder="¿Qué tarea hay hoy?">
                    </div>
                    <div class="mb-3">
                        <input type="date" id="notaFecha" class="form-control border-0 bg-light">
                    </div>
                    <button type="button" id="btnAgregar" class="btn btn-success w-100 fw-bold py-2 shadow-sm" style="background-color: #198754; border: none;">
                        <i class="bi bi-plus-circle me-1"></i> Agendar a mi calendario
                    </button>
                </div>
                <hr class="my-4">
                <p class="text-muted small text-center">Haz clic en una fecha para programar recordatorios o eventos de clase.</p>
            </div>
        </div>
    </div>
</div>

<!-- BOTÓN Y VENTANA FLOTANTE DE GEMINI (IA) -->
<div id="gemini-toggle" onclick="toggleGemini()" style="position: fixed; bottom: 30px; right: 30px; background: linear-gradient(135deg, #0d6efd, #0dcaf0); color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 1000;">
    <i class="bi bi-stars fs-3"></i>
</div>

<div id="gemini-window" style="display: none; position: fixed; bottom: 100px; right: 30px; width: 380px; background: white; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 1000; overflow: hidden; border: 1px solid #ddd;">
    <div style="background: #0d6efd; color: white; padding: 15px; font-weight: bold; display: flex; justify-content: space-between;">
        <span><i class="bi bi-robot me-2"></i> Asistente GDO (IA)</span>
        <span onclick="toggleGemini()" style="cursor: pointer;">&times;</span>
    </div>
    <div id="gemini-body" style="height: 350px; overflow-y: auto; padding: 15px; background: #f8f9fa;">
        <div class="mb-2"><span style="background: #e9ecef; padding: 8px 12px; border-radius: 15px; display: inline-block;">¡Hola, Profe! Soy la IA de GDO. ¿Le ayudo con sus calificaciones o grupos?</span></div>
    </div>
    <div id="gemini-loading" style="display: none; padding: 5px 15px;"><small class="text-primary">Escribiendo...</small></div>
    <div style="padding: 10px; border-top: 1px solid #ddd; display: flex; gap: 5px;">
        <input type="text" id="gemini-input" class="form-control" placeholder="Pregunte algo...">
        <button onclick="preguntarGemini()" id="btn-env" class="btn btn-primary"><i class="bi bi-send"></i></button>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>

<script>
    // --- LÓGICA DEL CALENDARIO ---
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            headerToolbar: { left: 'prev,next hoy', center: 'title', right: 'dayGridMonth,timeGridWeek' },
            selectable: true,
            themeSystem: 'bootstrap5',
            events: [{ title: 'Entrega de Notas', start: '2026-05-15', color: '#198754' }],
            dateClick: function(info) {
                document.getElementById('notaFecha').value = info.dateStr;
                document.getElementById('notaTitulo').focus();
            }
        });
        calendar.render();

        document.getElementById('btnAgregar').addEventListener('click', function() {
            let titulo = document.getElementById('notaTitulo').value;
            let fecha = document.getElementById('notaFecha').value;
            if (titulo && fecha) {
                calendar.addEvent({ title: titulo, start: fecha, allDay: true, color: '#0d6efd' });
                document.getElementById('notaTitulo').value = '';
            }
        });

        // --- LÓGICA DE LA GRÁFICA ---
        const ctx = document.getElementById('graficaDocente').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1-A', '1-B', '2-A', '2-B', '3-A', '3-B'],
                datasets: [{
                    label: 'Promedio',
                    data: [8.5, 9.0, 7.8, 9.2, 8.8, 8.1],
                    backgroundColor: '#198754',
                    borderRadius: 5
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    });

    // --- FUNCIONES IA GEMINI ---
    function toggleGemini() {
        const win = document.getElementById('gemini-window');
        win.style.display = win.style.display === 'none' ? 'block' : 'none';
    }

    async function preguntarGemini() {
        // ... Su lógica de preguntarGemini existente ...
    }
</script>
@endsection