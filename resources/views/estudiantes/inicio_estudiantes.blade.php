@extends('estudiantes.dashboard')

@section('content') 
<div class="container-fluid px-4">
    <div class="row justify-content-center mt-5">
        {{-- Contenedor relativo para que el absolute no se escape de la pantalla --}}
        <div class="col-md-10 text-center position-relative">
            
            {{-- Tu logo con la posición exacta que pediste --}}
            <div style="position: absolute; right: 1300px; top: -70px; z-index: 10;">
                <img src="{{ asset('imagenes/PNGLOGO.png') }}" alt="Logo GDO" 
                     style="max-height: 200px; width: auto; filter: drop-shadow(2px 4px 6px rgba(0,0,0,0.1));">
            </div>

            <!-- TITULO -->
            <h1 class="fw-bold display-4 text-success" style="font-family: 'Poppins', sans-serif;">
                GDO PLATAFORMA DIGITAL
            </h1>

            <!-- TEXTO -->
            <p class="text-muted lead">
                Tu portal escolar para consultar calificaciones y horarios.
            </p>
            
            <hr class="mx-auto" style="width: 15%; border: 2px solid #198754; opacity: 1; border-radius: 10px;">

            <div class="mt-4">
                <p>Bienvenida al Sistema de Control Estudiantil, <strong>{{ Auth::guard('estudiante')->user()->nombre }}</strong></p>
            </div>
            
        </div>
    </div>
</div>
@endsection