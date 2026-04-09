@extends('Index')

@section('contenido_dinamico')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3" style="background-color: #2c3e50 !important;">
            <h4 class="mb-0 fw-bold"><i class="bi bi-person-badge-fill me-2"></i> Registrar Nuevo Docente</h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('docentes.store') }}" method="POST">
               {{-- Esto te dirá qué campo está fallando --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('tutores.store') }}" method="POST">
    @csrf
    {{-- Para que no se borre lo que el usuario escribió, usa value="{{ old('nombre') }}" --}}
    <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Nombre(s)</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
    </div>
    ...
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" placeholder="Ej. Pérez" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" placeholder="Ej. García">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">CURP</label>
                        <input type="text" name="curp" class="form-control" placeholder="18 caracteres" maxlength="18" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">RFC</label>
                        <input type="text" name="rfc" class="form-control" placeholder="13 caracteres" maxlength="13" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Email Institucional</label>
                        <input type="email" name="email" class="form-control" placeholder="ejemplo@correo.com" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Contraseña de Acceso</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 8 caracteres" required>
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
                        <input type="text" name="calle" class="form-control" placeholder="Ej. Berrocalco" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold small">Número</label>
                        <input type="text" name="numero" class="form-control" placeholder="Ext/Int" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Grado de Estudios</label>
                        <input type="text" name="estudios" class="form-control" placeholder="Ej. Lic. en Matemáticas">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Número de Cédula</label>
                        <input type="text" name="num_cedula_prof" class="form-control" placeholder="Cédula Profesional">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">Guardar Docente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection