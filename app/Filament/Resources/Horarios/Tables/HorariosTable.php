<?php

namespace App\Filament\Resources\Horarios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HorariosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('medico'))
            ->columns([
                TextColumn::make('medico.name')
                    ->label('Médico')
                    ->searchable(),
                TextColumn::make('inicio_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('fin_at')
                    ->label('Fin')
                    ->dateTime('H:i')
                    ->sortable(),
                TextColumn::make('estado')
                    ->badge()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('medico_id')
                    ->label('Médico')
                    ->relationship('medico', 'name', fn (Builder $query) => $query->where('role', 'medico'))
                    ->searchable()
                    ->preload()
                    ->visible(fn (): bool => auth()->user()?->isAdmin() || auth()->user()?->isAsistente()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('inicio_at');
    }
}
