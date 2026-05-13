@extends('Index')

@section('contenido_dinamico')

<!-- 1. ESTILOS PARA EL LOADER -->
<style>
    #loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        display: none; /* Se activa con JS */
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .spinner-gdo {
        width: 3.5rem;
        height: 3.5rem;
        border: 5px solid #e9ecef;
        border-top: 5px solid #ffc107; /* Color warning para combinar con tu edición */
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-text {
        margin-top: 20px;
        color: #856404; /* Texto oscuro tipo warning */
        font-weight: 600;
        letter-spacing: 1px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
</style>

<div class="container mt-4">
    <div class="mb-3">
        <a href="{{ route('docentes.show', $docente->id_docente) }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Volver al Horario
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-warning py-3">
            <h4 class="mb-0 fw-bold text-dark">
                <i class="bi bi-pencil-square me-2"></i>Editar Horario: {{ $docente->nombre }} {{ $docente->apellido_p }}
            </h4>
        </div>
        
        <div class="card-body p-4">
            <!-- Agregamos un ID al form para el script -->
            <form id="form-editar-horario" action="{{ route('docentes.actualizarHorario', $asignacion->id_asignacion) }}" method="POST">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="id_docente" value="{{ $docente->id_docente }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Materia</label>
                        <select name="id_materia" class="form-select" required>
                            @foreach($materias as $m)
                                <option value="{{ $m->id_materia }}" {{ $asignacion->id_materia == $m->id_materia ? 'selected' : '' }}>
                                    {{ $m->nombre_materia }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Semestre</label>
                        <select id="select-semestre" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            @php $sems = ['1'=>'Primero', '2'=>'Segundo', '3'=>'Tercero', '4'=>'Cuarto', '5'=>'Quinto', '6'=>'Sexto']; @endphp
                            @foreach($sems as $num => $txt)
                                <option value="{{ $num }}" {{ ($asignacion->id_semestre == $num) ? 'selected' : '' }}>{{ $txt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-bold">Grupo</label>
                        <select name="id_grupo" id="select-grupo" class="form-select" required>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id_grupo }}" 
                                        data-semestre="{{ $g->id_semestre }}"
                                        {{ $asignacion->id_grupo == $g->id_grupo ? 'selected' : '' }}>
                                    {{ $g->id_semestre }}° {{ $g->nombre_grupo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Día</label>
                        <select name="dia_semana" class="form-select" required>
                            @foreach(['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes'] as $dia)
                                <option value="{{ $dia }}" {{ $asignacion->dia_semana == $dia ? 'selected' : '' }}>{{ $dia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="form-control" value="{{ $asignacion->hora_inicio }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hora Fin</label>
                        <input type="time" name="hora_fin" class="form-control" value="{{ $asignacion->hora_fin }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Aula / Salón</label>
                    <input type="text" name="aula" class="form-control" value="{{ $asignacion->aula }}" required>
                </div>

                <div class="text-end border-top pt-3">
                    <button type="submit" class="btn btn-warning px-4 shadow-sm fw-bold">
                        <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- COMPONENTE DEL LOADER -->
<div id="loader-overlay">
    <div class="spinner-gdo"></div>
    <div class="loading-text">
        ACTUALIZANDO ASIGNACIÓN...
    </div>
    <p class="text-muted mt-2 small">Plataforma GDO | San Martín Texmelucan</p>
</div>

<script>
// Script de filtrado
document.getElementById('select-semestre').addEventListener('change', function() {
    const sem = this.value;
    const selectGrupo = document.getElementById('select-grupo');
    selectGrupo.querySelectorAll('option').forEach(opt => {
        if (opt.value === "") return;
        opt.style.display = (opt.getAttribute('data-semestre') === sem) ? 'block' : 'none';
    });
});

// Script para activar el Loader al enviar
document.getElementById('form-editar-horario').addEventListener('submit', function(e) {
    if (this.checkValidity()) {
        document.getElementById('loader-overlay').style.display = 'flex';
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Espere...';
    }
});
</script>

@endsection