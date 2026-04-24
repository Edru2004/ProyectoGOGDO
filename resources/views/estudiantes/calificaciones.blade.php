<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Calificaciones - GDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <div class="sidebar" id="sidebar">
        <div class="profile-section">
            <div class="profile-avatar">
                <i class="fas fa-user-graduate"></i>
            </div>
            <p class="welcome-text mb-0">Bienvenido(a)</p>
            <p class="mb-0 text-white fw-bold">
                {{ Auth::guard('estudiante')->user()->nombre }}
            </p>
        </div>

        <a href="{{ route('estudiante.dashboard') }}"><i class="fas fa-home"></i><span>Inicio</span></a>
        <a href="{{ route('estudiante.credencial') }}"><i class="fas fa-id-card"></i><span>Mi Credencial</span></a>
        <a href="{{ route('estudiante.calificaciones') }}" class="active"> <i class="fas fa-star"></i><span>Mis Calificaciones</span></a>

        <form action="{{ route('estudiante.logout') }}" method="POST" id="logout-form">
            @csrf
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
                <i class="fas fa-sign-out-alt"></i><span>Cerrar Sesión</span>
            </a>
        </form>
    </div>

    <div class="content">
        <nav class="navbar navbar-dark p-3 mb-4 shadow-sm" style="background-color: #003366;">
            <div class="container-fluid">
                <button id="toggleBtn" class="btn btn-outline-light border-0">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="navbar-brand mb-0 h1 ms-3 text-white">SISTEMA CONTROL ESTUDIANTIL GDO</span>
            </div>
        </nav>

        <div class="container-fluid">
            {{-- Sección de Tabla de Calificaciones --}}
            <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0 text-primary"><i class="fas fa-list-ol me-2"></i>Boleta de Calificaciones</h4>
                    <span class="badge bg-info text-dark">Ciclo Escolar 2025 - 2026</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th class="text-start" style="width: 40%;">Materia</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Parcial 3</th>
                                <th class="table-primary">Promedio Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($calificaciones as $calif)
                            <tr>
                                <td class="text-start fw-bold text-uppercase">{{ $calif->materia->nombre }}</td>
                                <td>{{ $calif->p1_n1 ?? 'N/A' }}</td>
                                <td>{{ $calif->p1_n2 ?? 'N/A' }}</td>
                                <td>{{ $calif->p1_n3 ?? 'N/A' }}</td>
                                <td class="fw-bold {{ ($calif->p1_n1 + $calif->p1_n2 + $calif->p1_n3) / 3 >= 6 ? 'text-success' : 'text-danger' }}">
                                    {{ number_format(($calif->p1_n1 + $calif->p1_n2 + $calif->p1_n3) / 3, 1) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-muted p-5">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                    Aún no tienes calificaciones capturadas. Consulta con tu docente.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("toggleBtn").onclick = function () {
            document.getElementById("sidebar").classList.toggle("closed");
        }
    </script>
</body>
</html>