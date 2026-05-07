@extends('estudiantes.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 p-4 mt-5">
        
        <div class="text-center mb-4">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" style="height: 60px;" class="me-3">
                <div>
                    <h4 class="fw-bold mb-0" style="color: #5d9b44;">BACHILLERATO GENERAL OFOCIAL GUSTAVO DÍAZ ORDAZ</h4>
                    <p class="small mb-0 fw-bold text-secondary">SISTEMA DE CONTROL ESTUDIANTIL</p>
                    <p class="small mb-0 text-muted">BOLETA ACADÉMICA DEL ESTUDIANTE</p>
                </div>
            </div>
            <hr style="border: 1px solid #5d9b44; opacity: 1;">
        </div>

        <div class="row mb-3 px-2">
            <div class="col-12">
                <p class="mb-1"><strong>ESTUDIANTE:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido_p }}</p>
                <p class="mb-0"><strong>MATRÍCULA:</strong> {{ $estudiante->matricula }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead style="background-color: #5d9b44; color: white;">
                    <tr class="text-center text-uppercase" style="font-size: 0.85rem;">
                        <th style="width: 35%;">Materia</th>
                        <th style="width: 15%;">Semestre</th>
                        <th style="width: 10%;">Grupo</th>
                        <th style="width: 10%;">P1</th>
                        <th style="width: 10%;">P2</th>
                        <th style="width: 10%;">P3</th>
                        <th style="width: 10%;">Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calificaciones as $cal)
                        @php 
                            $promedio = (($cal->p1_n1 ?? 0) + ($cal->p1_n2 ?? 0) + ($cal->p1_n3 ?? 0)) / 3;
                        @endphp
                        <tr class="text-center" style="font-size: 0.9rem;">
                            <td class="text-start fw-bold ps-3">
                                {{ $cal->asignacion->materia->nombre_materia ?? 'Materia no vinculada' }}
                            </td>
                            <td class="text-muted">{{ $estudiante->inscripcion->semestre->nombre_semestre ?? 'N/A' }}</td>
                            <td class="text-muted">{{ $estudiante->inscripcion->grupo->nombre_grupo ?? 'N/A' }}</td>
                            <td>{{ number_format($cal->p1_n1 ?? 0, 1) }}</td>
                            <td>{{ number_format($cal->p1_n2 ?? 0, 1) }}</td>
                            <td>{{ number_format($cal->p1_n3 ?? 0, 1) }}</td>
                            <td class="fw-bold {{ $promedio >= 6 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($promedio, 1) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No se encontraron registros de calificaciones.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <p class="small text-muted mb-0"><i>* Esta boleta es de carácter informativo.</i></p>
            
            {{-- EL BOTÓN AHORA ESTÁ AQUÍ ABAJO --}}
            <a href="{{ route('estudiante.descargar.boleta') }}" class="btn btn-danger btn-sm shadow-sm px-4">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i> Descargar Boleta PDF
            </a>
        </div>
    </div>
</div>

<style>
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6 !important;
    }
    .table thead th {
        vertical-align: middle;
        border-bottom: 0;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
@endsection