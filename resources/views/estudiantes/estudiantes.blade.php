@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4 px-4">
    {{-- Encabezado de la página --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary fw-bold">Lista de Estudiantes</h2>
        <a href="{{ route('estudiantes.pdf_general') }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i> Descargar Reporte General (PDF)
        </a>
    </div>
        
    {{-- Filtros y Botón Nuevo --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-3 align-items-center">
            <div class="btn-group shadow-sm">
                <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary btn-sm">Todos</a>

                {{-- Dropdown 1er Año --}}
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        1er Año
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 1, 'grupo' => 'A']) }}">Grupo A</a></li>
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 1, 'grupo' => 'B']) }}">Grupo B</a></li>
                    </ul>
                </div>

                {{-- Dropdown 2do Año --}}
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        2do Año
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 2, 'grupo' => 'A']) }}">Grupo A</a></li>
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 2, 'grupo' => 'B']) }}">Grupo B</a></li>
                    </ul>
                </div>

                {{-- Dropdown 3er Año --}}
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-warning btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        3er Año
                    </button>
                    <ul class="dropdown-menu border-warning">
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 3, 'grupo' => 'A']) }}">Grupo A</a></li>
                        <li><a class="dropdown-item" href="{{ route('estudiantes.index', ['grado' => 3, 'grupo' => 'B']) }}">Grupo B</a></li>
                    </ul>
                </div>
            </div> 

            <a href="{{ route('estudiantes.create') }}" class="btn btn-success shadow-sm px-4 fw-bold">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Alumno
            </a>
        </div>
    </div>

    {{-- Barra de Búsqueda --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('estudiantes.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="buscar" class="form-control border-start-0 ps-0" 
                               placeholder="Buscar por nombre, CURP o correo electrónico..." 
                               value="{{ request('buscar') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-search me-1"></i> buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla de Estudiantes --}}
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4" style="width: 50px;">
                                <input class="form-check-input" type="checkbox" id="selectAll" style="cursor: pointer; border: 1.5px solid #6c993e;">
                            </th>
                            <th class="ps-4" style="color: #444; font-weight: 600;">ID</th>
                            <th style="color: #444; font-weight: 600;">Nombre Completo</th>
                            <th style="color: #444; font-weight: 600;">CURP / Email</th>
                            <th style="color: #444; font-weight: 600;">Grado y Grupo</th>
                            <th class="text-center" style="color: #444; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantes as $est)
                        <tr>
                            <td class="ps-4">
                                <input class="form-check-input est-checkbox" type="checkbox" value="{{ $est->id_estudiante }}" style="cursor: pointer; border: 1.5px solid #6c993e;">
                            </td>
                            <td class="ps-4 text-muted">{{ $est->id_estudiante }}</td>
                            <td class="py-3">
                                <span class="fw-bold text-dark">{{ $est->nombre }} {{ $est->apellido_p }} {{ $est->apellido_m }}</span>
                            </td>
                            <td>
                                <div class="fw-bold" style="font-size: 0.85em; color: #2c3e50;">{{ $est->curp }}</div>
                                <div class="text-muted" style="font-size: 0.75em;">{{ $est->email }}</div>
                            </td>
                            <td>
                                @php
                                    $idSem = $est->inscripcion->id_semestre ?? 0;
                                    $badgeColor = 'bg-secondary';
                                    $anioLabel = 'S/A';

                                    if($idSem >= 1 && $idSem <= 2) { $badgeColor = 'bg-success'; $anioLabel = '1er Año'; }
                                    elseif($idSem >= 3 && $idSem <= 4) { $badgeColor = 'bg-primary'; $anioLabel = '2do Año'; }
                                    elseif($idSem >= 5 && $idSem <= 6) { $badgeColor = 'bg-warning text-dark'; $anioLabel = '3er Año'; }
                                @endphp

                                <span class="badge bg-info text-dark mb-1">
                                    {{ $est->inscripcion->semestre->nombre_semestre ?? 'N/A' }} - 
                                    {{ $est->inscripcion->grupo->nombre_grupo ?? 'S/G' }}
                                </span>
                                <br>
                                <small class="badge {{ $badgeColor }}" style="font-size: 0.75em;">
                                    <i class="bi bi-calendar-check"></i> {{ $anioLabel }}
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm" style="gap: 5px;">
                                    <a href="{{ route('estudiantes.pdf', $est->id_estudiante) }}" class="btn btn-sm btn-outline-danger" title="Generar PDF">
                                        <i class="bi bi-filetype-pdf"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.show', $est->id_estudiante) }}" class="btn btn-sm btn-outline-info" title="Ver Expediente">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('estudiantes.edit', $est->id_estudiante) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    {{-- FORMULARIO DE ELIMINACIÓN CON SWEETALERT --}}
                                    <form action="{{ route('estudiantes.destroy', $est->id_estudiante) }}" method="POST" class="d-inline form-eliminar">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-sweet-delete" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-person-exclamation display-4 d-block mb-3"></i>
                                No se encontraron estudiantes que coincidan con la búsqueda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Paginación --}}
        @if($estudiantes instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer bg-white border-0 py-3 text-center">
            {{ $estudiantes->appends(request()->all())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- SCRIPTS PARA LAS ALERTAS ESTÉTICAS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Alerta para Eliminar Estudiante
    document.querySelectorAll('.btn-sweet-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.form-eliminar');

            Swal.fire({
                title: '¿Deseas eliminar este usuario?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Opcional: Alerta de éxito después de redireccionar
  
</script>
@endsection