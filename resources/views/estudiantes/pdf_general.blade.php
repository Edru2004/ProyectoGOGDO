<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte General - GDO</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #578a24; margin-bottom: 20px; padding-bottom: 10px; position: relative; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #578a24; color: white; padding: 8px; border: 1px solid #ddd; text-transform: uppercase; }
        td { padding: 6px; border: 1px solid #ddd; text-align: center; }
        .logo-small { width: 60px; position: absolute; left: 0; top: -10px; }
        .footer { position: fixed; bottom: -20px; width: 100%; text-align: center; font-size: 9px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('imagenes/PNGLOGO.png') }}" class="logo-small">
        <h2 style="margin:0; color: #578a24;">BACHILLERATO GUSTAVO DÍAZ ORDAZ</h2>
        <p style="margin:5px 0; font-weight: bold;">SISTEMA DE CONTROL ESTUDIANTIL</p>
        <p style="margin:0;">LISTA GENERAL DE ESTUDIANTES INSCRITOS</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th style="text-align: left;">NOMBRE COMPLETO</th>
                <th>CURP</th>
                <th>CORREO ELECTRÓNICO</th>
                <th>GRADO/GRUPO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantes as $est)
            <tr>
                <td>{{ $est->id_estudiante }}</td>
                <td style="text-align: left;">
                    {{ $est->nombre }} {{ $est->apellido_p }} {{ $est->apellido_m }}
                </td>
                <td>{{ $est->curp }}</td>
                <td>{{ $est->email }}</td>
                <td>
                    {{ $est->inscripcion->semestre->nombre_semestre ?? 'N/A' }} - 
                    {{ $est->inscripcion->grupo->nombre_grupo ?? 'S/G' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        C.P. 11111, Puebla, Pue. | Página generada el {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>