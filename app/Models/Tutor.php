<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    use HasFactory;

    protected $table = 'Tutor';
    protected $primaryKey = 'id_tutor';
    public $timestamps = false;

protected $fillable = [
    'nombre',
    'apellido_p',
    'apellido_m',
    'curp', // <--- Agrega esto
    'parentesco',
    'no_telefono',
    'municipio',
    'ciudad',
    'calle',
    'numero'
];

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'id_tutor', 'id_tutor');
    }
}