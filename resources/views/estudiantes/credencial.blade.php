@extends('estudiantes.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-4">
            <div class="card shadow-lg" style="border-radius: 20px; border: none; overflow: hidden;">
                <div style="background: #5b9036; color: white; padding: 20px; text-align: center;">
                    <h4 class="mb-0 fw-bold">BACHILLERATO GUSTAVO DÍAZ ORDAZ</h4>
                    <small class="text-uppercase tracking-wider">Credencial Digital del Estudiante</small>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center border-end">
                            <div class="mb-3">
                                <i class="fas fa-user-graduate fa-7x text-secondary bg-light p-4 rounded-circle"></i>
                            </div>
                            <h5 class="fw-bold text-success">{{ $estudiante->nombre }} {{ $estudiante->apellido_p }} {{ $estudiante->apellido_m }}</h5>
                            <span class="badge bg-success px-3">MATRÍCULA: {{ $estudiante->id_estudiante }}</span>
                        </div>

                        <div class="col-md-8 ps-4">
                            <h6 class="text-muted fw-bold border-bottom pb-2">DATOS DEL ALUMNO</h6>
                            <div class="row small mb-3">
                                <div class="col-6"><strong>CURP:</strong><br>{{ $estudiante->curp }}</div>
                                <div class="col-6"><strong>CORREO:</strong><br>{{ $estudiante->email ?? 'No registrado' }}</div>
                            </div>
                            <div class="row small mb-3">
                                <div class="col-6"><strong>TELÉFONO:</strong><br>{{ $estudiante->telefono ?? 'N/A' }}</div>
                                <div class="col-6"><strong>DIRECCIÓN:</strong><br>
                                    {{ $estudiante->calle }} #{{ $estudiante->numero }}, {{ $estudiante->localidad }}
                                </div>
                            </div>

                            <h6 class="text-danger fw-bold border-bottom pb-2 mt-4">
                                <i class="fas fa-exclamation-triangle me-2"></i>DATOS DEL TUTOR (EMERGENCIAS)
                            </h6>
                            <div class="row small">
                                <div class="col-12 mb-2">
                                    <strong>NOMBRE COMPLETO:</strong><br>
                                    {{ $estudiante->tutor->nombre ?? 'N/A' }} {{ $estudiante->tutor->apellido_p ?? '' }} {{ $estudiante->tutor->apellido_m ?? '' }}
                                </div>
                                <div class="col-6">
                                    <strong>TELÉFONO:</strong><br>
                                    {{ $estudiante->tutor->no_telefono ?? 'S/N' }}
                                </div>
                                <div class="col-6">
                                    <strong>DIRECCIÓN:</strong><br>
                                    {{ $estudiante->tutor->calle ?? '' }} #{{ $estudiante->tutor->numero ?? '' }}, {{ $estudiante->tutor->localidad ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-light p-3 text-center border-top">
                    <p class="mb-0 x-small text-muted">Esta credencial es personal e intransferible. Válida para el ciclo escolar vigente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection