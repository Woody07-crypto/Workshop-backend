namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeekIso; // 1 = Lunes, 7 = Domingo

        // 1. Validar que el médico trabaje ese día y en ese rango de horas
        $isWorking = DB::table('doctor_schedules')
            ->where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->where('start_time', '<=', $request->start_time)
            ->where('end_time', '>=', $request->end_time)
            ->exists();

        if (!$isWorking) {
            return response()->json([
                'error' => 'El médico no atiende en ese día u horario o no existe su registro.'
            ], 422);
        }

        // 2. Validar que la nueva cita NO choque con una cita ya existente
        $hasConflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('date', $request->date)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($hasConflict) {
            return response()->json([
                'error' => 'El horario choca con una cita existente del médico.'
            ], 409);
        }

        // 3. Crear la cita
        $appointment = Appointment::create($request->validated());

        return response()->json([
            'message' => 'Cita médica creada exitosamente.',
            'data' => $appointment
        ], 201);
    }
}