<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment; 
use Carbon\Carbon;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    
    }

    public function rules(): array
    {
        return [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'appointment_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $this->validateDuplicates($value, $fail);
                },
            ],
        ];
    }

    protected function validateDuplicates($requestedDate, $fail)
    {
        $doctorId = $this->input('doctor_id');
        $date = Carbon::parse($requestedDate);

       
        $isDuplicate = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $date->format('Y-m-d H:i:s'))
            ->exists();

        if ($isDuplicate) {
            $fail('El médico ya tiene una cita agendada en este bloque de tiempo.');
        }
    }
}