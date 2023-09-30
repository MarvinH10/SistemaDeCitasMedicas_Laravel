<?php

namespace Database\Seeders;

use App\Models\Horarios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i<7; ++$i) {
        	Horarios::create([
        		'day' => $i,
		        'active' => ($i==3), // Thursday

		        'morning_start' => ($i==3 ? '08:00:00' : '08:00:00'),
		        'morning_end' => ($i==3 ? '08:00:00' : '10:00:00'),

		        'afternoon_start' => ($i==3 ? '14:00:00' : '17:00:00'),
		        'afternoon_end' => ($i==3 ? '15:00:00' : '18:00:00'),

		        'user_id' => 2 // Empleado Test (UsersTableSeeder)
        	]);
        }
    }
}
