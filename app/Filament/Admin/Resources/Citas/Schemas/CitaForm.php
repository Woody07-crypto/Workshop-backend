<?php

namespace App\Filament\Admin\Resources\Citas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CitaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('paciente_id')
                    ->relationship('paciente', 'nombre')
                    ->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->nombre} {$record->apellido}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('medico_id')
                    ->relationship(
                        name: 'medico',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('role', 'medico'),
                    )
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('horario_id')
                    ->relationship(
                        name: 'horario',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn (Builder $query) => $query->where('estado', 'disponible'),
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record): string => "#{$record->id} | {$record->inicio_at} - {$record->fin_at}")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('estado')
                    ->required()
                    ->options([
                        'confirmada' => 'Confirmada',
                        'cancelada' => 'Cancelada',
                        'completada' => 'Completada',
                    ])
                    ->default('confirmada'),
                Textarea::make('motivo'),
                Textarea::make('observaciones')
                    ->columnSpanFull(),
            ]);
    }
}
