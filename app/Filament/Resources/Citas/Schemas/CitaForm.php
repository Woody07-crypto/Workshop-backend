<?php

namespace App\Filament\Resources\Citas\Schemas;

use App\Models\Horario;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CitaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('paciente_id')
                    ->label('Paciente')
                    ->relationship('paciente', 'nombre')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombre} {$record->apellido} ({$record->dui})")
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('medico_id')
                    ->label('Médico')
                    ->relationship(
                        'medico',
                        'name',
                        fn (Builder $query) => $query->where('role', 'medico'),
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('horario_id', null))
                    ->required(),
                Select::make('horario_id')
                    ->label('Horario')
                    ->options(function (Get $get, ?Model $record): array {
                        $medicoId = $get('medico_id');
                        if (! $medicoId) {
                            return [];
                        }

                        $query = Horario::query()
                            ->where('medico_id', $medicoId)
                            ->orderBy('inicio_at');

                        if ($record && isset($record->horario_id)) {
                            $query->where(function ($q) use ($record) {
                                $q->where('estado', 'disponible')
                                    ->orWhere('id', $record->horario_id);
                            });
                        } else {
                            $query->where('estado', 'disponible');
                        }

                        return $query->get()->mapWithKeys(
                            fn (Horario $h) => [
                                $h->id => $h->inicio_at->format('d/m/Y H:i').' → '.$h->fin_at->format('H:i'),
                            ]
                        )->all();
                    })
                    ->searchable()
                    ->preload()
                    ->disabled(fn (Get $get): bool => ! $get('medico_id'))
                    ->required(),
                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'confirmada' => 'Confirmada',
                        'cancelada' => 'Cancelada',
                        'completada' => 'Completada',
                    ])
                    ->required()
                    ->default('confirmada'),
                TextInput::make('motivo')
                    ->maxLength(255),
                Textarea::make('observaciones')
                    ->columnSpanFull(),
            ]);
    }
}
