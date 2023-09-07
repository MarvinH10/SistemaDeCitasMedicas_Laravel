<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Appointment;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        // Recupera los datos de citas por día de la semana
        $appointmentsByDay = Appointment::selectRaw('DAYOFWEEK(scheduled_date) as day, COUNT(*) as count')
            ->whereIn('status', ['Confirmada', 'Atendida'])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('count', 'day')
            ->toArray();

        return view('charts.index', compact('appointmentsByDay'));
    }

    public function appointments()
    {	// created_at -> dateTime

    	$monthlyCounts = Appointment::select(
			DB::raw('MONTH(created_at) as month'),
			DB::raw('COUNT(1) as count')
		)->groupBy('month')->get()->toArray();
		// [ ['month'=>11, 'count'=>3] ]
		// [0, 0, 0, 0, ..., 3, 0]

		$counts = array_fill(0, 12, 0); // index, qty, value
		foreach ($monthlyCounts as $monthlyCount) {
			$index = $monthlyCount['month']-1;
			$counts[$index] = $monthlyCount['count'];
		}

    	return view('charts.appointments', compact('counts'));
    }

    public function employers()
    {
    	$now = Carbon::now();
    	$end = $now->format('Y-m-d');
    	$start = $now->subYear()->format('Y-m-d');

    	return view('charts.employers', compact('start', 'end'));
    }

    public function employersJson(Request $request)
    {
    	$start = $request->input('start');
    	$end = $request->input('end');

    	$doctors = User::employers()
    		->select('name')
    		->withCount([
    			'attendedAppointments' => function ($query) use ($start, $end) {
    				$query->whereBetween('scheduled_date', [$start, $end]);
    			},
    			'cancelledAppointments' => function ($query) use ($start, $end) {
    				$query->whereBetween('scheduled_date', [$start, $end]);
    			}
    		])
    		->orderBy('attended_appointments_count', 'desc')
    		->take(5)
    		->get();

    	$data = [];
    	$data['categories'] = $doctors->pluck('name');

    	$series = [];
    	// Atendidas
    	$series1['name'] = 'Citas atendidas';
    	$series1['data'] = $doctors->pluck('attended_appointments_count');
    	// Canceladas
    	$series2['name'] = 'Citas canceladas';
    	$series2['data'] = $doctors->pluck('cancelled_appointments_count');

    	$series[] = $series1;
    	$series[] = $series2;

    	$data['series'] = $series;

    	return $data; // {categories: ['A', 'B'], series: [1, 2]}
    }
}
