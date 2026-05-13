@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid px-4 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-success">Gestión de Usuarios</h1>
        <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
            <i class="bi bi-person-plus-fill me-2"></i>Nuevo Administrador
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Rol Actual</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($user->name ?? $user->nombre, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold">{{ $user->name ?? $user->nombre }}</span>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ ($user->rol ?? '') == 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ ucfirst($user->rol ?? 'Usuario') }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if(($user->rol ?? '') !== 'admin')
                                    <form action="{{ route('admin.promover', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary" onclick="return confirm('¿Promover a administrador?')">
                                            <i class="bi bi-shield-lock-fill"></i> Hacer Admin
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light text-muted" disabled>Administrador</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal de Registro --}}
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Registrar Administrador GDO</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success px-4">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection