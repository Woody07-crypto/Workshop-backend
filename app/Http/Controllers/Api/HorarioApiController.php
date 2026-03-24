<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HorarioApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Horario::with('medico:id,name,email')->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'medico_id' => ['required', 'integer', 'exists:users,id'],
            'inicio_at' => ['required', 'date'],
            'fin_at' => ['required', 'date', 'after:inicio_at'],
            'estado' => ['required', Rule::in(['disponible', 'ocupado', 'cancelado'])],
        ]);

        $horario = Horario::create($data);

        return response()->json($horario->load('medico:id,name,email'), 201);
    }

    public function show(Horario $horario): JsonResponse
    {
        return response()->json($horario->load('medico:id,name,email', 'cita'));
    }

    public function update(Request $request, Horario $horario): JsonResponse
    {
        $data = $request->validate([
            'medico_id' => ['sometimes', 'required', 'integer', 'exists:users,id'],
            'inicio_at' => ['sometimes', 'required', 'date'],
            'fin_at' => ['sometimes', 'required', 'date'],
            'estado' => ['sometimes', 'required', Rule::in(['disponible', 'ocupado', 'cancelado'])],
        ]);

        if (isset($data['inicio_at'], $data['fin_at']) && strtotime($data['fin_at']) <= strtotime($data['inicio_at'])) {
            return response()->json([
                'message' => 'Validation error.',
                'errors' => ['fin_at' => ['La fecha/hora de fin debe ser mayor a inicio_at.']],
            ], 422);
        }

        $horario->update($data);

        return response()->json($horario->fresh()->load('medico:id,name,email', 'cita'));
    }

    public function destroy(Horario $horario): JsonResponse
    {
        $horario->delete();

        return response()->json(status: 204);
    }
}
