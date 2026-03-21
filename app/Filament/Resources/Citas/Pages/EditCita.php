<?php

namespace App\Filament\Resources\Citas\Pages;

use App\Filament\Resources\Citas\CitaResource;
use App\Models\Horario;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCita extends EditRecord
{
    protected static string $resource = CitaResource::class;

    protected ?int $previousHorarioId = null;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->previousHorarioId = $this->record->horario_id;

        return $data;
    }

    protected function afterSave(): void
    {
        if ($this->previousHorarioId === $this->record->horario_id) {
            return;
        }

        if ($this->previousHorarioId) {
            Horario::query()->whereKey($this->previousHorarioId)->update(['estado' => 'disponible']);
        }
        if ($this->record->horario_id) {
            Horario::query()->whereKey($this->record->horario_id)->update(['estado' => 'ocupado']);
        }
    }
}
