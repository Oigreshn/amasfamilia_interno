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
        Schema::create('miembrosprincipales', function (Blueprint $table) {
            $table->id('id_miembroprincipal');
            $table->string('nombrecompleto');
            $table->string('documento')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->foreignId('id_pais')->nullable()->constrained('paises','id_pais'); // Relación con la tabla 'paises'
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo', ['MASCULINO', 'FEMENINO', 'OTRO', 'NO ESPECIFICADO'])->nullable();
            $table->foreignId('id_estadocivil')->nullable()->constrained('estadocivil','id_estadocivil'); // Relación con la tabla 'estadocivil'
            $table->foreignId('id_estadomi')->nullable()->constrained('estadomiembros','id_estadomi'); // Relación con la tabla 'estadomiembros'
            $table->integer('miembros_hogar')->nullable();
            $table->integer('hijos')->nullable();
            $table->integer('hijos_menores')->nullable();
            $table->foreignId('id_permisore')->nullable()->constrained('permisoresidencia','id_permisore'); // Relación con 'permisoresidencia'
            $table->foreignId('id_permisotra')->nullable()->constrained('permisotrabajo','id_permisotra'); // Relación con 'permisotrabajo'
            $table->foreignId('id_estadola')->nullable()->constrained('estadoslaborales','id_estadola'); // Relación con 'estadoslaborales'
            $table->foreignId('id_red')->nullable()->constrained('redescercanas','id_red'); // Relación con 'redescercanas'
            $table->date('inicio_asignacion')->nullable();
            $table->date('fin_asignacion')->nullable();
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
        Schema::dropIfExists('miembrosprincipales');
    }
};
