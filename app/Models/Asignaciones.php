<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    use HasFactory;

    protected $table = 'asignaciones';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    protected $fillable = [
        'id_docente', 'id_materia', 'id_grupo', 'dia_semana', 'hora_inicio', 'hora_fin', 'aula'
    ];

    // Relación: Una asignación pertenece a una materia
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia', 'id_materia');
    }

    // Relación: Una asignación pertenece a un grupo
    public function grupo()
    {
        return $this->belongsTo(Grupos::class, 'id_grupo', 'id_grupo');
    }

    // Relación: Una asignación pertenece a un docente
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }
}