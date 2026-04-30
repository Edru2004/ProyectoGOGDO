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
        Schema::table('docente', function (Blueprint $table) {
            // Las columnas van AQUÍ adentro para que Laravel sepa a qué tabla pertenecen
            $table->string('two_factor_code')->nullable();
            $table->datetime('two_factor_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('docente', function (Blueprint $table) {
            // Esto sirve por si alguna vez quieres deshacer el cambio
            $table->dropColumn(['two_factor_code', 'two_factor_expires_at']);
        });
    }
};