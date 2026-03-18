<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cita>
 */
class CitaFactory extends Factory
{
    protected $model = Cita::class;

    public function definition(): array
    {
        $horario = Horario::query()->inRandomOrder()->first();
        $paciente = Paciente::query()->inRandomOrder()->first();

        return [
            'paciente_id' => $paciente?->id,
            'medico_id' => $horario?->medico_id,
            'horario_id' => $horario?->id,
            'estado' => 'confirmada',
            'motivo' => $this->faker->randomElement([
                'Control general',
                'Revisión',
                'Dolor persistente',
                'Consulta rutinaria',
                'Seguimiento',
            ]),
            'observaciones' => $this->faker->optional()->sentence(10),
        ];
    }
}

