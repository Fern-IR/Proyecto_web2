<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilidad', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_disponibilidad');
            $table->unsignedBigInteger('id_paquete');
            $table->date('fecha');
            $table->unsignedInteger('cupos_disponibles');
            $table->timestamps();

            $table->foreign('id_paquete')
                ->references('id_paquete')
                ->on('paquetes_turisticos')
                ->cascadeOnDelete();

            $table->unique(['id_paquete', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilidad');
    }
};
