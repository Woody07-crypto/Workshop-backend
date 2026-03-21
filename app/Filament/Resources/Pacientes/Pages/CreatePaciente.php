<?php

namespace App\Filament\Resources\Pacientes\Pages;

use App\Filament\Resources\Pacientes\PacienteResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaciente extends CreateRecord
{
    protected static string $resource = PacienteResource::class;

    /**
     * @var array<string, mixed>
     */
    protected array $expedientePayload = [];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->expedientePayload = [
            'numero_expediente' => $data['numero_expediente'],
            'antecedentes' => $data['antecedentes'] ?? null,
            'alergias' => $data['alergias'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
        ];

        unset(
            $data['numero_expediente'],
            $data['antecedentes'],
            $data['alergias'],
            $data['observaciones'],
        );

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->expedienteClinico()->create($this->expedientePayload);
    }
}
