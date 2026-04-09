<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materia';
    protected $primaryKey = 'id_materia';
    public $timestamps = false;

    protected $fillable = ['nombre_materia', 'no_horas', 'creditos', 'id_semestre'];
}