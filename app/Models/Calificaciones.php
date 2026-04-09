<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;

    // Nombre de la tabla tal cual está en MariaDB
    protected $table = 'Calificaciones'; 

    // Llave primaria personalizada
    protected $primaryKey = 'id_calificacion';

    // Desactivamos timestamps ya que no están en tu CREATE TABLE
    public $timestamps = false; 

    /**
     * Los atributos que se pueden asignar masivamente.
     * NOTA: No incluimos los campos 'promedio' ni 'promedio_final' 
     * porque son columnas generadas (STORED) en la BD.
     */
    protected $fillable = [
        'id_estudiante',
        'id_materia',
        // Periodo 1: Notas 1, 2 y 3 (como en la lista)
        'p1_n1', 
        'p1_n2', 
        'p1_n3',
        // Periodo 2: Notas 1, 2 y 3
        'p2_n1', 
        'p2_n2', 
        'p2_n3',
        // Periodo 3: Notas 1, 2 y 3
        'p3_n1', 
        'p3_n2', 
        'p3_n3',
    ];

    /**
     * Relación con el modelo Materia.
     * Permite obtener el nombre de la materia (ej. Matemáticas, Literatura).
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    /**
     * Relación con el modelo Estudiante.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }
}