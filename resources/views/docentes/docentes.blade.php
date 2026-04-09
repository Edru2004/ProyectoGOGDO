@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    {{-- Encabezado del Panel --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-success mb-0" style="font-weight: bold;">
                <i class="bi bi-person-badge-fill"></i> Listado de Docentes
            </h3>
            <p class="text-muted small">Panel Administrativo - GDO</p>
        </div>

        <a href="{{ route('docentes.create') }}" class="btn btn-success shadow-sm px-4">
            <i class="bi bi-person-plus-fill"></i> Registrar Nuevo Docente
        </a>
    </div>

    {{-- Contenedor de la Tabla --}}
    <div class="table-container shadow-sm p-3 bg-white rounded">
        <table class="table-custom w-100">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE COMPLETO</th>
                    <th>CURP / RFC</th>
                    <th>ESTUDIOS / CÉDULA</th>
                    <th class="text-center">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docentes as $doc)
                <tr>
                    <td class="text-muted">{{ $doc->id_docente }}</td>
                    <td>
                        <span class="fw-bold text-dark">{{ $doc->nombre }} {{ $doc->apellido_p }} {{ $doc->apellido_m }}</span>
                        <div style="color: #7f8c8d; font-size: 0.75em;">{{ $doc->email }}</div>
                    </td>
                    <td>
                        <div style="font-weight: bold; font-size: 0.85em; color: #2c3e50;">{{ $doc->curp }}</div>
                        <div class="badge bg-light text-dark border" style="font-size: 0.7em;">RFC: {{ $doc->rfc }}</div>
                    </td>
                    <td>
                        <span class="badge bg-info text-dark mb-1">
                            {{ $doc->estudios }}
                        </span>
                        <br>
                        <small class="text-muted" style="font-size: 0.8em;">
                            <i class="bi bi-card-checklist"></i> Cédula: {{ $doc->num_cedula_prof }}
                        </small>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            {{-- NUEVO BOTÓN: Gestionar Carga Académica (Horario) --}}
                            <a href="{{ route('docentes.crearHorario', $doc->id_docente) }}" 
                               class="btn-op text-success" 
                               title="Gestionar Carga Académica">
                                <i class="bi bi-calendar-plus fs-5"></i>
                            </a>

                            {{-- Ver Expediente --}}
                            <a href="{{ route('docentes.show', $doc->id_docente) }}" 
                               class="btn-op text-info" 
                               title="Ver Detalles">
                                <i class="bi bi-eye fs-5"></i>
                            </a>

                            {{-- Editar Datos --}}
                            <a href="{{ route('docentes.edit', $doc->id_docente) }}" 
                               class="btn-op text-warning" 
                               title="Editar">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>

                            {{-- Eliminar Docente --}}
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
                @endforeach
            </tbody>
        </table>

        @if($docentes->isEmpty())
            <div class="text-center py-4">
                <p class="text-muted italic">No se encontraron docentes registrados.</p>
            </div>
        @endif
    </div>
</div>
@endsection