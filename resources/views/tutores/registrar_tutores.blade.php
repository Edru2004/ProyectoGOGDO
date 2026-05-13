@extends('Index')

@section('contenido_dinamico')
<!-- Overlay de Carga -->
<div id="loader-overlay" style="display: none;">
    <div class="loader-container">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <h5 class="mt-3 fw-bold text-dark">Guardando datos del tutor...</h5>
    </div>
</div>

<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0 fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Tutor</h4>
        </div>
        
        <div class="card-body p-4">
            <form id="formTutor" action="{{ route('tutores.store') }}" method="POST">
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

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold small">CURP</label>
                        <input type="text" name="curp" class="form-control" 
                               value="{{ old('curp') }}" 
                               maxlength="18" 
                               style="text-transform: uppercase;" 
                               placeholder="18 caracteres" required>
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
                        <input type="text" name="municipio" class="form-control" value="{{ old('municipio') }}" placeholder="Ej. Texmelucan, Puebla">
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

<style>
/* Estilos para la animación de carga */
#loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.85); /* Fondo blanco semitransparente */
    z-index: 9999; /* Por encima de todo */
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

/* Animación de entrada suave */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

#loader-overlay {
    animation: fadeIn 0.3s ease-in-out;
}
</style>

<script>
// Manejar el envío del formulario para mostrar el loader
document.getElementById('formTutor').addEventListener('submit', function() {
    document.getElementById('loader-overlay').style.display = 'flex';
});

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