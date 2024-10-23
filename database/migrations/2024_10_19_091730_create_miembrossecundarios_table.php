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
        Schema::create('miembrossecundarios', function (Blueprint $table) {
            $table->id('id_miembrosecundario');
            $table->string('nombrecompleto');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('documento')->nullable();
            $table->foreignId('id_miembroprincipal')->nullable()->constrained('miembrosprincipales','id_miembroprincipal'); // Relación con la tabla 'MiembrosPrimarios'
            $table->foreignId('id_parentesco')->nullable()->constrained('parentescos','id_parentesco'); // Relación con la tabla 'Parentescos'
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('codigointerno')->nullable();
			$table->foreignId('id_user')->constrained('users'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miembrossecundarios');
    }
};
