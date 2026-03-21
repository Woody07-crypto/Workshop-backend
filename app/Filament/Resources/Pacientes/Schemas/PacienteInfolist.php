<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PacienteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del paciente')
                    ->schema([
                        TextEntry::make('nombre'),
                        TextEntry::make('apellido'),
                        TextEntry::make('dui')
                            ->label('DUI'),
                        TextEntry::make('telefono')
                            ->placeholder('—'),
                        TextEntry::make('direccion')
                            ->placeholder('—'),
                        TextEntry::make('fecha_nacimiento')
                            ->date()
                            ->placeholder('—'),
                        TextEntry::make('nota')
                            ->placeholder('—')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Fecha de registro')
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Expediente clínico')
                    ->schema([
                        TextEntry::make('expedienteClinico.numero_expediente')
                            ->label('Número de expediente')
                            ->placeholder('—'),
                        TextEntry::make('expedienteClinico.antecedentes')
                            ->placeholder('—')
                            ->columnSpanFull(),
                        TextEntry::make('expedienteClinico.alergias')
                            ->placeholder('—')
                            ->columnSpanFull(),
                        TextEntry::make('expedienteClinico.observaciones')
                            ->label('Observaciones')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record->expedienteClinico !== null),
            ]);
    }
}
