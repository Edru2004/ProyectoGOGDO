@extends('estudiantes.dashboard')

@section('content')
<div class="card shadow border-0" style="border-radius: 15px;">
    <div class="card-header bg-white py-3 border-bottom">
        <h5 class="mb-0 fw-bold text-success">
            <i class="fas fa-star me-2"></i>Kardex de Calificaciones
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Materia</th>
                        <th class="text-center">1° Parcial</th>
                        <th class="text-center">2° Parcial</th>
                        <th class="text-center">3° Parcial</th>
                        <th class="text-center">Promedio Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calificaciones as $nota)
                    <tr>
                        <td class="fw-bold text-dark">{{ $nota->materia->nombre ?? 'Materia no asignada' }}</td>
                        <td class="text-center">{{ $nota->parcial1 }}</td>
                        <td class="text-center">{{ $nota->parcial2 }}</td>
                        <td class="text-center">{{ $nota->parcial3 }}</td>
                        <td class="text-center">
                            {{-- Mostramos el promedio generado por la base de datos --}}
                            <span class="badge {{ $nota->promedio_final >= 6 ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                {{ number_format($nota->promedio_final, 2) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            Aún no tienes calificaciones cargadas en el sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection