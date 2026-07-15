<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // FK: cada usuario del sistema (empleado) pertenece a un departamento/rol.
            $table->foreignId('department_id')
                ->nullable()
                ->after('password')
                ->constrained('departments')
                ->nullOnDelete();

            // Baja lógica del usuario (en vez de eliminarlo físicamente).
            $table->boolean('active')->default(true)->after('department_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['department_id', 'active']);
        });
    }
};
