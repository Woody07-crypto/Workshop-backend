<?php

namespace App\Filament\Resources\Pacientes\Pages;

use App\Filament\Resources\Pacientes\PacienteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPaciente extends EditRecord
{
    protected static string $resource = PacienteResource::class;

    /**
     * @var array<string, mixed>
     */
    protected array $expedientePayload = [];

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
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $exp = $this->record->expedienteClinico;
        if ($exp) {
            $data['numero_expediente'] = $exp->numero_expediente;
            $data['antecedentes'] = $exp->antecedentes;
            $data['alergias'] = $exp->alergias;
            $data['observaciones'] = $exp->observaciones;
        }

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
    {
        $this->record->expedienteClinico()->updateOrCreate(
            ['paciente_id' => $this->record->id],
            $this->expedientePayload
        );
    }
}
