<?php

namespace App\Filament\Admin\Resources\Citas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('paciente.nombre')
                    ->label('Paciente')
                    ->searchable(),
                TextColumn::make('medico.name')
                    ->label('Medico')
                    ->searchable(),
                TextColumn::make('horario.inicio_at')
                    ->label('Horario')
                    ->dateTime()
                    ->searchable(),
                TextColumn::make('estado')
                    ->badge()
                    ->searchable(),
                TextColumn::make('motivo')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
