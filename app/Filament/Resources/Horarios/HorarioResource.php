<?php

namespace App\Filament\Resources\Horarios;

use App\Filament\Resources\Horarios\Pages\CreateHorario;
use App\Filament\Resources\Horarios\Pages\EditHorario;
use App\Filament\Resources\Horarios\Pages\ListHorarios;
use App\Filament\Resources\Horarios\Pages\ViewHorario;
use App\Filament\Resources\Horarios\Schemas\HorarioForm;
use App\Filament\Resources\Horarios\Schemas\HorarioInfolist;
use App\Filament\Resources\Horarios\Tables\HorariosTable;
use App\Models\Horario;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class HorarioResource extends Resource
{
    protected static ?string $model = Horario::class;

    protected static string|UnitEnum|null $navigationGroup = 'Gestión clínica';

    protected static ?string $modelLabel = 'horario';

    protected static ?string $pluralModelLabel = 'horarios';

    protected static ?string $navigationLabel = 'Horarios';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return HorarioForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HorarioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HorariosTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();
        if ($user?->isMedico()) {
            $query->where('medico_id', $user->id);
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHorarios::route('/'),
            'create' => CreateHorario::route('/create'),
            'view' => ViewHorario::route('/{record}'),
            'edit' => EditHorario::route('/{record}/edit'),
        ];
    }
}
