<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Calificaciones - GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .sidebar { background: #28a745; min-height: 100vh; color: white; position: fixed; width: 250px; transition: all 0.3s; }
        .main-content { margin-left: 250px; padding: 30px; }
        .table-card { background: white; border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
        .table thead { background-color: #f8f9fa; }
        .form-control { text-align: center; border-radius: 8px; border: 1px solid #dee2e6; padding: 8px; }
        .form-control:focus { border-color: #28a745; box-shadow: 0 0 0 0.25 row rgba(40, 167, 69, 0.25); }
        .btn-success { background-color: #28a745; border: none; border-radius: 10px; padding: 12px 30px; font-weight: bold; }
        .btn-success:hover { background-color: #218838; }
        .badge-grupo { background-color: #e6f4ea; color: #1e7e34; padding: 10px 20px; border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>

    <div class="sidebar p-4 shadow">
        <h4 class="fw-bold text-center mb-4"><i class="fas fa-graduation-cap"></i> GDO DOCENTE</h4>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a href="{{ route('docente.dashboard') }}" class="btn btn-light w-100 text-start fw-bold">
                    <i class="fas fa-home me-2"></i> Volver al Inicio
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Captura: {{ $asignacion->materia->nombre }}</h2>
                <p class="text-muted small">Bachillerato General Gustavo Díaz Ordaz</p>
            </div>
            <div class="badge-grupo">
                <i class="fas fa-users me-2"></i> Grupo: {{ $asignacion->grupo->nombre }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card table-card p-4">
            <form action="{{ route('docente.guardar_calificaciones') }}" method="POST" id="formCalificaciones">
                @csrf
                <input type="hidden" name="id_materia" value="{{ $asignacion->id_materia }}">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th rowspan="2" class="text-start" style="width: 30%;">Nombre del Estudiante</th>
                                <th colspan="3" class="border-bottom">1er Periodo</th>
                                <th rowspan="2">Suma (S)</th>
                                <th rowspan="2">Promedio (P)</th>
                            </tr>
                            <tr>
                                <th width="100">N1</th>
                                <th width="100">N2</th>
                                <th width="100">N3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @php
                                // Buscamos si ya existe calificación guardada para este alumno en esta materia
                                $calif = $alumno->calificaciones->where('id_materia', $asignacion->id_materia)->first();
                            @endphp
                            <tr class="student-row">
                                <td class="text-start">
                                    <div class="fw-bold text-uppercase" style="font-size: 0.9rem;">
                                        {{ $alumno->apellido_p }} {{ $alumno->apellido_m }} {{ $alumno->nombre }}
                                    </div>
                                </td>
                                <td>
                                    <input type="number" step="0.1" name="notas[{{ $alumno->id_estudiante }}][n1]" 
                                           class="form-control n1" min="0" max="10" 
                                           value="{{ $calif ? $calif->p1_n1 : '' }}" placeholder="0.0">
                                </td>
                                <td>
                                    <input type="number" step="0.1" name="notas[{{ $alumno->id_estudiante }}][n2]" 
                                           class="form-control n2" min="0" max="10" 
                                           value="{{ $calif ? $calif->p1_n2 : '' }}" placeholder="0.0">
                                </td>
                                <td>
                                    <input type="number" step="0.1" name="notas[{{ $alumno->id_estudiante }}][n3]" 
                                           class="form-control n3" min="0" max="10" 
                                           value="{{ $calif ? $calif->p1_n3 : '' }}" placeholder="0.0">
                                </td>
                                <td class="text-center bg-light">
                                    <span class="suma fw-bold">0</span>
                                </td>
                                <td class="text-center bg-light">
                                    <span class="promedio fw-bold text-success">0.0</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="fas fa-save me-2"></i> GUARDAR CALIFICACIONES
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Función para calcular Suma y Promedio en tiempo real
        function calcularFila(row) {
            let n1 = parseFloat(row.querySelector('.n1').value) || 0;
            let n2 = parseFloat(row.querySelector('.n2').value) || 0;
            let n3 = parseFloat(row.querySelector('.n3').value) || 0;

            let suma = n1 + n2 + n3;
            let promedio = (suma / 3).toFixed(1);

            row.querySelector('.suma').innerText = suma.toFixed(1);
            row.querySelector('.promedio').innerText = promedio;
            
            // Cambiar color si reprueba (opcional)
            if (promedio < 6) {
                row.querySelector('.promedio').classList.replace('text-success', 'text-danger');
            } else {
                row.querySelector('.promedio').classList.replace('text-danger', 'text-success');
            }
        }

        // Ejecutar cálculo al escribir
        document.querySelectorAll('.student-row').forEach(row => {
            // Calcular valores iniciales al cargar la página (por si ya hay datos)
            calcularFila(row);

            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => calcularFila(row));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>