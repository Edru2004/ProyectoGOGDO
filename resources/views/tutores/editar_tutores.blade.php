@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning py-3">
            <h4 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2"></i>Editar Datos: {{ $tutor->nombre }}</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('tutores.update', $tutor->id_tutor) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold small">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $tutor->nombre }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold small">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" value="{{ $tutor->apellido_p }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold small">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" value="{{ $tutor->apellido_m }}">
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Parentesco Actual: <span class="text-primary">{{ $tutor->parentesco }}</span></label>
                        <select name="parentesco" id="parentescoSelect" class="form-select" onchange="toggleEspecificar()">
                            <option value="Padre" {{ $tutor->parentesco == 'Padre' ? 'selected' : '' }}>Padre</option>
                            <option value="Madre" {{ $tutor->parentesco == 'Madre' ? 'selected' : '' }}>Madre</option>
                            <option value="Abuelo/a" {{ $tutor->parentesco == 'Abuelo/a' ? 'selected' : '' }}>Abuelo/a</option>
                            <option value="Otro">Otro (Especificar nuevo)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3" id="contenedorEspecificar" style="display: none;">
                        <label class="form-label fw-bold text-success small">Nuevo Parentesco</label>
                        <input type="text" name="parentesco_otro" id="parentescoOtro" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Teléfono de Contacto</label>
                        <input type="text" name="telefono" class="form-control" value="{{ $tutor->telefono }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Municipio y Estado</label>
                        <input type="text" name="municipio" class="form-control" value="{{ $tutor->municipio }}" placeholder="Ej. San Martín Texmelucan, Puebla">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small">Localidad / Colonia</label>
                        <input type="text" name="localidad" class="form-control" value="{{ $tutor->localidad }}" placeholder="Ej. El Moral">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold small">Calle</label>
                        <input type="text" name="calle" class="form-control" value="{{ $tutor->calle }}" placeholder="Ej. Berrocalco">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold small">Número</label>
                        <input type="text" name="numero" class="form-control" value="{{ $tutor->numero }}" placeholder="Ext/Int">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('tutores.index') }}" class="btn btn-light border px-4">Regresar</a>
                    <button type="submit" class="btn btn-warning px-5 fw-bold shadow-sm">Actualizar Información</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleEspecificar() {
    var select = document.getElementById('parentescoSelect');
    var contenedor = document.getElementById('contenedorEspecificar');
    if (select.value === 'Otro') {
        contenedor.style.display = 'block';
    } else {
        contenedor.style.display = 'none';
    }
}
</script>
@endsection