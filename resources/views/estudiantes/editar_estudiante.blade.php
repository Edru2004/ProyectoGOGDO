@extends('Index')

@section('contenido_dinamico')
<!-- Overlay de Carga -->
<div id="loader-overlay" style="display: none;">
    <div class="loader-container">
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <h5 class="mt-3 fw-bold text-dark">Actualizando datos...</h5>
        <p class="text-muted small">Estamos guardando los cambios del estudiante.</p>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Datos: {{ $estudiante->nombre }}</h4>
        </div>

        <div class="card-body p-4">
            <form id="form-update-estudiante" action="{{ route('estudiantes.update', $estudiante->id_estudiante) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $estudiante->nombre }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" value="{{ $estudiante->apellido_p }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" value="{{ $estudiante->apellido_m }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">CURP</label>
                        <input type="text" name="curp" class="form-control" value="{{ $estudiante->curp }}" maxlength="18">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email Institucional</label>
                        <input type="email" name="email" class="form-control" value="{{ $estudiante->email }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Sexo</label>
                        <select name="sexo" class="form-select">
                            <option value="Mujer" {{ $estudiante->sexo == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                            <option value="Hombre" {{ $estudiante->sexo == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Otro" {{ $estudiante->sexo == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nac" class="form-control" value="{{ $estudiante->fecha_nac }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono de Contacto</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $estudiante->telefono }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Municipio y Estado</label>
                        <input type="text" name="municipio" class="form-control" value="{{ $estudiante->municipio }}" placeholder="Ej. San Martín Texmelucan, Puebla">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Localidad / Colonia</label>
                        <input type="text" name="localidad" class="form-control" value="{{ $estudiante->localidad }}" placeholder="Ej. El Moral">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Calle</label>
                        <input type="text" name="calle" class="form-control" value="{{ $estudiante->calle }}" placeholder="Ej. Berrocalco">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">Número</label>
                        <input type="text" name="numero" class="form-control" value="{{ $estudiante->numero }}" placeholder="Ext/Int">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold text-primary">Tutor Responsable Actual</label>
                        <select name="id_tutor" class="form-select" required>
                            @foreach($tutores as $tutor)
                            <option value="{{ $tutor->id_tutor }}" {{ $estudiante->id_tutor == $tutor->id_tutor ? 'selected' : '' }}>
                                {{ $tutor->nombre }} {{ $tutor->apellido_p }} - ({{ $tutor->parentesco }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Semestre</label>
                        <select name="id_semestre" class="form-select" required>
                            <option value="">Seleccione un semestre</option>
                            @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id_semestre }}"
                                {{ (optional($estudiante->inscripcion)->id_semestre == $semestre->id_semestre) ? 'selected' : '' }}>
                                {{ $semestre->nombre_semestre }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Grupo</label>
                        <select name="id_grupo" class="form-select" required>
                            <option value="">Seleccione un grupo</option>
                            @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id_grupo }}"
                                {{ (optional($estudiante->inscripcion)->id_grupo == $grupo->id_grupo) ? 'selected' : '' }}>
                                {{ $grupo->nombre_grupo }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-light border px-4 me-2">Regresar</a>
                    <button type="button" id="btn-update" class="btn btn-warning px-5 shadow-sm fw-bold">Actualizar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Estilos para el Overlay de Carga */
#loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.85);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loader-container {
    text-align: center;
    background: white;
    padding: 2rem;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>

{{-- Scripts para SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById('btn-update').addEventListener('click', function() {
        Swal.fire({
            title: '¿Deseas guardar los cambios?',
            text: "Se actualizará la información del estudiante.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // 1. Mostrar el loader inmediatamente tras la confirmación
                document.getElementById('loader-overlay').style.display = 'flex';
                
                // 2. Enviar el formulario
                document.getElementById('form-update-estudiante').submit();
            }
        });
    });
</script>
@endsection