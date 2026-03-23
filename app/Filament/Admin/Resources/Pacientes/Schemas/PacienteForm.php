<?php

namespace App\Filament\Admin\Resources\Pacientes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PacienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del paciente')
                    ->schema([
                        TextInput::make('nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('apellido')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('dui')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('telefono')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('direccion')
                            ->maxLength(255),
                        DatePicker::make('fecha_nacimiento'),
                        Textarea::make('nota')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Expediente clinico')
                    ->relationship('expedienteClinico')
                    ->schema([
                        TextInput::make('numero_expediente')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Textarea::make('antecedentes')
                            ->columnSpanFull(),
                        Textarea::make('alergias')
                            ->columnSpanFull(),
                        Textarea::make('observaciones')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
