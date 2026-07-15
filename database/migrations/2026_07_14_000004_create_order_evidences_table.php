<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_evidences', function (Blueprint $table) {
            $table->id();

            // FK: pedido al que pertenece la evidencia.
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            // 'route' = foto de la unidad cargada, 'delivered' = foto de entrega.
            $table->enum('type', ['route', 'delivered']);

            $table->string('photo_path');

            // FK: usuario (departamento Route) que subió la foto.
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_evidences');
    }
};
