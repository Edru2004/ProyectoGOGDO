<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model {
    protected $table = 'Semestre';
    protected $primaryKey = 'id_semestre';
    public $timestamps = false;

    // Lógica automática: Determina el año según el semestre
    public function getAnioEscolarAttribute() {
        if ($this->id_semestre <= 2) return "1er Año";
        if ($this->id_semestre <= 4) return "2do Año";
        return "3er Año";
    }
}