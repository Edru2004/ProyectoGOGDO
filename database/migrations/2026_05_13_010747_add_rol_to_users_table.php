<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Verifica si la columna no existe antes de crearla para evitar errores
            if (!Schema::hasColumn('users', 'rol')) {
                $table->string('rol')->default('usuario')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Es buena práctica eliminarla en el 'down' por si haces un migrate:rollback
            if (Schema::hasColumn('users', 'rol')) {
                $table->dropColumn('rol');
            }
        });
    }
};