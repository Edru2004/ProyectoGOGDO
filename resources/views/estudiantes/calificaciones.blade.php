@extends('estudiantes.dashboard')

@section('content')
<div class="container-fluid px-4">
    {{-- Título de la sección --}}
    <div class="row mt-5 mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-success mb-0" style="font-family: 'Poppins', sans-serif;">
                Mis Calificaciones
            </h1>
            <p class="lead text-muted">Consulta tus notas de N1, N2 y N3 por cada materia.</p>
            <hr class="mx-auto" style="width: 15%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">
        </div>
    </div>

    {{-- Contenedor de la Boleta --}}
    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-success">
                <i class="bi bi-journal-check me-2"></i>Boleta de Calificaciones
            </h4>
            <span class="badge bg-success">Ciclo Escolar 2025 - 2026</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-secondary">
                        <th style="width: 40%;">Materia / Maestro</th>
                        <th class="text-center">Parcial 1 (N1)</th>
                        <th class="text-center">Parcial 2 (N2)</th>
                        <th class="text-center">Parcial 3 (N3)</th>
                        <th class="text-center">Promedio Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calificaciones as $cal)
                    <tr>
                        <td>
                            <div class="fw-bold text-success" style="font-size: 1.1rem;">
                                {{-- Relación para obtener el nombre de la materia --}}
                                {{ $cal->asignacion->materia->nombre_materia ?? 'Materia no encontrada' }}
                            </div>
                            <div class="text-muted small">
                                <i class="bi bi-person-circle me-1"></i>
                                Prof. {{ $cal->asignacion->docente->nombre ?? 'Sin docente' }} 
                                {{ $cal->asignacion->docente->apellido_p ?? '' }}
                            </div>
                        </td>

                        {{-- Mostramos N1 directamente en Parcial 1 --}}
                        <td class="text-center fw-bold">
                            {{ number_format($cal->p1_n1 ?? 0, 1) }}
                        </td>

                        {{-- Mostramos N2 directamente en Parcial 2 --}}
                        <td class="text-center fw-bold">
                            {{ number_format($cal->p1_n2 ?? 0, 1) }}
                        </td>

                        {{-- Mostramos N3 directamente en Parcial 3 --}}
                        <td class="text-center fw-bold">
                            {{ number_format($cal->p1_n3 ?? 0, 1) }}
                        </td>

                        {{-- Cálculo del promedio basado en la suma de las 3 notas --}}
                        <td class="text-center">
                            @php
                                $suma = ($cal->p1_n1 ?? 0) + ($cal->p1_n2 ?? 0) + ($cal->p1_n3 ?? 0);
                                $promedio = $suma / 3;
                            @endphp
                            <span class="badge {{ $promedio >= 6 ? 'bg-primary' : 'bg-danger' }}" style="font-size: 1rem;">
                                {{ number_format($promedio, 1) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <i class="bi bi-exclamation-triangle me-2"></i>No se encontraron calificaciones registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection