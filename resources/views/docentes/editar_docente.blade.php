@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Datos: {{ $docente->nombre }}</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('docentes.update', $docente->id_docente) }}" method="POST">
                @csrf @method('PUT')
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $docente->nombre }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" value="{{ $docente->apellido_p }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" value="{{ $docente->apellido_m }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">CURP</label>
                        <input type="text" name="curp" class="form-control" value="{{ $docente->curp }}" maxlength="18">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">RFC</label>
                        <input type="text" name="rfc" class="form-control" value="{{ $docente->rfc }}" maxlength="13">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Email Institucional</label>
                        <input type="email" name="email" class="form-control" value="{{ $docente->email }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono de Contacto</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $docente->telefono }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Municipio y Estado</label>
                        <input type="text" name="municipio" class="form-control" value="{{ $docente->municipio }}" placeholder="Ej. San Martín Texmelucan, Puebla">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Localidad / Colonia</label>
                        <input type="text" name="localidad" class="form-control" value="{{ $docente->localidad }}" placeholder="Ej. El Moral">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Calle</label>
                        <input type="text" name="calle" class="form-control" value="{{ $docente->calle }}" placeholder="Ej. Berrocalco">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">Número</label>
                        <input type="text" name="numero" class="form-control" value="{{ $docente->numero }}" placeholder="Ext/Int">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Grado de Estudios</label>
                        <input type="text" name="estudios" class="form-control" value="{{ $docente->estudios }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Número de Cédula</label>
                        <input type="text" name="num_cedula_prof" class="form-control" value="{{ $docente->num_cedula_prof }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                        <small class="text-muted d-block mt-1">Solo si desea actualizar el acceso.</small>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('docentes.index') }}" class="btn btn-light border px-4 me-2">Regresar</a>
                    <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold">Actualizar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection