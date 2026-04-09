<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Calificaciones | GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: #28a745; min-height: 100vh; color: white; position: fixed; width: 250px; transition: all 0.3s; }
        .main-content { margin-left: 250px; padding: 30px; }
        .table-card { background: white; border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25); }
        .badge-info-gdo { background-color: #e8f5e9; color: #28a745; font-weight: 600; padding: 8px 15px; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="sidebar p-4 shadow">
        <div class="text-center mb-4">
            <i class="fas fa-graduation-cap fa-3x mb-2"></i>
            <h4 class="fw-bold">GDO DOCENTE</h4>
        </div>
        <hr>
        <nav class="nav flex-column">
            <a href="{{ route('docente.dashboard') }}" class="btn btn-light w-100 mb-3 fw-bold text-success">
                <i class="fas fa-arrow-left me-2"></i> Volver al Inicio
            </a>
        </nav>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Captura de Calificaciones</h2>
                <p class="text-muted">Ingresa los resultados de los parciales para cada estudiante.</p>
            </div>
            <div class="d-flex gap-2">
                <span class="badge-info-gdo">
                    <i class="fas fa-book me-2"></i>{{ $asignacion->materia->nombre }}
                </span>
                <span class="badge bg-dark d-flex align-items-center px-3" style="border-radius: 10px;">
                    <i class="fas fa-users me-2"></i>Grupo: {{ $asignacion->group->nombre ?? 'N/A' }}
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 12px;">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-card p-4">
            <form action="{{ route('docente.guardar_calificaciones') }}" method="POST">
                @csrf
                
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3" style="border-top-left-radius: 10px; border-bottom-left-radius: 10px;">Nombre del Estudiante</th>
                            <th width="150" class="text-center">Parcial 1</th>
                            <th width="150" class="text-center">Parcial 2</th>
                            <th width="150" class="text-center">Parcial 3</th>
                            <th width="100" class="text-center pe-3" style="border-top-right-radius: 10px; border-bottom-right-radius: 10px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alumnos as $alumno)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold text-dark">{{ $alumno->apellido_p }} {{ $alumno->apellido_m }}</span><br>
                                <small class="text-muted">{{ $alumno->nombre }}</small>
                            </td>
                            <td>
                                <input type="number" step="0.1" min="0" max="10" 
                                       name="notas[{{ $alumno->id_estudiante }}][n1]" 
                                       class="form-control text-center border-success-subtle" 
                                       placeholder="0.0">
                            </td>
                            <td>
                                <input type="number" step="0.1" min="0" max="10" 
                                       name="notas[{{ $alumno->id_estudiante }}][n2]" 
                                       class="form-control text-center border-success-subtle" 
                                       placeholder="0.0">
                            </td>
                            <td>
                                <input type="number" step="0.1" min="0" max="10" 
                                       name="notas[{{ $alumno->id_estudiante }}][n3]" 
                                       class="form-control text-center border-success-subtle" 
                                       placeholder="0.0">
                            </td>
                            <td class="text-center">
                                <i class="fas fa-edit text-muted"></i>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-25">
                                <p class="text-muted fw-bold">No hay alumnos inscritos en este grupo.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm" style="border-radius: 10px;">
                        <i class="fas fa-save me-2"></i> GUARDAR CALIFICACIONES
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>