<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Horarios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function hours(Request $request, HorarioServiceInterface $horarioService){
        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'employer_id' => 'required|exists:users,id'
        ];
        $request->validate($rules);

        $date = $request->input('date');
        $employerId = $request->input('employer_id');

        return $horarioService->getAvailableIntervals($date, $employerId);
    }
}
