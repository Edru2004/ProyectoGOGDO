<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupos extends Model
{
    use HasFactory;

    protected $table = 'grupos';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;

// app/Models/Grupos.php
protected $fillable = ['nombre_grupo', 'id_semestre']; // <-- Agrega id_semestre aquí
    public function semestre()
{
    // Un grupo pertenece a un semestre
    return $this->belongsTo(Semestre::class, 'id_semestre', 'id_semestre');
}


}