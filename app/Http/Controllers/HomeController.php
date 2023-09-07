<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Promotion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function daysToMinutes($days)
    {
        $hours = $days * 24;
        return $hours * 60;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday
        $minutes = $this->daysToMinutes(7);

        $appointmentsByDay = Cache::remember('appointments_by_day', $minutes, function () {
            $results = Appointment::select([
                    DB::raw('DAYOFWEEK(scheduled_date) as day'),
                    DB::raw('COUNT(*) as count')
                ])
                ->groupBy(DB::raw('DAYOFWEEK(scheduled_date)'))
                ->whereIn('status', ['Confirmada', 'Atendida'])
                ->get(['day', 'count'])
                ->mapWithKeys(function ($item) {
                    return [$item['day'] => $item['count']];
                })->toArray();

            $counts = [];
            for ($i=1; $i<=7; ++$i) {
                if (array_key_exists($i, $results))
                    $counts[] = $results[$i];
                else
                    $counts[] = 0;
            }

            return $counts;
        }); // jue, vie -> [..., 1, 1, ...]

        $totalEmployers = User::where('role', 'empleado')->count();
        $totalPatients = User::where('role', 'paciente')->count();
        $totalPromotions = Promotion::count();

        // dd($appointmentsByDay);
        return view('home', compact('appointmentsByDay', 'totalEmployers', 'totalPatients', 'totalPromotions'));
    }
}
