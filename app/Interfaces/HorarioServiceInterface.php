<?php

namespace App\Interfaces;

use Carbon\Carbon;

interface HorarioServiceInterface
{
    // Definir métodos de la interfaz aquí
    public function isAvailableInterval($date, $employerId, Carbon $start);
	public function getAvailableIntervals($date, $employerId);
}
