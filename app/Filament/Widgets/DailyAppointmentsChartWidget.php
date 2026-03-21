<?php

namespace App\Filament\Widgets;

use App\Models\Cita;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class DailyAppointmentsChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Citas por día (últimos 14 días)';

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $counts = [];

        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d/m');

            $query = Cita::query()->whereHas('horario', fn ($q) => $q->whereDate('inicio_at', $day));

            if (Auth::user()?->isMedico()) {
                $query->where('medico_id', Auth::id());
            }

            $counts[] = $query->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Citas',
                    'data' => $counts,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
