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
        Schema::create('derivaciones', function (Blueprint $table) {
            $table->id('id_derivacion');
            $table->foreignId('id_miembroprincipal')->nullable()->constrained('miembrosprincipales','id_miembroprincipal')->onDelete('cascade'); // Relación con la tabla 'MiembrosPrimarios'
            $table->foreignId('id_entidad')->nullable()->constrained('entidades','id_entidad'); // Relación con la tabla 'Entidades'
            $table->integer('cantidad')->nullable();
            $table->foreignId('id_tipotarjeta')->nullable()->constrained('tipotarjetas','id_tipotarjeta'); // Relación con la tabla 'Tipotarjetas'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('derivaciones');
    }
};
