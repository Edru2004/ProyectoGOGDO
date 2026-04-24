<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    use HasFactory;

    protected $table = 'Calificaciones'; 
    protected $primaryKey = 'id_calificacion';
    public $timestamps = false; 

    protected $fillable = [
        'id_estudiante',
        'id_materia',
        'p1_n1', 'p1_n2', 'p1_n3',
        'p2_n1', 'p2_n2', 'p2_n3',
        'p3_n1', 'p3_n2', 'p3_n3',
    ];

    public function materia() {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    public function estudiante() {
        return $this->belongsTo(Estudiante::class, 'id_estudiante', 'id_estudiante');
    }
    public function calificaciones() {
    return $this->hasMany(Calificaciones::class, 'id_estudiante', 'id_estudiante');
}
}