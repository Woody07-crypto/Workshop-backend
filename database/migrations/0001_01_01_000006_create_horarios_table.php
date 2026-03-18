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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('medico_id')->constrained('users')->cascadeOnDelete();

            $table->timestamp('inicio_at');
            $table->timestamp('fin_at');

            $table->string('estado')->default('disponible')->index();

            $table->timestamps();

            $table->index(['medico_id', 'inicio_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};

