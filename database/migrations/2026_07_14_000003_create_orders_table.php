<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Número de factura consecutivo (visible al público para consultar estatus).
            $table->string('invoice_number', 30)->unique();

            $table->string('customer_name');

            // Número de cliente asignado arbitrariamente.
            $table->string('customer_number', 30)->index();

            // Datos fiscales del cliente (texto libre: razón social, RFC, dirección fiscal).
            $table->text('fiscal_data');

            $table->dateTime('order_datetime');
            $table->string('delivery_address');
            $table->text('notes')->nullable();

            $table->enum('status', [
                'ordered',
                'in_process',
                'in_route',
                'delivered',
            ])->default('ordered');

            $table->timestamp('status_changed_at')->nullable();

            // FK: vendedor que capturó el pedido.
            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            // FK: último usuario que modificó el pedido.
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            // Baja lógica: al tener valor, el pedido se considera "archivado".
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
