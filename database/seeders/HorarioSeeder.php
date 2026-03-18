<?php

namespace Database\Seeders;

use App\Models\Horario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    public function run(): void
    {
        $medicos = User::query()->where('role', 'medico')->get();

        $diasHorizonte = 10;
        $horaSlots = ['09:00', '11:00', '15:00']; // 3 slots por día
        $duracionMinutos = 30;

        foreach ($medicos as $medico) {
            for ($d = 1; $d <= $diasHorizonte; $d++) {
                foreach ($horaSlots as $horaSlot) {
                    [$h, $m] = explode(':', $horaSlot);
                    $inicio = Carbon::now()->addDays($d)->setTime((int) $h, (int) $m);
                    $fin = (clone $inicio)->addMinutes($duracionMinutos);

                    Horario::factory()->create([
                        'medico_id' => $medico->id,
                        'inicio_at' => $inicio,
                        'fin_at' => $fin,
                        'estado' => 'disponible',
                    ]);
                }
            }
        }
    }
}

