<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_comprobante');
            $table->unsignedBigInteger('id_pago');
            $table->string('ruta_archivo', 255);
            $table->timestamp('fecha_subida')->useCurrent();
            $table->timestamps();

            $table->foreign('id_pago')
                ->references('id_pago')
                ->on('pagos')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
