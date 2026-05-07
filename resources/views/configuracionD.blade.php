@extends('docentes.inicio_docentes') {{-- Ajusta a tu layout de docente --}}

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 text-center p-4" style="border-radius: 20px; background: white;">
                <div class="position-relative d-inline-block mx-auto">
                    <img src="{{ asset('img/docentes/' . ($docente->foto ?? 'default-docente.png')) }}" 
                         class="rounded-circle img-thumbnail shadow-sm" 
                         style="width: 160px; height: 160px; object-fit: cover; border: 4px solid #f8f9fa;">
                    <div class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 20px; height: 20px;"></div>
                </div>
                <h4 class="mt-3 fw-bold text-dark">{{ $docente->nombre }} {{ $docente->apellido_p }}</h4>
                <p class="text-muted mb-3"><i class="bi bi-person-badge me-2"></i>ID Docente: {{ $docente->id_docente }}</p>
                <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Panel Académico</div>
            </div>
        </div>

        <div class="col-lg-8">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 12px;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Actualizar Foto --}}
            <div class="card shadow border-0 mb-4" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-camera-fill me-2"></i>Actualizar Foto de Perfil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('docente.configuracion.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Selecciona una imagen (JPG, PNG, max 2MB)</label>
                            <input type="file" name="foto" class="form-control form-control-lg shadow-sm" style="border-radius: 10px; font-size: 0.9rem;" required>
                        </div>
                        <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="border-radius: 10px; background-color: #5d9b44; border: none;">
                            Guardar Nueva Foto
                        </button>
                    </form>
                </div>
            </div>

            {{-- Seguridad --}}
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-shield-lock-fill me-2"></i>Seguridad de la Cuenta</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('docente.configuracion.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-muted small fw-bold">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control shadow-sm" placeholder="••••••••" required style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold">Nueva Contraseña</label>
                                <input type="password" name="new_password" class="form-control shadow-sm" placeholder="Mínimo 8 caracteres" required style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small fw-bold">Confirmar Nueva Contraseña</label>
                                <input type="password" name="new_password_confirmation" class="form-control shadow-sm" placeholder="Repite la contraseña" required style="border-radius: 10px;">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark px-4 py-2 fw-bold" style="border-radius: 10px;">
                            Actualizar Contraseña
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection