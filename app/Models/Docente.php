<?php

namespace App\Models;

// Importante: Cambiamos Model por Authenticatable para el login
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Docente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'docente';
    protected $primaryKey = 'id_docente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'curp',
        'email',
        'password',
        'telefono',
        'municipio',
        'localidad',
        'calle',
        'numero',
        'estudios',
        'num_cedula_prof',
        'rfc',
        'two_factor_code',
    'two_factor_expires_at',
    ];

    /**
     * Ocultar el password para que no salga en consultas JSON
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relación con las asignaciones de clases
     */
    public function asignaciones()
    {
        // Asegúrate de que tu modelo se llame Asignacion (en singular) 
        // o cámbialo aquí a Asignaciones si así lo nombraste.
        return $this->hasMany(Asignaciones::class, 'id_docente', 'id_docente');
    }
   // En app/Models/Docente.php y app/Models/Estudiante.php

public function generateTwoFactorCode()
{
    $this->timestamps = false; // Para que no se mueva la fecha de 'updated_at'
    $this->two_factor_code = rand(100000, 999999);
    $this->save();
}

public function resetTwoFactorCode()
{
    $this->timestamps = false;
    $this->two_factor_code = null;
    $this->save();
}
}
