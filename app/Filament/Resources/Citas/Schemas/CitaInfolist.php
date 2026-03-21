<?php

namespace App\Filament\Resources\Citas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CitaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('paciente_id')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($state, $record) => $record->paciente
                        ? "{$record->paciente->nombre} {$record->paciente->apellido}"
                        : '—'),
                TextEntry::make('medico.name')
                    ->label('Médico'),
                TextEntry::make('horario.inicio_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i'),
                TextEntry::make('horario.fin_at')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i'),
                TextEntry::make('estado')
                    ->badge(),
                TextEntry::make('motivo')
                    ->placeholder('—'),
                TextEntry::make('observaciones')
                    ->placeholder('—')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('—'),
            ]);
    }
}
