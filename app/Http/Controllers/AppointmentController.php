<?php

namespace App\Http\Controllers;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Promotion;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

use App\Models\Appointment;
use App\Models\Horarios;
use App\Models\CancelledAppointment;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if ($role == 'admin') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->paginate(10);

        } elseif ($role == 'empleado') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('employer_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('employer_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('employer_id', auth()->id())
                ->paginate(10);

        } elseif ($role == 'paciente') {
            $pendingAppointments = Appointment::where('status', 'Reservada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')
                ->where('patient_id', auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida', 'Cancelada'])
                ->where('patient_id', auth()->id())
                ->paginate(10);
        }


        return view('appointments.index',
            compact(
                'pendingAppointments', 'confirmedAppointments', 'oldAppointments',
                'role'
            )
        );
    }

    public function create(HorarioServiceInterface $horarioService)
    {
        // Obtener todas las promociones disponibles
        $promotions = Promotion::all();

        // Verificar si hay un 'promotion_id' antiguo en la solicitud
        $promotionId = old('promotion_id');

        $horarios = Horarios::where('active', true)->get();
        $scheduledDate = old('scheduled_date', date('Y-m-d'));

        $intervals = [];
        foreach ($horarios as $horario) {
            if ($horario->day == date('N')) {
                $intervals = array_merge($intervals, $horarioService->getAvailableIntervals($scheduledDate, $horario->user_id));
            }
        }

        return view('appointments.create', compact('promotions', 'intervals', 'scheduledDate'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Validar si es un empleado o un paciente
        if ($user->role == 'empleado') {
            $employerId = $user->id; // Usar el ID del empleado autenticado
            $patientId = null; // No se selecciona un paciente en este caso
        } elseif ($user->role == 'paciente') {
            $employerId = 2; // Valor predeterminado para administrador
            $patientId = $user->id; // Usar el ID del paciente autenticado
        } else {
            $employerId = null;
            $patientId = null;
        }

        $validatedData = $request->validate([
            'employer_id' => 'nullable|exists:users,id',
            'patient_id' => 'nullable|exists:users,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'promotion_id' => 'required|exists:promotions,id',
            'name' => 'required',
            'dni' => 'required',
            'edad' => 'required',
            'genero' => 'required',
            'religion' => 'required',
            'grade' => 'required',
            'civil_status' => 'required',
            'site_born' => 'required',
            'born_date' => 'required',
            'home' => 'required',
            'occupation' => 'required',
            'phone' => 'required',
        ]);

        $scheduledTime = Carbon::createFromFormat('g:i A', $validatedData['scheduled_time'])
        ->format('H:i:s');

        // Asignar valores predeterminados si no se seleccionaron empleados o pacientes
        $validatedData['employer_id'] = $validatedData['employer_id'] ?? $employerId;
        $validatedData['patient_id'] = $validatedData['patient_id'] ?? $patientId;
        $validatedData['scheduled_time'] = $scheduledTime;

        $request->session()->put('appointmentData', [
            'scheduled_date' => $validatedData['scheduled_date'],
            'scheduled_time' => $scheduledTime,
        ]);

        // Crea una nueva cita con los datos validados
        $appointment = Appointment::create($validatedData);
        $appointment->promotion()->associate($request->input('promotion_id'));
        $appointment->save();
    }

    public function show($id)
    {
        //$role = auth()->user()->role;
        $appointment = Appointment::find($id); // Busca la cita por ID
        if (!$appointment) {
            // Maneja el caso en que la cita no se encuentre
            abort(404); // Por ejemplo, muestra una página 404
        }

        $role = auth()->user()->role; // Asegúrate de obtener el rol

        return view('appointments.show', compact('appointment', 'role'));
    }

    public function postConfirm($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            // Manejar el caso en el que no se encuentra la cita.
            return redirect('/miscitas')->with('error', 'La cita no se encontró.');
        }

        $appointment->status = 'Confirmada';
        $saved = $appointment->save();

        if ($saved) {
            $appointment->patient->sendFCM('Su cita se ha confirmado!');
        }

        $notification = 'La cita se ha confirmado correctamente.';
        return redirect('/miscitas')->with(compact('notification'));
    }

    public function postCancel(Appointment $appointment, Request $request)
    {
        if ($request->has('justification')) {
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();
            // $cancellation->appointment_id = ;
            // $cancellation->save();

            $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $saved = $appointment->save(); // update

        if ($saved)
            $appointment->patient->sendFCM('Su cita ha sido cancelada.');

        $notification = 'La cita se ha cancelado correctamente.';
        return redirect('/miscitas')->with(compact('notification'));
    }

    public function showCancelForm(Appointment $appointment)
    {
        if ($appointment->status == 'Confirmada') {
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment', 'role'));
        }

        return redirect('/miscitas');
    }
}
