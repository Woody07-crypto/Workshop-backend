<?php

namespace Database\Factories;

use App\Models\ExpedienteClinico;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExpedienteClinico>
 */
class ExpedienteClinicoFactory extends Factory
{
    protected $model = ExpedienteClinico::class;

    public function definition(): array
    {
        $paciente = Paciente::query()->inRandomOrder()->first();

        return [
            'numero_expediente' => $this->faker->unique()->numerify('########'),
            'antecedentes' => $this->faker->optional()->paragraph(2),
            'alergias' => $this->faker->optional()->sentence(6),
            'observaciones' => $this->faker->optional()->paragraph(2),
            'paciente_id' => $paciente?->id,
        ];
    }
}

