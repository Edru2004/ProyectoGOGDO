<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('Estudiante', function (Blueprint $table) {
        $table->id('id_estudiante'); // Tu PK
        $table->string('nombre', 50);
        $table->string('apellido_p', 50);
        $table->string('apellido_m', 50)->nullable();
        $table->string('curp', 18)->unique()->nullable();
        $table->string('email', 150)->unique();
        $table->string('password', 255);
        $table->enum('sexo', ['Mujer', 'Hombre', 'Otro'])->nullable();
        $table->date('fecha_nac')->nullable();
        $table->string('no_telefono', 15)->nullable();
        $table->string('colonia', 100)->nullable();
        $table->string('calle', 100)->nullable();
        $table->string('numero', 20)->nullable();
        $table->integer('id_tutor')->nullable(); 
        // No ponemos la FK de tutor aún para que no te de error si no tienes la tabla Tutor
        $table->timestamps(); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
