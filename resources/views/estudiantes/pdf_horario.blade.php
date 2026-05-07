<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Horario de Clases</h1>
        <p>Alumno: {{ $estudiante->nombre }} {{ $estudiante->apellido_p }} | Matrícula: {{ $estudiante->id_estudiante }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Hora</th>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mié</th>
                <th>Jue</th>
                <th>Vie</th>
            </tr>
        </thead>
        <tbody>
            {{-- Tu @foreach aquí --}}
            <tr>
                <td>07:00 - 08:00</td>
                <td>Matemáticas</td>
                <td>Programación</td>
                <td>-</td>
                <td>Inglés</td>
                <td>Base de Datos</td>
            </tr>
        </tbody>
    </table>
</body>
</html>