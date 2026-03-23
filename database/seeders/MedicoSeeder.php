<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MedicoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin principal para acceso al panel.
        User::query()->updateOrCreate(
            ['email' => 'admin@test.local'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'medico@test.local'],
            [
                'name' => 'Medico Demo',
                'role' => 'medico',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'asistente@test.local'],
            [
                'name' => 'Asistente Demo',
                'role' => 'asistente',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        // Médicos: atienden citas y consultan expedientes.
        User::factory()->medico()->count(5)->create();

        // Asistentes: gestionan agenda de múltiples médicos (solo para representar roles).
        User::factory()->asistente()->count(2)->create();
    }
}

