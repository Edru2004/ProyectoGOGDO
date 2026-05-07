@extends('docentes.dashboard_maestro')

@section('content')
<div class="container-fluid">
    <div class="row">
        @forelse($misClases as $clase)
            @php
                // Definimos valores por defecto
                $colorBase = $clase->color_card ?? '#198754'; 
                $icono = $clase->icono_card ?? 'fa-solid fa-book-open';
                
                // Creamos el color con transparencia para el fondo del icono
                // Esto evita que VS Code se confunda con el "22" pegado a las llaves
                $colorFondoIcono = $colorBase . '22'; 
            @endphp
            
            <div class="col-md-4 mb-4">
                <!-- Usamos comillas dobles para el style y simples para las variables si es necesario -->
                <div class="card h-100 shadow-sm border-0" style="border-radius: 15px; border-left: 5px solid {{ $colorBase }} !important;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-4">
                            <!-- El fondo ahora usa la variable ya preparada en PHP -->
                            <div class="icon-box" style="background-color: {{ $colorFondoIcono }}; color: {{ $colorBase }}; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                                <i class="{{ $icono }}"></i>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#modalEstilo{{ $clase->id_asignacion }}">
                                    <i class="fas fa-palette text-muted"></i>
                                </button>
                                <span class="badge d-flex align-items-center px-3" style="background-color: {{ $colorBase }}; font-size: 0.9rem; border-radius: 8px;">
                                    {{ $clase->grupo->id_semestre ?? '?' }}° {{ $clase->grupo->nombre_grupo ?? 'S/G' }}
                                </span>
                            </div>
                        </div>

                        <h5 class="fw-bold mb-1 text-dark">
                            {{ $clase->materia->nombre_materia ?? 'Materia no encontrada' }}
                        </h5>
                        <p class="text-muted small mb-4">Bachillerato Gustavo Díaz Ordaz</p>

                        <div class="d-flex align-items-center text-secondary small mb-4">
                            <i class="bi bi-door-open-fill me-2"></i> <strong>Aula:</strong> {{ $clase->aula ?? 'N/A' }}
                        </div>

                        <a href="{{ route('docente.lista', $clase->id_asignacion) }}" class="btn w-100 py-2 fw-bold shadow-sm text-white" style="border-radius: 10px; background-color: {{ $colorBase }}; border: none;">
                            <i class="bi bi-pencil-square me-2"></i> Capturar Notas
                        </a>
                    </div>
                </div>
            </div>

            <!-- MODAL DE PERSONALIZACIÓN -->
            <div class="modal fade" id="modalEstilo{{ $clase->id_asignacion }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 15px;">
                        <form action="{{ route('docente.actualizar_estilo', $clase->id_asignacion) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header border-0 p-4">
                                <h5 class="modal-title fw-bold">Personalizar Clase</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-4 pb-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary small">COLOR DE LA TARJETA</label>
                                    <input type="color" name="color_card" class="form-control form-control-color w-100" style="height: 50px;" value="{{ $colorBase }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-bold text-secondary small">ICONO REPRESENTATIVO</label>
                                    <select name="icono_card" class="form-select border-0 bg-light py-2">
                                        <option value="fa-solid fa-book-open" {{ $icono == 'fa-solid fa-book-open' ? 'selected' : '' }}>📖 Libro (General)</option>
                                        <option value="fa-solid fa-calculator" {{ $icono == 'fa-solid fa-calculator' ? 'selected' : '' }}>🔢 Matemáticas</option>
                                        <option value="fa-solid fa-flask" {{ $icono == 'fa-solid fa-flask' ? 'selected' : '' }}>🧪 Ciencias</option>
                                        <option value="fa-solid fa-palette" {{ $icono == 'fa-solid fa-palette' ? 'selected' : '' }}>🎨 Artes</option>
                                        <option value="fa-solid fa-laptop-code" {{ $icono == 'fa-solid fa-laptop-code' ? 'selected' : '' }}>💻 Tecnología</option>
                                        <option value="fa-solid fa-gavel" {{ $icono == 'fa-solid fa-gavel' ? 'selected' : '' }}>⚖️ Derecho</option>
                                        <option value="fa-solid fa-earth-americas" {{ $icono == 'fa-solid fa-earth-americas' ? 'selected' : '' }}>🌎 Geografía / Historia</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0 p-4">
                                <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancelar</button>
                                <button type="submit" class="btn btn-dark fw-bold px-4" style="border-radius: 10px;">Guardar Estilo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                <h4 class="text-muted mt-3">No tienes clases asignadas en este periodo.</h4>
            </div>
        @endforelse
    </div>
</div>
@endsection