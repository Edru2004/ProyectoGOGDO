@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    <div class="card shadow border-0 p-4">
        <h3 class="fw-bold text-primary mb-4 border-bottom pb-2">Expediente Completo</h3>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="text-muted d-block">Nombre del Alumno</label>
                <span class="h5">{{ $estudiante->nombre }} {{ $estudiante->apellido_p }} {{ $estudiante->apellido_m }}</span>
            </div>
            <div class="col-md-6 mb-3">
                <label class="text-muted d-block">CURP</label>
                <span class="h5">{{ $estudiante->curp }}</span>
            </div>
            <div class="col-md-12 mt-3">
                <h5 class="text-secondary border-bottom pb-2">Contacto y Dirección</h5>
                <p><strong>Email:</strong> {{ $estudiante->email }} | <strong>Tel:</strong> {{ $estudiante->no_telefono }}</p>
                <p><strong>Dirección:</strong> {{ $estudiante->calle }} #{{ $estudiante->numero }}, Col. {{ $estudiante->colonia }}</p>
            </div>
            <h5 class="text-primary fw-bold mb-3">Información del Tutor</h5>
<div class="row bg-light p-3 rounded shadow-sm">
    <div class="col-md-6">
        <p class="mb-1"><strong>Nombre del Responsable:</strong> 
            {{ $estudiante->tutor->nombre }} {{ $estudiante->tutor->apellido_p }} 
            <span class="badge bg-info text-dark">/ {{ $estudiante->tutor->parentesco }}</span>
        </p>
        <p class="mb-1"><strong>Teléfono:</strong> {{ $estudiante->tutor->no_telefono }}</p>
    </div>
    <div class="col-md-6">
        <p class="mb-1"><strong>Domicilio del Tutor:</strong></p>
        <p class="text-muted">
            {{ $estudiante->tutor->calle }} #{{ $estudiante->tutor->numero }}, 
            Col. {{ $estudiante->tutor->colonia }}, {{ $estudiante->tutor->ciudad }}
        </p>
    </div>
</div>
        </div>
        <div class="mt-4">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary px-4">Cerrar Expediente</a>
        </div>
    </div>
</div>
@endsection