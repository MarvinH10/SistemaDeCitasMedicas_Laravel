<?php

namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use Carbon\Carbon;
use App\Models\Horarios;
use App\Models\Appointment;

class HorarioService implements HorarioServiceInterface
{
    // Implementar métodos de la interfaz aquí
    public function isAvailableInterval($date, $employerId, Carbon $start) {
            $existingAppointments = Appointment::where('employer_id', $employerId)
            ->where('scheduled_date', $date)
            ->where('scheduled_time', $start->format('H:i:s'))
            ->get();

            return $existingAppointments->isEmpty();
    }

    public function getAvailableIntervals($date, $employerId)
    {
        $day = $this->getDayFromDate($date);

        $horario = Horarios::where('active', true)
            ->where('day', $day)
            ->where('user_id', $employerId)
            ->first([
                'morning_start', 'morning_end',
                'afternoon_start', 'afternoon_end'
            ]);

        if ($horario) {
            $morningIntervals = $this->getIntervals(
                $horario->morning_start, $horario->morning_end,
                $date, $employerId
            );

            $afternoonIntervals = $this->getIntervals(
                $horario->afternoon_start, $horario->afternoon_end,
                $date, $employerId
            );
        } else {
            $morningIntervals = [];
            $afternoonIntervals = [];
        }

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
    }

    private function getDayFromDate($date)
	{
    	$dateCarbon = new Carbon($date);

    	// determinar de 0 a 6 a los dias de la semana Lun a Dom
    	$i = $dateCarbon->dayOfWeek;
    	$day = ($i==0 ? 6 : $i-1);
    	return $day;
	}

	private function getIntervals($start, $end, $date, $employerId) {
		$start = new Carbon($start);
        $end = new Carbon($end);

    	$intervals = [];

    	while ($start < $end) {
    		$interval = [];

    		$interval['start'] = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $employerId, $start);

    		$start->addMinutes(30);
    		$interval['end']  = $start->format('g:i A');

            if ($available) {
                $intervals []= $interval;
            }
    	}

    	return $intervals;
    }
}
