@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    <div class="row">
        <!-- Columna de la Foto y Nombre (Sidebar de Configuración) -->
        <div class="col-md-4 text-center">
            <div class="card shadow border-0 p-4 mb-4" style="border-radius: 15px;">
                <div class="mb-3">
                    <img src="{{ asset('img/perfiles/' . ($admin->foto ?? 'default-avatar.png')) }}" 
                         class="rounded-circle img-thumbnail" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                <h5 class="fw-bold">{{ $admin->name }}</h5>
                <p class="text-muted small">Administrador del Sistema</p>
            </div>
        </div>

        <!-- Columna de Formularios -->
        <div class="col-md-8">
            
            <!-- TARJETA 1: EDITAR PERFIL -->
            <div class="card shadow border-0 mb-4" style="border-radius: 15px;">
                <div class="card-header bg-primary text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Editar Perfil</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('configuracion.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="{{ $admin->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Correo Electrónico</label>
                            <input type="email" class="form-control" value="{{ $admin->email }}" disabled>
                            <div class="form-text">El correo no es editable por seguridad.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto de Perfil</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm">
                                <i class="bi bi-save2 me-2"></i> Actualizar Información
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- TARJETA 2: SEGURIDAD (FUERA DEL OTRO FORM) -->
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-danger text-white py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-shield-lock me-2"></i>Seguridad de la Cuenta</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('configuracion.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contraseña Actual</label>
                            <input type="password" name="current_password" class="form-control" required>
                            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Confirmar Nueva Contraseña</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger fw-bold py-2 shadow-sm">
                                <i class="bi bi-key me-2"></i>Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection