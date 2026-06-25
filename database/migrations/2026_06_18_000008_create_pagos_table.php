<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_pago');
            $table->unsignedBigInteger('id_reserva');
            $table->string('metodo_pago', 50);
            $table->decimal('monto', 10, 2);
            $table->enum('estado_pago', ['pendiente', 'pagado', 'rechazado'])->default('pendiente');
            $table->timestamps();

            $table->foreign('id_reserva')
                ->references('id_reserva')
                ->on('reservas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
