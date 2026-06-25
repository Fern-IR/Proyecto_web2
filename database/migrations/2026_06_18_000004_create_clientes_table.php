<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_cliente');
            $table->unsignedBigInteger('id_operador');
            $table->string('nombres', 150);
            $table->string('telefono', 30)->nullable();
            $table->string('correo', 150)->nullable();
            $table->string('nacionalidad', 80)->nullable();
            $table->timestamps();

            $table->foreign('id_operador')
                ->references('id_operador')
                ->on('operadores')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
