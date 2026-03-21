<?php

namespace App\Filament\Resources\Pacientes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('apellido')
                    ->required()
                    ->maxLength(255),
                TextInput::make('dui')
                    ->label('DUI')
                    ->required()
                    ->maxLength(255),
                TextInput::make('telefono')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('direccion')
                    ->maxLength(255),
                DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de nacimiento'),
                Textarea::make('nota')
                    ->columnSpanFull(),
                Section::make('Expediente clínico')
                    ->schema([
                        TextInput::make('numero_expediente')
                            ->label('Número de expediente')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('antecedentes')
                            ->columnSpanFull(),
                        Textarea::make('alergias')
                            ->columnSpanFull(),
                        Textarea::make('observaciones')
                            ->label('Observaciones del expediente')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
