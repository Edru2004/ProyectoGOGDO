@extends('Index')

@section('contenido_dinamico')
<div id="loader-overlay" style="display: none;">
    <div class="loader-container">
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <h5 id="loader-text" class="mt-3 fw-bold text-dark">Procesando solicitud...</h5>
        <p class="text-muted small">Estamos sincronizando los datos con la plataforma GDO.</p>
    </div>
</div>

<div class="container-fluid py-4 px-4">
    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-header bg-warning text-dark py-3 d-flex justify-content-between align-items-center" style="border-radius: 15px 15px 0 0;">
            <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Docente: {{ $docente->nombre }}</h4>
            
            <button type="button" class="btn btn-danger btn-sm fw-bold shadow-sm" onclick="confirmarBorrado({{ $docente->id_docente }})" style="border-radius: 10px;">
                <i class="bi bi-trash3-fill me-1"></i> ELIMINAR DOCENTE
            </button>
        </div>

        <div class="card-body p-4">
            {{-- Formulario de Actualización --}}
            <form id="form-update-docente" action="{{ route('docentes.update', $docente->id_docente) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Nombre(s)</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $docente->nombre }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Paterno</label>
                        <input type="text" name="apellido_p" class="form-control" value="{{ $docente->apellido_p }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small">Apellido Materno</label>
                        <input type="text" name="apellido_m" class="form-control" value="{{ $docente->apellido_m }}">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">CURP</label>
                        <input type="text" name="curp" class="form-control" value="{{ $docente->curp }}" maxlength="18" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">RFC</label>
                        <input type="text" name="rfc" class="form-control" value="{{ $docente->rfc }}" maxlength="13" required>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Email Institucional</label>
                        <input type="email" name="email" class="form-control" value="{{ $docente->email }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Dejar vacío si no cambia">
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Grado de Estudios</label>
                        <input type="text" name="estudios" class="form-control" value="{{ $docente->estudios }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Cédula Profesional</label>
                        <input type="text" name="num_cedula_prof" class="form-control" value="{{ $docente->num_cedula_prof }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary px-4" style="border-radius: 10px;">Cancelar</a>
                    <button type="button" id="btn-update" class="btn btn-warning px-5 shadow-sm fw-bold" style="border-radius: 10px;">Actualizar Información</button>
                </div>
            </form>

            {{-- Formulario Invisible para Borrado --}}
            <form id="form-delete-docente" action="{{ route('docentes.destroy', $docente->id_docente) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<style>
/* Estilos para el Overlay de Carga */
#loader-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(255, 255, 255, 0.9);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.loader-container {
    text-align: center;
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}
.form-control { border-radius: 10px; }
</style>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Lógica para ACTUALIZAR
    document.getElementById('btn-update').addEventListener('click', function() {
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la información del docente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loader-text').innerText = 'Actualizando datos...';
                document.getElementById('loader-overlay').style.display = 'flex';
                document.getElementById('form-update-docente').submit();
            }
        });
    });

    // 2. Lógica para BORRAR
    function confirmarBorrado(id) {
        Swal.fire({
            title: '¿Estás completamente seguro?',
            text: "Esta acción eliminará al docente de forma permanente y no se puede deshacer.",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'SÍ, ELIMINAR AHORA',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loader-text').innerText = 'Eliminando registro...';
                document.getElementById('loader-overlay').style.display = 'flex';
                document.getElementById('form-delete-docente').submit();
            }
        });
    }
</script>
@endsection