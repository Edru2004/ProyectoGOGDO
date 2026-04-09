<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model {
    use HasFactory;
    protected $table = 'docente'; 
    protected $primaryKey = 'id_docente';
    public $timestamps = false; 

  protected $fillable = [
    'nombre', 'apellido_p', 'apellido_m', 'curp', 'email', 'password', 
    'telefono', 'municipio', 'localidad', 'calle', 'numero', 'estudios', 'num_cedula_prof', 'rfc'
];

    // Relación con las asignaciones de clases
   // Dentro de app/Models/Docente.php

public function asignaciones()
{
    return $this->hasMany(Asignaciones::class, 'id_docente', 'id_docente');
}
}