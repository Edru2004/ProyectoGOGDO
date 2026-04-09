@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Tutor</h4>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('tutores.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" placeholder="Ej. Pérez" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" placeholder="Ej. García">
                    </div>
                </div>

                <div class="row align-items-end">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Parentesco</label>
                        <select name="parentesco" id="parentescoSelect" class="form-select" required onchange="toggleEspecificar()">
                            <option value="">-- Seleccione --</option>
                            <option value="Padre">Padre</option>
                            <option value="Madre">Madre</option>
                            <option value="Abuelo/a">Abuelo/a</option>
                            <option value="Tutor Legal">Tutor Legal</option>
                            <option value="Otro">Otro (Especificar)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-6 mb-3" id="contenedorEspecificar" style="display: none;">
                        <label class="form-label fw-bold text-success">¿Cuál es el parentesco?</label>
                        <input type="text" name="parentesco_otro" id="parentescoOtro" class="form-control" placeholder="Ej. Tío, Hermano, Padrino...">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Teléfono de Contacto</label>
                        <input type="text" name="no_telefono" class="form-control" placeholder="10 dígitos" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Municipio y Estado</label>
                        <input type="text" name="municipio" class="form-control" placeholder="Ej. San Martín Texmelucan, Puebla" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Localidad / Colonia</label>
                        <input type="text" name="localidad" class="form-control" placeholder="Ej. El Moral" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Calle</label>
                        <input type="text" name="calle" class="form-control" placeholder="Ej. Berrocalco" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label fw-bold">Número</label>
                        <input type="text" name="numero" class="form-control" placeholder="Ext/Int" required>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('tutores.index') }}" class="btn btn-light border px-4 me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success px-5 shadow-sm fw-bold">Guardar Tutor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleEspecificar() {
    var select = document.getElementById('parentescoSelect');
    var contenedor = document.getElementById('contenedorEspecificar');
    var inputOtro = document.getElementById('parentescoOtro');

    if (select.value === 'Otro') {
        contenedor.style.setProperty("display", "block", "important");
        inputOtro.setAttribute('required', 'required');
    } else {
        contenedor.style.setProperty("display", "none", "important");
        inputOtro.removeAttribute('required');
        inputOtro.value = ''; 
    }
}
</script>
@endsection