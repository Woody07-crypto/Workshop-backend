<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExpedienteClinico;
use App\Models\Paciente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PacienteApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Paciente::with('expedienteClinico')->latest()->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'dui' => ['required', 'string', 'max:50', 'unique:pacientes,dui'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'nota' => ['nullable', 'string'],
            'expediente' => ['nullable', 'array'],
            'expediente.numero_expediente' => ['required_with:expediente', 'string', 'max:255', 'unique:expedientes_clinicos,numero_expediente'],
            'expediente.antecedentes' => ['nullable', 'string'],
            'expediente.alergias' => ['nullable', 'string'],
            'expediente.observaciones' => ['nullable', 'string'],
        ]);

        $paciente = Paciente::create($data);

        if (isset($data['expediente'])) {
            ExpedienteClinico::create([
                'paciente_id' => $paciente->id,
                ...$data['expediente'],
            ]);
        }

        return response()->json($paciente->load('expedienteClinico'), 201);
    }

    public function show(Paciente $paciente): JsonResponse
    {
        return response()->json($paciente->load('expedienteClinico'));
    }

    public function update(Request $request, Paciente $paciente): JsonResponse
    {
        $data = $request->validate([
            'nombre' => ['sometimes', 'required', 'string', 'max:255'],
            'apellido' => ['sometimes', 'required', 'string', 'max:255'],
            'dui' => ['sometimes', 'required', 'string', 'max:50', Rule::unique('pacientes', 'dui')->ignore($paciente->id)],
            'telefono' => ['nullable', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'nota' => ['nullable', 'string'],
        ]);

        $paciente->update($data);

        return response()->json($paciente->fresh()->load('expedienteClinico'));
    }

    public function destroy(Paciente $paciente): JsonResponse
    {
        $paciente->delete();

        return response()->json(status: 204);
    }
}
