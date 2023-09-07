<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Interfaces\HorarioServiceInterface;
use Carbon\Carbon;

class StoreAppointment extends FormRequest
{
    private $horarioService;

    public function __construct(HorarioServiceInterface $horarioService)
    {
        $this->horarioService = $horarioService;
    }

    public function rules()
    {
        return [
            'employer_id' => 'exists:users,id',
            'scheduled_time' => 'required',
            'promotion_id' => 'exists:promotions,id',
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
        ];
    }

    public function messages()
    {
        return [
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $date = $this->input('scheduled_date');
            $employerId = $this->input('employer_id');
            $scheduled_time = $this->input('scheduled_time');

            if (!$date || !$employerId || !$scheduled_time) {
                return;
            }

            $start = new Carbon($scheduled_time);

            if (!$this->horarioService->isAvailableInterval($date, $employerId, $start)) {
                $validator->errors()
                    ->add('available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente.');
            }
        });
    }
}
