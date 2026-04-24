@extends('index')

@section('contenido_dinamico')
<div class="container-fluid px-4">
    <div class="row mt-5 mb-4 position-relative">
        
        <div style="position: absolute; right: -1300px; top: -70px; z-index: 10;">
            <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" 
                 style="max-height: 170px; width: auto; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));">
        </div>

        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-success mb-0" style="font-family: 'Poppins', sans-serif;">
                Panel de Inicio
            </h1>
            <p class="lead text-muted">Bienvenida al Sistema de Control Estudiantil - GDO, Dulce Rubi.</p>
            <hr class="mx-auto" style="width: 15%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">
        </div>

    </div>
</div>

    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow-sm border-0 p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Total Alumnos</h6>
                        <h2 class="fw-bold mb-0">{{ $totalEstudiantes }}</h2>
                    </div>
                    <i class="bi bi-people-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow-sm border-0 p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Personal Docente</h6>
                        <h2 class="fw-bold mb-0">{{ $totalDocentes }}</h2>
                    </div>
                    <i class="bi bi-person-badge-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-dark shadow-sm border-0 p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase fw-bold opacity-75">Padres de Familia</h6>
                        <h2 class="fw-bold mb-0">{{ $totalTutores }}</h2>
                    </div>
                    <i class="bi bi-shield-lock-fill fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card p-4 shadow-sm border-0" style="background-color: #f8f9fa;">
                <h5 class="fw-bold mb-3"><i class="bi bi-search me-2"></i>Búsqueda Rápida de Alumnos</h5>
                <form action="{{ route('estudiantes.index') }}" method="GET" class="input-group shadow-sm">
                    <input type="text" name="buscar" class="form-control border-0" placeholder="Nombre, apellido o matrícula..." style="padding: 12px;">
                    <button class="btn btn-success px-4" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-people text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Estudiantes</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('estudiantes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('estudiantes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-person-workspace text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Docentes</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('docentes.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100 p-4">
                <i class="bi bi-shield-check text-success fs-1"></i>
                <h4 class="fw-bold mt-3">Padres</h4>
                <div class="d-flex gap-2 justify-content-center mt-auto">
                    <a href="{{ route('tutores.index') }}" class="btn btn-outline-success btn-sm w-50">Lista</a>
                    <a href="{{ route('tutores.create') }}" class="btn btn-success btn-sm w-50">Nuevo</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; }
</style>
@endsection