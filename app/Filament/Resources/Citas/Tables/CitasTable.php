<?php

namespace App\Filament\Resources\Citas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CitasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['paciente', 'medico', 'horario']))
            ->columns([
                TextColumn::make('paciente.apellido')
                    ->label('Paciente')
                    ->formatStateUsing(fn ($record) => $record->paciente
                        ? "{$record->paciente->nombre} {$record->paciente->apellido}"
                        : '—')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('paciente', function (Builder $q) use ($search) {
                            $q->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%")
                                ->orWhere('dui', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('medico.name')
                    ->label('Médico')
                    ->searchable(),
                TextColumn::make('horario.inicio_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('horario.fin_at')
                    ->label('Fin')
                    ->dateTime('H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('estado')
                    ->badge()
                    ->searchable(),
                TextColumn::make('motivo')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('id', 'desc');
    }
}
