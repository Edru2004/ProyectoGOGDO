@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4 px-4">
    
    {{-- Botón Regresar --}}
    <div class="mb-4">
        <a href="{{ route('docentes.index') }}" class="text-secondary text-decoration-none fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Regresar al Listado de Docentes
        </a>
    </div>

    {{-- Encabezado: Info Docente + Stats --}}
    <div class="row g-3 mb-4">
        {{-- Card Perfil --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 h-100 py-3">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-person-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="fw-bold mb-0 text-dark">{{ $docente->nombre }} {{ $docente->apellido_p }}</h4>
                        <p class="text-muted small mb-2">Panel de Docente - GDO</p>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-light text-dark border small"><i class="bi bi-card-text me-1"></i> {{ $docente->curp }}</span>
                            <span class="badge bg-light text-dark border small"><i class="bi bi-envelope me-1"></i> {{ $docente->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards (Valores dinámicos) --}}
        <div class="col-xl-8 col-lg-7">
            <div class="row g-3 h-100">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center h-100 justify-content-center p-3">
                        <div class="icon-shape bg-light-success rounded-circle mb-2 mx-auto">
                            <i class="bi bi-book text-success"></i>
                        </div>
                        <h5 class="fw-bold mb-0">{{ $asignaciones->count() }}</h5>
                        <small class="text-muted">Clases asignadas</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center h-100 justify-content-center p-3">
                        <div class="icon-shape bg-light-primary rounded-circle mb-2 mx-auto">
                            <i class="bi bi-clock text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">25</h5> {{-- Puedes calcular esto sumando horas --}}
                        <small class="text-muted">Horas semanales</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center h-100 justify-content-center p-3">
                        <div class="icon-shape bg-light-info rounded-circle mb-2 mx-auto">
                            <i class="bi bi-mortarboard text-info"></i>
                        </div>
                        <h5 class="fw-bold mb-0">{{ $asignaciones->unique('id_materia')->count() }}</h5>
                        <small class="text-muted">Materias diff.</small>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 text-center h-100 justify-content-center p-3">
                        <div class="icon-shape bg-light-warning rounded-circle mb-2 mx-auto">
                            <i class="bi bi-calendar-event text-warning"></i>
                        </div>
                        <h5 class="fw-bold mb-0">{{ $asignaciones->unique('dia_semana')->count() }}</h5>
                        <small class="text-muted">Días activos</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Carga Académica --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <h5 class="mb-0 fw-bold d-flex align-items-center">
                <i class="bi bi-journal-text me-2 text-success"></i> Carga Académica Actual
            </h5>
            <div class="d-flex gap-2">
                <a href="{{ route('docentes.descargarHorario', $docente->id_docente) }}" class="btn btn-outline-danger btn-sm px-3">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar PDF
                </a>
                <a href="{{ route('docentes.crearHorario', $docente->id_docente) }}" class="btn btn-success btn-sm px-3 shadow-sm">
                    <i class="bi bi-plus-lg"></i> Agregar Clase
                </a>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4">Materia</th>
                            <th>Semestre</th>
                            <th>Grupo</th>
                            <th>Día</th>
                            <th>Horario</th>
                            <th>Salón</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($asignaciones as $a)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-success">{{ $a->materia->nombre_materia }}</span>
                            </td>
                            <td>{{ $a->grupo->semestre->nombre_semestre ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $a->grupo->nombre_grupo }}</span></td>
                            <td>{{ $a->dia_semana }}</td>
                            <td class="text-muted small">
                                {{ \Carbon\Carbon::parse($a->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($a->hora_fin)->format('H:i') }}
                            </td>
                            <td>
                                <span class="text-primary fw-medium">
                                    <i class="bi bi-geo-alt-fill small"></i> {{ $a->aula }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('docentes.editarHorario', $a->id_asignacion) }}" class="btn btn-link text-warning p-0 me-3" title="Editar">
                                        <i class="bi bi-pencil-square fs-5"></i>
                                    </a>
                                    <form action="{{ route('docentes.eliminarHorario', $a->id_asignacion) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta clase?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Eliminar">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($asignaciones->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-2">No hay materias asignadas aún.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 0.75rem; }
    .icon-shape {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .bg-light-success { background-color: #e8f5e9; }
    .bg-light-primary { background-color: #e3f2fd; }
    .bg-light-info { background-color: #e0f7fa; }
    .bg-light-warning { background-color: #fff3e0; }
    
    .table thead th {
        font-weight: 600;
        font-size: 0.75rem;
        border-top: none;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .table tbody td {
        padding-top: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f2f2f2;
    }
    .btn-link { text-decoration: none; }
    .btn-link:hover { opacity: 0.8; }
</style>
@endsection