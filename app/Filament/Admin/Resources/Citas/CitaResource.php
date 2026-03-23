<?php

namespace App\Filament\Admin\Resources\Citas;

use App\Filament\Admin\Resources\Citas\Pages\CreateCita;
use App\Filament\Admin\Resources\Citas\Pages\EditCita;
use App\Filament\Admin\Resources\Citas\Pages\ListCitas;
use App\Filament\Admin\Resources\Citas\Schemas\CitaForm;
use App\Filament\Admin\Resources\Citas\Tables\CitasTable;
use App\Models\Cita;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class CitaResource extends Resource
{
    protected static ?string $model = Cita::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Citas';
    protected static string|UnitEnum|null $navigationGroup = 'Clinica';
    protected static ?string $modelLabel = 'Cita';
    protected static ?string $pluralModelLabel = 'Citas';

    public static function form(Schema $schema): Schema
    {
        return CitaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CitasTable::configure($table);
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
            'index' => ListCitas::route('/'),
            'create' => CreateCita::route('/create'),
            'edit' => EditCita::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return Filament::auth()->check();
    }

    public static function canCreate(): bool
    {
        return Filament::auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        return Filament::auth()->check();
    }

    public static function canDelete(Model $record): bool
    {
        return Filament::auth()->user()?->isAdmin() ?? false;
    }
}
