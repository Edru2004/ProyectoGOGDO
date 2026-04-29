@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    
    <div class="mb-4">
        <a href="{{ route('docentes.index') }}" class="btn btn-secondary shadow-sm px-4">
            <i class="bi bi-arrow-left-circle"></i> Regresar al Listado de Docentes
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-person-circle text-success" style="font-size: 5rem;"></i>
                </div>
                <h4 class="fw-bold mb-0">{{ $docente->nombre }} {{ $docente->apellido_p }}</h4>
                <p class="text-muted small">Panel de Docente - GDO</p>
                <hr>
                <div class="text-start">
                    <p class="mb-1 small"><strong>CURP:</strong> {{ $docente->curp }}</p>
                    <p class="mb-1 small"><strong>RFC:</strong> {{ $docente->rfc }}</p>
                    <p class="mb-1 small"><strong>Email:</strong> {{ $docente->email }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="text-success mb-0 fw-bold">
                        <i class="bi bi-calendar-check"></i> Carga Académica Actual
                    </h5>
                    <a href="{{ route('docentes.descargarHorario', $docente->id_docente) }}" class="btn btn-danger btn-sm">
            <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
        </a>
                    <a href="{{ route('docentes.crearHorario', $docente->id_docente) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-plus-lg"></i> Agregar Clase
                    </a>
                </div>
                <div class="card-body">
                   <table class="table table-hover">
    <thead class="table-light">
        <tr>
            <th>Materia</th>
            <th>Semestre</th>
            <th>Grupo</th>
            <th>Día</th>
            <th>Horario</th>
            <th>Salón</th>
        </tr>
    </thead>
    <tbody>
        @foreach($asignaciones as $a)
        <tr>
            {{-- Materia --}}
            <td class="fw-bold text-primary">{{ $a->materia->nombre_materia }}</td>
            
            {{-- Semestre (Obtenido a través de la relación con el Grupo) --}}
<td>{{ $a->grupo->semestre->nombre_semestre ?? 'N/A' }}</td>     
            {{-- Grupo --}}
            <td>{{ $a->grupo->nombre_grupo }}</td>
            
            {{-- Día (Asegúrate de usar 'dia_semana' como en tu modelo) --}}
            <td>{{ $a->dia_semana }}</td>
            
            {{-- Horario --}}
            <td>{{ $a->hora_inicio }} - {{ $a->hora_fin }}</td>
            
            {{-- Salón --}}
            <td>
                <span class="badge bg-info text-dark">
                    <i class="bi bi-geo-alt"></i> {{ $a->aula }}
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection