<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class FixedUsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@test.local'],
            [
                'name' => 'Admin Test',
                'role' => 'admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'medico@test.local'],
            [
                'name' => 'Medico Test',
                'role' => 'medico',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'asistente@test.local'],
            [
                'name' => 'Asistente Test',
                'role' => 'asistente',
                'password' => 'password',
                'email_verified_at' => now(),
            ]
        );
    }
}
