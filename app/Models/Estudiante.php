<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// CAMBIO CLAVE: Importamos Authenticatable en lugar de Model
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Estudiante extends Authenticatable // Cambiamos la extensión aquí
{
    use HasFactory, Notifiable;

    // Se mantiene tu tabla en singular como en la base de datos
    protected $table = 'Estudiante'; 
    protected $primaryKey = 'id_estudiante';
    public $timestamps = false; 

    protected $fillable = [
        'nombre', 'apellido_p', 'apellido_m', 'curp', 'email', 'password', 
        'sexo', 'fecha_nac', 'telefono', 'municipio', 'localidad', 'calle', 'numero', 'id_tutor'
    ];

    // IMPORTANTE: Ocultar la contraseña para que no se incluya en respuestas JSON o similares
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Tus relaciones están perfectas, no las muevas:
    public function tutor() {
        return $this->belongsTo(Tutor::class, 'id_tutor', 'id_tutor');
    }

    public function inscripcion() {
        return $this->hasOne(Inscripciones::class, 'id_estudiante', 'id_estudiante');
    }
}