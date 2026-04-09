// public/js/tutores.js
function toggleEspecificar() {
    var select = document.getElementById('parentescoSelect');
    var contenedor = document.getElementById('contenedorEspecificar');
    var inputOtro = document.getElementById('parentescoOtro');

    if (select && contenedor) {
        if (select.value === 'Otro') {
            contenedor.style.display = 'block';
            if (inputOtro) inputOtro.setAttribute('required', 'required');
        } else {
            contenedor.style.display = 'none';
            if (inputOtro) {
                inputOtro.removeAttribute('required');
                inputOtro.value = '';
            }
        }
    }
}