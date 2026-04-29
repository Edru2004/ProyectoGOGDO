@extends('Index')

@section('contenido_dinamico')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-success mb-0" style="font-weight: bold;">
                <i class="bi bi-person-heart me-2"></i> Padres y Tutores Registrados
            </h3>
            <p class="text-muted small">Panel Administrativo - GDO</p>
        </div>
        <a href="{{ route('tutores.create') }}" class="btn btn-success shadow-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Tutor
        </a>
    </div>

    {{-- Buscador --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('tutores.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="buscar" class="form-control border-start-0 ps-0" 
                               placeholder="Buscar por nombre, apellido o parentesco..." 
                               value="{{ request('buscar') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-search me-1"></i> buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

   {{-- Tabla Corregida --}}
<div class="card shadow border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="ps-4" style="width: 50px;">
                            <input class="form-check-input" type="checkbox" id="selectAllDocentes">
                        </th>
                        <th class="ps-4" style="color: #444; font-weight: 600;">Nombre Completo</th>
                        <th class="ps-4" style="color: #444; font-weight: 600;">CURP</th>
                        <th style="color: #444; font-weight: 600;">Parentesco</th>
                        <th style="color: #444; font-weight: 600;">Teléfono</th>
                        <th style="color: #444; font-weight: 600;">Municipio</th>
                        <th class="text-center" style="color: #444; font-weight: 600;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tutores as $tutor)
                    <tr>
                        <td class="ps-4">
                            <input class="form-check-input doc-checkbox" type="checkbox" value="{{ $tutor->id_tutor }}">
                        </td>
                        <td class="ps-4 py-3">
                            <span class="fw-bold text-dark">{{ $tutor->nombre }} {{ $tutor->apellido_p }} {{ $tutor->apellido_m }}</span>
                        </td>
                        <td class="ps-4 py-3">
                            <span class="fw-bold text-dark">{{ $tutor->curp }}</span>
                        </td>
                        <td class="py-3">
                            <span class="badge bg-info text-dark" style="font-size: 0.85rem;">
                                {{ $tutor->parentesco }}
                            </span>
                        </td>
                        {{-- CORRECCIÓN AQUÍ: Usamos no_telefono y municipio --}}
                        <td class="py-3 text-muted">{{ $tutor->no_telefono }}</td>
                        <td class="py-3 text-muted">{{ $tutor->municipio }}</td>
                        
                        <td class="text-center py-3">
                            <div class="btn-group">
                                <a href="{{ route('tutores.show', $tutor->id_tutor) }}" class="btn btn-sm btn-outline-secondary" title="Ver Detalles">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('tutores.edit', $tutor->id_tutor) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tutores.destroy', $tutor->id_tutor) }}" method="POST" class="d-inline form-eliminar">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-sweet-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center py-5">No hay resultados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

{{-- SCRIPT CORREGIDO --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Usamos delegación de eventos para que funcione incluso con paginación AJAX
        document.addEventListener('click', function(e) {
            // Verificamos si el clic fue en el botón de borrar o dentro de su icono
            const deleteButton = e.target.closest('.btn-sweet-delete');
            
            if (deleteButton) {
                e.preventDefault(); // Detenemos cualquier acción
                
                // Buscamos el formulario padre
                const form = deleteButton.closest('.form-eliminar');

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Esta acción eliminará al tutor permanentemente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Enviamos el formulario manualmente
                    }
                });
            }
        });
    });
</script>
@endsection