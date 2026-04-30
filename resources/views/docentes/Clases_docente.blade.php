@extends('docentes.dashboard_maestro')

@section('content')
<div class="container-fluid">
    <div class="row">
        @forelse($misClases as $clase)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="icon-box" style="background: #e8f5e9; color: #118b2e; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <!-- Se usa el id_semestre de la tabla grupos para evitar el error de 5° vs 6° -->
                            <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center px-3" style="font-size: 0.9rem; border-radius: 8px;">
                                {{ $clase->grupo->id_semestre ?? '?' }}° {{ $clase->grupo->nombre_grupo ?? 'S/G' }}
                            </span>
                        </div>

                        <!-- Nombre real de la materia desde la tabla 'materia' -->
                        <h5 class="fw-bold mb-1 text-dark">
                            {{ $clase->materia->nombre_materia ?? 'Materia no encontrada' }}
                        </h5>
                        <p class="text-muted small mb-4">Bachillerato Gustavo Díaz Ordaz</p>

                        <div class="d-flex align-items-center text-secondary small mb-4">
                            <i class="bi bi-door-open-fill me-2"></i> <strong>Aula:</strong> {{ $clase->aula ?? 'N/A' }}
                        </div>

                        <a href="{{ route('docente.lista', $clase->id_asignacion) }}" class="btn btn-success w-100 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                            <i class="bi bi-pencil-square me-2"></i> Capturar Notas
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                <h4 class="text-muted mt-3">No tienes clases asignadas en este periodo.</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection