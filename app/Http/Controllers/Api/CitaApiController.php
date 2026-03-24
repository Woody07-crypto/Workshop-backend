<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Horario;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CitaApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            Cita::with(['paciente:id,nombre,apellido', 'medico:id,name,email', 'horario:id,inicio_at,fin_at,estado'])
                ->latest()
                ->get()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'paciente_id' => ['required', 'integer', 'exists:pacientes,id'],
            'medico_id' => ['required', 'integer', 'exists:users,id'],
            'horario_id' => ['required', 'integer', 'exists:horarios,id', 'unique:citas,horario_id'],
            'estado' => ['required', Rule::in(['confirmada', 'cancelada', 'completada'])],
            'motivo' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $horario = Horario::findOrFail($data['horario_id']);

        if ($horario->medico_id !== $data['medico_id']) {
            return response()->json([
                'message' => 'El medico_id no coincide con el medico asignado al horario.',
            ], 422);
        }

        if ($horario->estado !== 'disponible') {
            return response()->json([
                'message' => 'El horario no esta disponible.',
            ], 422);
        }

        $cita = Cita::create($data);
        $horario->update(['estado' => 'ocupado']);

        return response()->json($cita->load(['paciente', 'medico', 'horario']), 201);
    }

    public function show(Cita $cita): JsonResponse
    {
        return response()->json($cita->load(['paciente', 'medico', 'horario']));
    }

    public function update(Request $request, Cita $cita): JsonResponse
    {
        $data = $request->validate([
            'estado' => ['sometimes', 'required', Rule::in(['confirmada', 'cancelada', 'completada'])],
            'motivo' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
        ]);

        $cita->update($data);

        return response()->json($cita->fresh()->load(['paciente', 'medico', 'horario']));
    }

    public function destroy(Cita $cita): JsonResponse
    {
        $cita->delete();

        return response()->json(status: 204);
    }
}
