@extends('Index')

@section('contenido_dinamico')
<div class="container mt-4">
    
    <div class="mb-3">
        <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left-circle"></i> Volver al Listado
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0 fw-bold">
                <i class="bi bi-calendar-plus me-2"></i>Asignar Horario a: {{ $docente->nombre }} {{ $docente->apellido_p }}
            </h4>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('asignaciones.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_docente" value="{{ $docente->id_docente }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Materia</label>
                        <select name="id_materia" class="form-select" required>
                            <option value="">-- Seleccione Materia --</option>
                            @foreach($materias as $m)
                                <option value="{{ $m->id_materia }}">{{ $m->nombre_materia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Grupo</label>
                        <select name="id_grupo" class="form-select" required>
                            <option value="">-- Seleccione Grupo --</option>
                            @foreach($grupos as $g)
                                <option value="{{ $g->id_grupo }}">{{ $g->nombre_grupo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Día</label>
                        <select name="dia_semana" class="form-select" required>
                            <option value="Lunes">Lunes</option>
                            <option value="Martes">Martes</option>
                            <option value="Miercoles">Miércoles</option> 
                            <option value="Jueves">Jueves</option>
                            <option value="Viernes">Viernes</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hora Inicio</label>
                        <input type="time" name="hora_inicio" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hora Fin</label>
                        <input type="time" name="hora_fin" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Aula / Salón</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                        <input type="text" name="aula" class="form-control" placeholder="Ej. Aula 12 o Laboratorio B" required>
                    </div>
                </div>

                <div class="text-end border-top pt-3">
                    <a href="{{ route('docentes.index') }}" class="btn btn-secondary px-4 me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-save"></i> Guardar Asignación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection