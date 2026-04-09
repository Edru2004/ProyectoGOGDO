@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-4" style="color: #2c3e50;">Registrar Nuevo Estudiante</h2>

            <form action="{{ route('estudiantes.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Dulce Rubi" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" placeholder="Ej. Barragán" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" placeholder="Ej. Alonso">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">CURP</label>
                        <input type="text" name="curp" class="form-control" placeholder="18 caracteres" maxlength="18" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Email Personal/Acceso</label>
                        <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Contraseña para el Estudiante</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Sexo</label>
                        <select name="sexo" class="form-select">
                            <option value="Mujer">Mujer</option>
                            <option value="Hombre">Hombre</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nac" class="form-control" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Teléfono de Contacto</label>
                        <input type="text" name="telefono" class="form-control" placeholder="10 dígitos">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Municipio y Estado</label>
                        <input type="text" name="municipio" class="form-control" placeholder="Ej. San Martín Texmelucan, Puebla" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Localidad / Colonia</label>
                        <input type="text" name="localidad" class="form-control" placeholder="Ej. El Moral" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Calle</label>
                        <input type="text" name="calle" class="form-control" placeholder="Ej. Berrocalco">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold small">Número</label>
                        <input type="text" name="numero" class="form-control" placeholder="Ext/Int">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-primary small">Asignar Tutor Responsable</label>
                    <select name="id_tutor" class="form-select" required>
                        <option value="" selected disabled>Selecciona un tutor...</option>
                        @foreach($tutores as $tutor)
                            <option value="{{ $tutor->id_tutor }}">{{ $tutor->nombre }} {{ $tutor->apellido_p }}</option>
                        @endforeach
                    </select>
                </div>

                <hr class="my-4">

                <h5 class="text-success fw-bold mb-3"><i class="bi bi-mortarboard"></i> Inscripción Académica</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Semestre de Ingreso</label>
                        <select name="id_semestre" class="form-select" required>
                            @foreach($semestres as $s)
                                <option value="{{ $s->id_semestre }}">{{ $s->nombre_semestre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Grupo Asignado</label>
                        <select name="id_grupo" class="form-select" required>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id_grupo }}">{{ $g->nombre_grupo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-success px-4 shadow-sm fw-bold">Guardar Estudiante</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection