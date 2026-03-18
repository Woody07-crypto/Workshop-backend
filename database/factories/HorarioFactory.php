<?php

namespace Database\Factories;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Horario>
 */
class HorarioFactory extends Factory
{
    protected $model = Horario::class;

    public function definition(): array
    {
        $medico = User::query()->where('role', 'medico')->inRandomOrder()->first();

        $inicio = $this->faker->dateTimeBetween('tomorrow', '+30 days');
        $fin = (clone $inicio)->modify('+30 minutes');

        return [
            'medico_id' => $medico?->id,
            'inicio_at' => $inicio,
            'fin_at' => $fin,
            'estado' => 'disponible',
        ];
    }
}

