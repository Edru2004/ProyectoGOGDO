@extends('index') {{-- Asegúrate de que esté en minúsculas --}}

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    {{-- Encabezado del Panel --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-success mb-0" style="font-weight: bold;">
                <i class="bi bi-person-badge-fill me-2"></i> Listado de Docentes
            </h3>
            <p class="text-muted small">Panel Administrativo - GDO</p>
        </div>

        <a href="{{ route('docentes.create') }}" class="btn btn-success shadow-sm px-4 fw-bold">
            <i class="bi bi-person-plus-fill me-1"></i> Registrar Nuevo Docente
        </a>
    </div>

    {{-- Buscador Estilizado (Igual al de Tutores) --}}
   <div class="card shadow border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('tutores.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="buscar" class="form-control border-start-0 ps-0" 
                               placeholder="Buscar por nombre, apellido o CURP..." 
                               value="{{ request('buscar') }}">
                    </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="bi bi-filter me-1"></i> buscar
                </button>
            </div>
        </form>
    </div>

    {{-- Contenedor de la Tabla con Estilo Moderno --}}
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
                    <th style="color: #444; font-weight: 600;">NOMBRE COMPLETO</th>
                    <th style="color: #444; font-weight: 600;">CURP / RFC</th>
                    <th style="color: #444; font-weight: 600;">ESTUDIOS / CÉDULA</th>
                    <th class="text-center" style="color: #444; font-weight: 600;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $doc)
                <tr>
                    <td class="ps-4">
                                <input class="form-check-input doc-checkbox" type="checkbox" value="{{ $doc->id_docente }}" style="cursor: pointer; border: 1.5px solid #6c993e;">
                    <td class="ps-4 text-muted">{{ $doc->id_docente }}</td>
                    <td>
                        <span class="fw-bold text-dark">{{ $doc->nombre }} {{ $doc->apellido_p }} {{ $doc->apellido_m }}</span>
                        <div style="color: #7f8c8d; font-size: 0.75em;">{{ $doc->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight: bold; font-size: 0.85em; color: #2c3e50;">{{ $doc->curp }}</div>
                        <div class="badge bg-light text-dark border" style="font-size: 0.7em;">RFC: {{ $doc->rfc }}</div>
                    </td>
                    <td>
                        <span class="badge bg-info text-dark mb-1" style="border-radius: 6px; padding: 5px 10px;">
                            {{ $doc->estudios }}
                        </span>
                        <br>
                        <small class="text-muted" style="font-size: 0.8em;">
                            <i class="bi bi-card-checklist"></i> Cédula: {{ $doc->num_cedula_prof }}
                        </small>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            {{-- Carga Académica --}}
                            <a href="{{ route('docentes.crearHorario', $doc->id_docente) }}" 
                               class="btn-op text-success" title="Gestionar Carga">
                                <i class="bi bi-calendar-plus fs-5"></i>
                            </a>

                            {{-- Ver --}}
                            <a href="{{ route('docentes.show', $doc->id_docente) }}" 
                               class="btn-op text-info" title="Ver Detalles">
                                <i class="bi bi-eye fs-5"></i>
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('docentes.edit', $doc->id_docente) }}" 
                               class="btn-op text-warning" title="Editar">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>

                            {{-- Eliminar --}}
                            <form action="{{ route('docentes.destroy', $doc->id_docente) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn-op text-danger" style="border:none; background:none;" 
                                        onclick="return confirm('¿Estás seguro de eliminar a este docente?')">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-person-exclamation display-4 d-block mb-3"></i>
                        No se encontraron docentes registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginación (si aplica) --}}
        @if($docentes instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4 px-3">
            {{ $docentes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection