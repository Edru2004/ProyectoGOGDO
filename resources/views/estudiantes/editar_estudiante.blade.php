@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Datos: {{ $estudiante->nombre }}</h4>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('estudiantes.update', $estudiante->id_estudiante) }}" method="POST">
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

                <div class="text-end mt-4">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-light border px-4 me-2">Regresar</a>
                    <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold">Actualizar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection