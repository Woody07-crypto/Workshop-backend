<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin: el único que gestiona usuarios (regla de negocio; la tabla solo guarda el rol).
        User::factory()->admin()->count(1)->create();

        // Médicos: atienden citas y consultan expedientes.
        User::factory()->medico()->count(5)->create();

        // Asistentes: gestionan agenda de múltiples médicos (solo para representar roles).
        User::factory()->asistente()->count(2)->create();
    }
}

