<?php

namespace App\Filament\Admin\Resources\Citas\Pages;

use App\Filament\Admin\Resources\Citas\CitaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCita extends EditRecord
{
    protected static string $resource = CitaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
