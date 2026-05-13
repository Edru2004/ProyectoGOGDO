@extends('Index')

@section('contenido_dinamico')
<!-- Google Fonts para las opciones de personalización -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Playfair+Display:wght@400;700&family=Roboto+Mono&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<div class="container mt-5 pb-5" id="main-config-container">
    <div class="row">
        <!-- Columna Izquierda: Perfil y Navegación Rápida -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 8px; border-top: 5px solid #2c3e50 !important;">
                <div class="card-body text-center p-4">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ asset('img/perfiles/' . ($admin->foto ?? 'default-avatar.png')) }}" 
                             class="rounded-circle border" 
                             style="width: 130px; height: 130px; object-fit: cover; border: 4px solid #f8f9fa !important;">
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $admin->name }}</h5>
                    <p class="text-muted small text-uppercase" style="letter-spacing: 1px;">Administrador de Sistema</p>
                    <hr class="my-4">
                    <div class="list-group list-group-flush text-start">
                        <a href="#" class="list-group-item list-group-item-action border-0 small"><i class="bi bi-person me-2"></i> Datos Personales</a>
                        <a href="#" class="list-group-item list-group-item-action border-0 small"><i class="bi bi-palette me-2"></i> Apariencia</a>
                        <a href="#" class="list-group-item list-group-item-action border-0 small"><i class="bi bi-shield-check me-2"></i> Seguridad</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Configuraciones -->
        <div class="col-md-8">
            
            <!-- SECCIÓN 1: APARIENCIA (NUEVA OPCIÓN DE FUENTES) -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-palette me-2 text-secondary"></i>Personalización Visual</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Estilo de Fuente del Sistema</label>
                        <select class="form-select border-0 bg-light" id="fontSelector" onchange="changeSystemFont(this.value)" style="height: 50px;">
                            <option value="'Inter', sans-serif">Estándar Profesional (Inter)</option>
                            <option value="'Playfair Display', serif">Elegante / Editorial (Playfair)</option>
                            <option value="'Montserrat', sans-serif">Moderno / Corporativo (Montserrat)</option>
                            <option value="'Roboto Mono', monospace">Técnico / Minimalista (Roboto Mono)</option>
                        </select>
                        <div class="form-text mt-2 italic">Selecciona una tipografía para ajustar la lectura del panel de GDO.</div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: EDITAR PERFIL -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 8px;">
                <div class="card-header bg-white py-3 border-bottom text-dark">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2 text-secondary"></i>Información del Perfil</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('configuracion.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">NOMBRE COMPLETO</label>
                                <input type="text" name="name" class="form-control bg-light border-0" value="{{ $admin->name }}" style="height: 45px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">CORREO ELECTRÓNICO</label>
                                <input type="email" class="form-control bg-light border-0" value="{{ $admin->email }}" disabled style="height: 45px;">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">CAMBIAR FOTOGRAFÍA</label>
                            <input type="file" name="foto" class="form-control form-control-sm">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-dark px-4 fw-bold shadow-sm" style="background: #2c3e50; border: none;">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SECCIÓN 3: SEGURIDAD -->
            <div class="card shadow-sm border-0" style="border-radius: 8px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-lock me-2 text-secondary"></i>Seguridad y Acceso</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('configuracion.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">CONTRASEÑA ACTUAL</label>
                            <input type="password" name="current_password" class="form-control bg-light border-0" style="height: 45px;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">NUEVA CONTRASEÑA</label>
                                <input type="password" name="new_password" class="form-control bg-light border-0" style="height: 45px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" name="new_password_confirmation" class="form-control bg-light border-0" style="height: 45px;">
                            </div>
                        </div>

                        <div class="text-end mt-2">
                            <button type="submit" class="btn btn-outline-danger px-4 fw-bold">
                                Actualizar Credenciales
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    /**
     * Función para cambiar la fuente dinámicamente
     * Esto aplica el cambio a todo el cuerpo del documento
     */
    function changeSystemFont(fontFamily) {
        document.body.style.fontFamily = fontFamily;
        // Opcional: Guardar en localStorage para que persista al recargar (Front-end)
        localStorage.setItem('gdo_preferred_font', fontFamily);
    }

    // Cargar preferencia guardada al iniciar
    document.addEventListener('DOMContentLoaded', () => {
        const savedFont = localStorage.getItem('gdo_preferred_font');
        if (savedFont) {
            document.body.style.fontFamily = savedFont;
            document.getElementById('fontSelector').value = savedFont;
        }
    });
</script>

<style>
    /* Estilos para el toque formal */
    body {
        background-color: #f4f7f6;
        transition: font-family 0.3s ease;
    }
    
    .card-header {
        background-color: transparent !important;
    }

    .form-control:focus {
        background-color: #fff !important;
        box-shadow: none;
        border: 1px solid #2c3e50 !important;
    }

    .list-group-item-action:hover {
        background-color: #f8f9fa;
        color: #2c3e50;
        font-weight: bold;
    }

    /* Animación suave para las tarjetas */
    .card {
        transition: transform 0.2s ease;
    }
</style>
@endsection