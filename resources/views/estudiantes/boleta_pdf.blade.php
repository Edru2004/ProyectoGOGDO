<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta_Academica_{{ $estudiante->matricula }}</title>
    <style>
        /* Estilos específicos para PDF (DomPDF) */
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.4; }
        
        .header-table { width: 100%; border: none; margin-bottom: 10px; }
        .logo { width: 70px; }
        .title-container { text-align: center; }
        .inst-name { color: #5d9b44; font-size: 18pt; font-weight: bold; margin: 0; }
        .subtitle { font-size: 10pt; color: #666; font-weight: bold; margin: 0; }
        
        .line { border-bottom: 2px solid #5d9b44; margin: 10px 0 20px 0; }
        
        .info-estudiante { margin-bottom: 20px; font-size: 10pt; }
        .info-estudiante strong { color: #000; }

        .cal-table { width: 100%; border-collapse: collapse; font-size: 9pt; }
        .cal-table th { background-color: #5d9b44; color: white; padding: 8px; text-transform: uppercase; border: 1px solid #4a7c36; }
        .cal-table td { padding: 8px; border: 1px solid #dee2e6; text-align: center; }
        .cal-table .materia-name { text-align: left; font-weight: bold; padding-left: 10px; }
        
        .text-success { color: #28a745; font-weight: bold; }
        .text-danger { color: #dc3545; font-weight: bold; }
        .footer { margin-top: 20px; font-size: 8pt; text-align: right; color: #777; font-style: italic; }
        
        /* Cebra para las filas */
        .cal-table tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 15%;">
                {{-- Usamos path real para que el PDF encuentre la imagen en el servidor --}}
                <img src="{{ public_path('imagenes/PNGLOGO.png') }}" class="logo">
            </td>
            <td class="title-container" style="width: 85%;">
                <h1 class="inst-name">BACHILLERATO GENERAL OFICIAL GUSTAVO DÍAZ ORDAZ</h1>
                <p class="subtitle">SISTEMA DE CONTROL ESTUDIANTIL</p>
                <p class="subtitle" style="font-weight: normal;">BOLETA ACADÉMICA DEL ESTUDIANTE</p>
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="info-estudiante">
        <strong>ESTUDIANTE:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido_p }} {{ $estudiante->apellido_m }}<br>
        <strong>MATRÍCULA:</strong> {{ $estudiante->id_estudiante }}<br>
        <strong>CURP:</strong> {{ $estudiante->curp ?? 'N/A' }}
    </div>

    <table class="cal-table">
        <thead>
            <tr>
                <th style="width: 35%;">Materia</th>
                <th>Semestre</th>
                <th>Grupo</th>
                <th>P1</th>
                <th>P2</th>
                <th>P3</th>
                <th>Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calificaciones as $cal)
                @php 
                    $p1 = $cal->p1_n1 ?? 0;
                    $p2 = $cal->p1_n2 ?? 0;
                    $p3 = $cal->p1_n3 ?? 0;
                    $promedio = ($p1 + $p2 + $p3) / 3;
                @endphp
                <tr>
                    <td class="materia-name">{{ $cal->asignacion->materia->nombre_materia ?? 'N/A' }}</td>
                    <td>{{ $estudiante->inscripcion->semestre->nombre_semestre ?? 'N/A' }}</td>
                    <td>{{ $estudiante->inscripcion->grupo->nombre_grupo ?? 'N/A' }}</td>
                    <td>{{ number_format($p1, 1) }}</td>
                    <td>{{ number_format($p2, 1) }}</td>
                    <td>{{ number_format($p3, 1) }}</td>
                    <td class="{{ $promedio >= 6 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($promedio, 1) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        * Esta boleta es de carácter informativo y no tiene validez oficial sin sellos institucionales.
    </div>

</body>
</html>