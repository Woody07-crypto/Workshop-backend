<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use App\Models\Paciente;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ClinicalStatsOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $heading = 'Resumen';

    protected function getStats(): array
    {
        $user = Auth::user();

        $citasHoy = Cita::query()
            ->when($user?->isMedico(), fn ($q) => $q->where('medico_id', $user->id))
            ->whereHas('horario', fn ($q) => $q->whereDate('inicio_at', today()))
            ->count();

        return [
            Stat::make('Pacientes', Paciente::query()->count()),
            Stat::make('Citas hoy', $citasHoy),
        ];
    }
}
