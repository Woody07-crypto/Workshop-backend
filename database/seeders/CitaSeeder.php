<?php

namespace Database\Seeders;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Paciente;
use Illuminate\Database\Seeder;

class CitaSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = Paciente::query()->get();
        $horariosDisponibles = Horario::query()
            ->where('estado', 'disponible')
            ->orderBy('inicio_at')
            ->get();

        if ($pacientes->isEmpty() || $horariosDisponibles->isEmpty()) {
            return;
        }

        $cantidadCitas = min(30, $horariosDisponibles->count());

        for ($i = 0; $i < $cantidadCitas; $i++) {
            $horario = $horariosDisponibles[$i];
            $paciente = $pacientes->random();

            Cita::factory()->create([
                'paciente_id' => $paciente->id,
                'medico_id' => $horario->medico_id,
                'horario_id' => $horario->id,
                'estado' => 'confirmada',
            ]);

            $horario->estado = 'ocupado';
            $horario->save();
        }
    }
}

