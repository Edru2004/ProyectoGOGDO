@extends('estudiantes.dashboard')

@section('content')
<div class="container-fluid px-4">
    {{-- Encabezado de la Sección --}}
    <div class="row mt-5 mb-4">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-success mb-0" style="font-family: 'Poppins', sans-serif;">
                Mis Calificaciones
            </h1>
            <p class="lead text-muted">Consulta tu rendimiento académico por parcial.</p>
            <hr class="mx-auto" style="width: 15%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">
        </div>
    </div>

    {{-- Tabla de Calificaciones --}}
    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-success">
                <i class="bi bi-list-ol me-2"></i>Boleta de Calificaciones
            </h4>
            <span class="badge bg-success">Ciclo Escolar 2025 - 2026</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="width: 40%;">Materia</th>
                        <th>Parcial 1</th>
                        <th>Parcial 2</th>
                        <th>Parcial 3</th>
                        <th class="table-success text-success fw-bold">Promedio Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($calificaciones as $calif)
                    <tr>
                        <td class="text-start fw-bold text-uppercase">{{ $calif->materia->nombre }}</td>
                        <td>{{ $calif->p1_n1 ?? 'N/A' }}</td>
                        <td>{{ $calif->p1_n2 ?? 'N/A' }}</td>
                        <td>{{ $calif->p1_n3 ?? 'N/A' }}</td>
                        <td class="fw-bold {{ ($calif->p1_n1 + $calif->p1_n2 + $calif->p1_n3) / 3 >= 6 ? 'text-success' : 'text-danger' }}">
                            {{ number_format(($calif->p1_n1 + $calif->p1_n2 + $calif->p1_n3) / 3, 1) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted p-5">
                            <i class="bi bi-info-circle fa-2x mb-3 text-success"></i><br>
                            Aún no tienes calificaciones capturadas. Consulta con tu docente.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection