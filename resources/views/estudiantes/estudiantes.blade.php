@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Lista de Estudiantes</h2>
   <a href="{{ route('estudiantes.pdf_general') }}" class="btn btn-danger shadow-sm">
    <i class="bi bi-file-earmark-pdf-fill"></i> Descargar Reporte General (PDF)
</a>
    </div>
        
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-3 align-items-center">
            <div class="btn-group shadow-sm">
                <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary btn-sm">Todos</a>
                <a href="{{ route('estudiantes.index', ['grado' => 1]) }}" class="btn btn-outline-success btn-sm">1er Año</a>
                <a href="{{ route('estudiantes.index', ['grado' => 2]) }}" class="btn btn-outline-primary btn-sm">2do Año</a>
                <a href="{{ route('estudiantes.index', ['grado' => 3]) }}" class="btn btn-outline-warning btn-sm">3er Año</a>
            </div>

            <a href="{{ route('estudiantes.create') }}" class="btn btn-success shadow-sm px-4 fw-bold">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Alumno
            </a>
        </div>
    </div>

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
                        <i class="bi bi-filter me-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                             <th class="ps-4" style="width: 50px;">
                                <input class="form-check-input" type="checkbox" id="selectAllDocentes" style="cursor: pointer; border: 1.5px solid #6c993e;">
                            </th>
                            <th class="ps-4" style="color: #444; font-weight: 600;">ID</th>
                            <th style="color: #444; font-weight: 600;">Nombre Completo</th>
                            <th style="color: #444; font-weight: 600;">CURP / Email</th>
                            <th style="color: #444; font-weight: 600;">Grado y Grupo</th>
                            <th class="text-center" style="color: #444; font-weight: 600;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       @forelse($estudiantes as $est) {{-- Aquí definiste que se llama $est --}}
<tr>
    <td class="ps-4">
        {{-- Cámbialo aquí para que use $est --}}
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
                                    <a href="{{ route('estudiantes.pdf', $est->id_estudiante) }}" 
                                       class="btn btn-sm btn-outline-danger" 
                                       title="Generar PDF">
                                       <i class="bi bi-filetype-pdf"></i>
                                    </a>

                                    <a href="{{ route('estudiantes.show', $est->id_estudiante) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       title="Ver Expediente">
                                       <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('estudiantes.edit', $est->id_estudiante) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Editar">
                                       <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('estudiantes.destroy', $est->id_estudiante) }}" method="POST" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-person-exclamation display-4 d-block mb-3"></i>
                                No se encontraron estudiantes que coincidan con la búsqueda.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($estudiantes instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="card-footer bg-white border-0 py-3 text-center">
            {{ $estudiantes->appends(['buscar' => request('buscar'), 'grado' => request('grado')])->links() }}
        </div>
        @endif
    </div>
</div>
@endsection