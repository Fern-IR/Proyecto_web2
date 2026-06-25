<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paquetes_turisticos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_paquete');
            $table->unsignedBigInteger('id_operador');
            $table->string('nombre_paquete', 150);
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('cupo_maximo');
            $table->timestamps();

            $table->foreign('id_operador')
                ->references('id_operador')
                ->on('operadores')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes_turisticos');
    }
};
