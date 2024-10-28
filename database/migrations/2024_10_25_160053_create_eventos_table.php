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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('id_evento');
            $table->foreignId('id_miembroprincipal')->nullable()->constrained('miembrosprincipales','id_miembroprincipal')->onDelete('cascade'); // Relación con la tabla 'MiembrosPrimarios'
            $table->enum('tipo_apoyo', [
                'APOYO JURIDICO', 
                'APOYO LABORAL', 
                'APOYO SALUD', 
                'APOYO ECONOMICO'
            ]);
            $table->enum('estado_evento', [
                'PROGRAMADA', 
                'SUSPENDIDA', 
                'REALIZADA'
            ]);
            $table->date('fecha');
            $table->time('hora');
            $table->text('descripcion')->nullable();
            $table->foreignId('id_user')->constrained('users'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
