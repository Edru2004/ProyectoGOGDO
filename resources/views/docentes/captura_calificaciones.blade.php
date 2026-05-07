<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captura de Calificaciones - GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            background: #5d9b44; /* Verde Institucional */
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
        }

        .table-card {
            background: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 40px !important;
        }

        /* DISEÑO DE ENCABEZADO INSTITUCIONAL */
        .header-logo {
            width: 80px;
            height: auto;
        }
        .header-title {
            color: #5d9b44;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .header-subtitle {
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }
        .header-report-type {
            color: #666;
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .header-divider {
            border-top: 2px solid #5d9b44;
            margin: 15px 0 25px 0;
            opacity: 1;
        }

        /* DISEÑO DE TABLA INSTITUCIONAL */
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6 !important;
        }

        .table thead th {
            background-color: #5d9b44 !important; /* Verde GDO */
            color: white !important;
            vertical-align: middle;
            text-transform: uppercase;
            font-size: 0.8rem;
            border: 1px solid #4a7c36 !important;
            text-align: center;
        }

        .form-control {
            text-align: center;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 5px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #5d9b44;
            box-shadow: 0 0 0 0.25rem rgba(93, 155, 68, 0.25);
        }

        .bg-light-gdo {
            background-color: #f8f9fa !important;
            font-weight: bold;
        }

        .btn-success {
            background-color: #5d9b44;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: bold;
        }

        .btn-success:hover {
            background-color: #4a7c36;
        }

        .badge-grupo {
            background-color: #e6f4ea;
            color: #5d9b44;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: bold;
        }

        .info-docente {
            font-size: 0.9rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="sidebar p-4 shadow">
        <h4 class="fw-bold text-center mb-4"><i class="fas fa-graduation-cap"></i> GDO DOCENTE</h4>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a href="{{ route('docente.clases_docente') }}" class="btn btn-light w-100 text-start fw-bold">
                    <i class="fas fa-home me-2"></i> Volver al Inicio
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card table-card">
            <div class="container-fluid mb-4">
                <div class="row align-items-center">
                    <div class="col-2 text-center">
                        <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" class="header-logo">
                    </div>
                    <div class="col-8 text-center">
                        <h4 class="header-title">BACHILLERATO GENERAL OFICIAL GUSTAVO DÍAZ ORDAZ</h4>
                        <p class="header-subtitle">SISTEMA DE CONTROL ESTUDIANTIL</p>
                        <p class="header-report-type">CAPTURA DE CALIFICACIONES - CARGA ACADÉMICA DEL DOCENTE</p>
                    </div>
                    <div class="col-2 text-end">
                        <div class="badge-grupo">
                             Grupo: {{ $asignacion->grupo->nombre }}
                        </div>
                    </div>
                </div>
                <hr class="header-divider">

                <div class="row info-docente px-2">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>MATERIA:</strong> <span class="text-uppercase text-success">{{ $asignacion->materia->nombre }}</span></p>
                        <p class="mb-0"><strong>DOCENTE:</strong> <span class="text-uppercase">{{ Auth::user()->name }}</span></p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>CICLO ESCOLAR:</strong> 2025-2026</p>
                        <p class="mb-0"><strong>FECHA:</strong> {{ date('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('docente.guardar_calificaciones') }}" method="POST" id="formCalificaciones">
                @csrf
                <input type="hidden" name="id_asignacion" value="{{ $asignacion->id_asignacion }}">
                
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="text-center">
                            <tr>
                                <th rowspan="2" class="text-start" style="width: 35%; padding-left: 15px;">Nombre del Estudiante</th>
                                <th colspan="3">1er Periodo</th>
                                <th rowspan="2" class="bg-light-gdo text-dark">Suma (S)</th>
                                <th rowspan="2" class="bg-light-gdo text-dark">Promedio (P)</th>
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
                                $calif = $alumno->calificaciones
                                        ->where('id_asignacion', $asignacion->id_asignacion)
                                        ->where('id_materia', $asignacion->id_materia)
                                        ->first();
                            @endphp
                            
                            <tr class="student-row">
                                <td class="text-start ps-3">
                                    <div class="fw-bold text-uppercase" style="font-size: 0.8rem; color: #444;">
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
                                <td class="text-center bg-light-gdo">
                                    <span class="suma">0.0</span>
                                </td>
                                <td class="text-center bg-light-gdo">
                                    <span class="promedio text-success">0.0</span>
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
        function calcularFila(row) {
            let n1 = parseFloat(row.querySelector('.n1').value) || 0;
            let n2 = parseFloat(row.querySelector('.n2').value) || 0;
            let n3 = parseFloat(row.querySelector('.n3').value) || 0;

            let suma = n1 + n2 + n3;
            let promedio = (suma / 3).toFixed(1);

            row.querySelector('.suma').innerText = suma.toFixed(1);
            row.querySelector('.promedio').innerText = promedio;

            if (promedio < 6) {
                row.querySelector('.promedio').classList.replace('text-success', 'text-danger');
            } else {
                row.querySelector('.promedio').classList.replace('text-danger', 'text-success');
            }
        }

        document.querySelectorAll('.student-row').forEach(row => {
            calcularFila(row);
            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => calcularFila(row));
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>