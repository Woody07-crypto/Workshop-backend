<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        
        $appointment = Appointment::create($request->validated());

        return response()->json([
            'message' => 'Cita creada exitosamente',
            'data' => $appointment
        ], 201);
    }
}