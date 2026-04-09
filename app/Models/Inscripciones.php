<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inscripciones extends Model {
    protected $table = 'Inscripciones';
    protected $primaryKey = 'id_inscripcion';
    public $timestamps = false;
    protected $fillable = ['id_estudiante', 'id_semestre', 'id_grupo', 'ciclo_escolar', 'estado_inscripcion'];

    public function semestre() { 
        return $this->belongsTo(Semestre::class, 'id_semestre', 'id_semestre'); 
    }
    public function grupo() { 
        return $this->belongsTo(Grupos::class, 'id_grupo', 'id_grupo'); 
    }
}