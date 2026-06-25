<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paquetes_turisticos', function (Blueprint $table) {
            $table->string('destino', 100)->nullable()->after('nombre_paquete');
            $table->string('pais', 80)->nullable()->after('destino');
            $table->unsignedSmallInteger('duracion_dias')->nullable()->after('pais');
            $table->text('descripcion')->nullable()->after('duracion_dias');
            $table->string('tipo_viaje', 50)->nullable()->after('descripcion');
            $table->string('imagen_url', 500)->nullable()->after('tipo_viaje');
            $table->enum('estado', ['activo', 'inactivo', 'agotado'])->default('activo')->after('cupo_maximo');
        });
    }

    public function down(): void
    {
        Schema::table('paquetes_turisticos', function (Blueprint $table) {
            $table->dropColumn([
                'destino', 'pais', 'duracion_dias', 'descripcion',
                'tipo_viaje', 'imagen_url', 'estado',
            ]);
        });
    }
};
