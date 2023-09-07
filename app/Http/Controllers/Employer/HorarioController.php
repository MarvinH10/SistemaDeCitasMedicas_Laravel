<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioController extends Controller
{
	private $days = [
		'Lunes', 'Martes', 'Miércoles',
		'Jueves', 'Viernes', 'Sábado', 'Domingo'
	];

	public function edit()
    {
    	$horarios = Horarios::where('user_id', auth()->id())->get();

        if(count($horarios) > 0){
            $horarios->map(function ($horario) {
                $horario->morning_start = (new Carbon($horario->morning_start))->format('g:i A');
                $horario->morning_end = (new Carbon($horario->morning_end))->format('g:i A');
                $horario->afternoon_start = (new Carbon($horario->afternoon_start))->format('g:i A');
                $horario->afternoon_end = (new Carbon($horario->afternoon_end))->format('g:i A');
                return $horario;
            });
        }else{
            $horarios = collect();
            for ($i=0; $i<7; ++$i)
                $horarios->push(new Horarios());
        }

    	$days = $this->days;
    	return view('horario', compact('horarios', 'days'));
    }

    public function store(Request $request)
    {
    	//dd($request->all());

    	$active = $request->input('active') ?: [];
    	$morning_start = $request->input('morning_start');
    	$morning_end = $request->input('morning_end');
    	$afternoon_start = $request->input('afternoon_start');
    	$afternoon_end = $request->input('afternoon_end');

		$errors = [];

    	for($i=0; $i<7; ++$i){
    		if ($morning_start[$i] > $morning_end[$i]) {
    			$errors []= 'Inconsistencia en el intervalo de las horas del turno de la mañana del día '.$this->days[$i].'.';
    		}
    		if ($afternoon_start[$i] > $afternoon_end[$i]) {
    			$errors []= 'Inconsistencia en el intervalo de las horas del turno de la tarde del día '.$this->days[$i].'.';
    		}

	    	Horarios::updateOrCreate([
				'day' => $i,
				'user_id' => auth()->id()
			],
			[
				'active' => in_array($i, $active),
				'morning_start' => $morning_start[$i],
				'morning_end' => $morning_end[$i],
				'afternoon_start' => $afternoon_start[$i],
				'afternoon_end' => $afternoon_end[$i]
			]);
		}

		if(count($errors) > 0)
	    	return back()->with(compact('errors'));

	    $notification = 'Los cambios se han guardado correctamente.';
	    return back()->with(compact('notification'));
    }
}
