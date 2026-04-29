<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Horario Docente - GDO</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #578a24; margin-bottom: 20px; padding-bottom: 10px; position: relative; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #578a24; color: white; padding: 8px; border: 1px solid #ddd; text-transform: uppercase; }
        td { padding: 6px; border: 1px solid #ddd; text-align: center; }
        .logo-small { width: 60px; position: absolute; left: 0; top: -10px; }
        .footer { position: fixed; bottom: -20px; width: 100%; text-align: center; font-size: 9px; color: #777; }
        .info-docente { margin-bottom: 15px; }
        .info-docente p { margin: 2px 0; font-size: 11px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('imagenes/PNGLOGO.png') }}" class="logo-small">
        <h2 style="margin:0; color: #578a24;">BACHILLERATO GUSTAVO DÍAZ ORDAZ</h2>
        <p style="margin:5px 0; font-weight: bold;">SISTEMA DE CONTROL ESTUDIANTIL</p>
        <p style="margin:0;">CARGA ACADÉMICA DEL DOCENTE</p>
    </div>

    <div class="info-docente">
        <p><strong>DOCENTE:</strong> {{ $docente->nombre }} {{ $docente->apellido_p }} {{ $docente->apellido_m }}</p>
        <p><strong>CORREO:</strong> {{ $docente->email }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="text-align: left;">MATERIA</th>
                <th>SEMESTRE</th>
                <th>GRUPO</th>
                <th>DÍA</th>
                <th>HORARIO</th>
                <th>SALÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaciones as $a)
            <tr>
                <td style="text-align: left; font-weight: bold;">{{ $a->materia->nombre_materia }}</td>
                <td>{{ $a->grupo->semestre->nombre_semestre ?? 'N/A' }}</td>
                <td>{{ $a->grupo->nombre_grupo }}</td>
                <td>{{ $a->dia_semana }}</td>
                <td>{{ substr($a->hora_inicio, 0, 5) }} - {{ substr($a->hora_fin, 0, 5) }}</td>
                <td>
                    <span style="color: #578a24; font-weight: bold;">{{ $a->aula }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        C.P. 72470, Puebla, Pue. | Horario generado el {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>