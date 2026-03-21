<?php

namespace App\Filament\Resources\Citas\Pages;

use App\Filament\Resources\Citas\CitaResource;
use App\Models\Horario;
use Filament\Resources\Pages\CreateRecord;

class CreateCita extends CreateRecord
{
    protected static string $resource = CitaResource::class;

    protected function afterCreate(): void
    {
        if ($this->record->horario_id) {
            Horario::query()->whereKey($this->record->horario_id)->update(['estado' => 'ocupado']);
        }
    }
}
