<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;

    // Nota: Verifica si en MariaDB tu tabla empieza con C mayúscula o minúscula
    protected $table = 'calificaciones'; 
    protected $primaryKey = 'id_calificacion';
    public $timestamps = false; 

    protected $fillable = [
        'id_estudiante',
        'id_asignacion', // ESTA ES LA CLAVE para conectar con materia y docente
        'p1_n1', 'p1_n2', 'p1_n3',
        'p2_n1', 'p2_n2', 'p2_n3',
        'p3_n1', 'p3_n2', 'p3_n3',
    ];

    // Relación vital para la boleta
   public function asignacion()
    {
        return $this->belongsTo(Asignaciones::class, 'id_asignacion', 'id_asignacion');
    }

    public function estudiante() {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }
}