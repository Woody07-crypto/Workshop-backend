<?php

namespace App\Filament\Admin\Resources\Pacientes;

use App\Filament\Admin\Resources\Pacientes\Pages\CreatePaciente;
use App\Filament\Admin\Resources\Pacientes\Pages\EditPaciente;
use App\Filament\Admin\Resources\Pacientes\Pages\ListPacientes;
use App\Filament\Admin\Resources\Pacientes\Schemas\PacienteForm;
use App\Filament\Admin\Resources\Pacientes\Tables\PacientesTable;
use App\Models\Paciente;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class PacienteResource extends Resource
{
    protected static ?string $model = Paciente::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Pacientes';
    protected static string|UnitEnum|null $navigationGroup = 'Clinica';
    protected static ?string $modelLabel = 'Paciente';
    protected static ?string $pluralModelLabel = 'Pacientes';

    public static function form(Schema $schema): Schema
    {
        return PacienteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PacientesTable::configure($table);
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
            'index' => ListPacientes::route('/'),
            'create' => CreatePaciente::route('/create'),
            'edit' => EditPaciente::route('/{record}/edit'),
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
