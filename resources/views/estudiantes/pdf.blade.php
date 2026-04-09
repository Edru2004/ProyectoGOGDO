<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte Estudiante - GDO</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .header-table { width: 100%; border-bottom: 3px solid #578a24; margin-bottom: 20px; }
        .logo { width: 80px; }
        .escuela-nombre { text-align: center; font-size: 20px; font-weight: bold; color: #578a24; }
        .subtitulo { text-align: center; font-size: 14px; margin-top: 5px; color: #555; }
        
        .tabla-datos { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .tabla-datos th { background-color: #f2f2f2; width: 30%; text-align: left; padding: 8px; border: 1px solid #ddd; font-size: 12px; }
        .tabla-datos td { padding: 8px; border: 1px solid #ddd; font-size: 12px; }
        
        .seccion-titulo { background-color: #578a24; color: white; padding: 5px 10px; margin-top: 20px; font-size: 14px; font-weight: bold; }
        .footer { position: fixed; bottom: -30px; left: 0px; right: 0px; height: 50px; text-align: center; font-size: 10px; color: #777; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 20%;">
                <img src="{{ public_path('imagenes/PNGLOGO.png') }}" class="logo">
            </td>
            <td style="width: 80%;" class="escuela-nombre">
                BACHILLERATO GENERAL OFICIAL GUSTAVO DÍAZ ORDAZ
                <div class="subtitulo">SISTEMA DE CONTROL ESTUDIANTIL</div>
                <div style="font-size: 12px; color: #000;">REPORTE DE DATOS DEL ALUMNO</div>
            </td>
        </tr>
    </table>

    <div class="seccion-titulo">DATOS PERSONALES</div>
    <table class="tabla-datos">
        <tr><th>NOMBRE COMPLETO</th><td>{{ $estudiante->nombre }} {{ $estudiante->apellido_p }} {{ $estudiante->apellido_m }}</td></tr>
        <tr><th>CURP</th><td>{{ $estudiante->curp }}</td></tr>
        <tr><th>CORREO ELECTRÓNICO</th><td>{{ $estudiante->email }}</td></tr>
    </table>

    <div class="seccion-titulo">INFORMACIÓN ACADÉMICA</div>
    <table class="tabla-datos">
        <tr><th>SEMESTRE</th><td>{{ $estudiante->inscripcion->semestre->nombre_semestre ?? 'N/A' }}</td></tr>
        <tr><th>GRUPO</th><td>{{ $estudiante->inscripcion->grupo->nombre_grupo ?? 'N/A' }}</td></tr>
        <tr><th>ESTADO</th><td>{{ $estudiante->inscripcion->estado_inscripcion ?? 'Activo' }}</td></tr>
    </table>

<div class="seccion-titulo">INFORMACIÓN DEL TUTOR / RESPONSABLE</div>
<table class="tabla-datos">
    <tr>
        <th>NOMBRE DEL TUTOR</th>
        <td>{{ $estudiante->tutor->nombre ?? 'Dato no registrado' }} {{ $estudiante->tutor->apellido_p ?? '' }}</td>
    </tr>
    <tr>
        <th>PARENTESCO</th>
        <td>{{ $estudiante->tutor->parentesco ?? 'N/A' }}</td>
    </tr>
    <tr>
        <th>TELÉFONO DE CONTACTO</th>
        <td>{{ $estudiante->tutor->no_telefono ?? 'Sin número' }}</td>
  <tr>
    <th>DIRECCIÓN</th>
    <td>
        @if($estudiante->tutor)
            {{ $estudiante->tutor->calle ?? '' }} #{{ $estudiante->tutor->numero ?? '' }}, 
            {{ $estudiante->tutor->localidad ?? '' }}, 
            {{ $estudiante->tutor->municipio ?? '' }}
        @else
            Dirección no registrada
        @endif
    </td>
</tr>
</table>

    <div class="footer">
        C.P. 72470, Puebla, Pue. | Generado el {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>