<?php

namespace App\Filament\Resources\Horarios\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HorarioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('medico.name')
                    ->label('Medico'),
                TextEntry::make('inicio_at')
                    ->dateTime(),
                TextEntry::make('fin_at')
                    ->dateTime(),
                TextEntry::make('estado'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
