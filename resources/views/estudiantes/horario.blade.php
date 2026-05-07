@extends('estudiantes.inicio_estudiantes')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-calendar3 me-2 text-primary"></i>Mi Horario Escolar</h2>
        <a href="{{ route('estudiante.horario.pdf') }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill me-1"></i> Descargar en PDF
        </a>
    </div>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        {{-- Aquí recorres tu $horario con un @foreach --}}
                        <tr>
                            <td class="fw-bold">07:00 - 08:00</td>
                            <td>Matemáticas</td>
                            <td>Programación</td>
                            <td>-</td>
                            <td>Inglés</td>
                            <td>Base de Datos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection