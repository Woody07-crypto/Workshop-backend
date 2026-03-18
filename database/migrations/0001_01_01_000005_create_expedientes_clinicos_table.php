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
        Schema::create('expedientes_clinicos', function (Blueprint $table) {
            $table->id();

            // 1:1 con Paciente
            $table->foreignId('paciente_id')->constrained('pacientes')->unique()->cascadeOnDelete();

            $table->string('numero_expediente')->unique();
            $table->text('antecedentes')->nullable();
            $table->text('alergias')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes_clinicos');
    }
};

