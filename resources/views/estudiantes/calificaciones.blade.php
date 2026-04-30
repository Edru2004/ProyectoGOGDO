@extends('estudiantes.dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="card shadow-sm border-0 p-4 mt-5">
        <h2 class="text-success fw-bold mb-4">Boleta de Calificaciones</h2>
        
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 40%;">Materia / Maestro</th>
                    <th class="text-center">Parcial 1 (N1)</th>
                    <th class="text-center">Parcial 2 (N2)</th>
                    <th class="text-center">Parcial 3 (N3)</th>
                    <th class="text-center">Promedio</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calificaciones as $cal)
                <tr>
                    <td>
                        <div class="fw-bold text-success">
                            {{-- Muestra el nombre de la materia --}}
                            {{ $cal->asignacion->materia->nombre_materia ?? 'Materia no vinculada' }}
                        </div>
                        <div class="text-muted small">
                            {{-- Muestra el nombre del docente --}}
                            Prof. {{ $cal->asignacion->docente->nombre ?? 'Sin docente' }} 
                            {{ $cal->asignacion->docente->apellido_p ?? '' }}
                        </div>
                    </td>
                    <td class="text-center">{{ number_format($cal->p1_n1 ?? 0, 1) }}</td>
                    <td class="text-center">{{ number_format($cal->p1_n2 ?? 0, 1) }}</td>
                    <td class="text-center">{{ number_format($cal->p1_n3 ?? 0, 1) }}</td>
                    <td class="text-center">
                        @php
                            $promedio = (($cal->p1_n1 ?? 0) + ($cal->p1_n2 ?? 0) + ($cal->p1_n3 ?? 0)) / 3;
                        @endphp
                        <span class="badge {{ $promedio >= 6 ? 'bg-primary' : 'bg-danger' }}">
                            {{ number_format($promedio, 1) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No hay registros con ID de asignación válido.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection