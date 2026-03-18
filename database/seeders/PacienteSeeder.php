<?php

namespace Database\Seeders;

use App\Models\ExpedienteClinico;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::factory()->count(20)->create();

        // 1:1 Expediente Clínico por Paciente
        $pacientes->each(function (Paciente $paciente) {
            ExpedienteClinico::factory()->for($paciente)->create([
                // numero_expediente y campos clínicos se generan con la factory
            ]);
        });
    }
}

