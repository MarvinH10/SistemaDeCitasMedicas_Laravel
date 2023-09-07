<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Promotion;
use App\Models\User;

class PromotionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            'Ninguna',
    		'Paquete Obstetrico',
    		'Chequeo Integral',
    		'Control Mujer',
            'Chequeo Completo'
    	];
    	foreach ($promotions as $promotionName) {
            Promotion::create([
                'name' => $promotionName,
                'description' => 'Simple descripción',
                'price' => rand(50, 300)
            ]);
        }
    }
}
