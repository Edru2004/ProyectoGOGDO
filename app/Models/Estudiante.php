<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $table = 'Estudiante'; 
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false; 

   protected $fillable = [
    'nombre', 'apellido_p', 'apellido_m', 'curp', 'email', 'password', 
    'sexo', 'fecha_nac', 'telefono', 'municipio', 'localidad', 'calle', 'numero', 'id_tutor'
];
    public function tutor() {
        return $this->belongsTo(Tutor::class, 'id_tutor', 'id_tutor');
    }

    public function inscripcion() {
        return $this->hasOne(Inscripciones::class, 'id_estudiante', 'id_estudiante');
    }
}