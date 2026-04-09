@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold">Expediente del Tutor</h4>
        </div>
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="mb-1 text-muted text-uppercase small fw-bold">Nombre Completo</p>
                    <h5 class="fw-bold">{{ $tutor->nombre }} {{ $tutor->apellido_p }} {{ $tutor->apellido_m }}</h5>
                </div>
                <div class="col-md-3">
                    <p class="mb-1 text-muted text-uppercase small fw-bold">Teléfono</p>
                    <h5>{{ $tutor->no_telefono }}</h5>
                </div>
                <div class="col-md-3">
                    <p class="mb-1 text-muted text-uppercase small fw-bold">Parentesco</p>
                    <span class="badge bg-info text-dark fs-6">{{ $tutor->parentesco }}</span>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-3 text-primary">Estudiantes a su cargo</h5>
            <div class="list-group shadow-sm">
                @forelse($tutor->estudiantes as $alumno)
                <a href="{{ route('estudiantes.show', $alumno->id_estudiante) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-person-check me-2 text-success"></i>
                        {{ $alumno->nombre }} {{ $alumno->apellido_p }}
                    </div>
                    <span class="badge bg-secondary rounded-pill">Ver Perfil</span>
                </a>
                @empty
                <div class="alert alert-light border m-0">Este tutor no tiene alumnos asignados actualmente.</div>
                @endforelse
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('tutores.index') }}" class="btn btn-outline-secondary px-4">Volver al Listado</a>
            </div>
        </div>
    </div>
</div>
@endsection