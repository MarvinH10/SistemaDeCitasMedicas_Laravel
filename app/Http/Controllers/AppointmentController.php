<?php

namespace App\Http\Controllers;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Promotion;
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
        $promotions = Promotion::all();
        $promotionId = old('promotion_id');

        $horarios = Horarios::where('active', true)->get();
        $scheduledDate = old('scheduled_date', date('Y-m-d'));

        $activePromotions = Promotion::where('estado', 1)->get();

        $intervals = [];
        foreach ($horarios as $horario) {
            if ($horario->day == date('N', strtotime($scheduledDate))) {
                $intervals = array_merge($intervals, $horarioService->getAvailableIntervals($scheduledDate, $horario->user_id));
            }
        }

        return view('appointments.create', compact('promotions', 'intervals', 'scheduledDate', 'activePromotions'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->role == 'empleado') {
            $employerId = $user->id;
            $patientId = null;
        } elseif ($user->role == 'paciente') {
            $employerId = 2;
            $patientId = $user->id;
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
            'phone' => 'required',
        ]);

        $scheduledTime = Carbon::createFromFormat('g:i A', $validatedData['scheduled_time'])->format('H:i:s');

        $validatedData['employer_id'] = $validatedData['employer_id'] ?? $employerId;
        $validatedData['patient_id'] = $validatedData['patient_id'] ?? $patientId;
        $validatedData['scheduled_time'] = $scheduledTime;

        $request->session()->put('appointmentData', [
            'scheduled_date' => $validatedData['scheduled_date'],
            'scheduled_time' => $scheduledTime,
        ]);

        $appointment = Appointment::create($validatedData);
        $appointment->promotion()->associate($request->input('promotion_id'));
        $appointment->save();

        return redirect('/miscitas');
    }

    public function show($id)
    {
        //$role = auth()->user()->role;
        $appointment = Appointment::find($id);
        if (!$appointment) {
            abort(404);
        }
        $role = auth()->user()->role;

        return view('appointments.show', compact('appointment', 'role'));
    }

    public function postConfirm($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
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

    public function deleteAppointment(Appointment $appointment)
    {
        $cancel = $appointment->delete();
        if ($cancel)
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

    public function markAsAttended(Appointment $appointment)
    {
        if (!$appointment) {
            return redirect('/miscitas')->with('error', 'La cita no se encontró.');
        }

        $appointment->status = 'Atendida';
        $saved = $appointment->save();

        $notification = 'La cita se ha marcado como atendida correctamente.';
        return redirect('/miscitas')->with(compact('notification'));
    }
}
