<?php

namespace App\Filament\Resources\Horarios\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class HorarioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('medico_id')
                    ->label('Médico')
                    ->relationship(
                        'medico',
                        'name',
                        fn (Builder $query) => $query->where('role', 'medico'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                DateTimePicker::make('inicio_at')
                    ->label('Inicio')
                    ->required(),
                DateTimePicker::make('fin_at')
                    ->label('Fin')
                    ->required(),
                Select::make('estado')
                    ->options([
                        'disponible' => 'Disponible',
                        'ocupado' => 'Ocupado',
                    ])
                    ->required()
                    ->default('disponible'),
            ]);
    }
}
