<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123456789'), // password
            'address' => 'Jr. 28 de julio',
            'phone' => '987654321',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Jhon',
            'email' => 'jhon@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('987654321jhon'), // password
            'address' => 'Jr. 28 de julio',
            'phone' => '987654321',
            'role' => 'empleado',
        ]);

        User::create([
            'name' => 'Luis',
            'email' => 'luis@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('987654321luis'), // password
            'address' => 'Jr. 28 de julio',
            'phone' => '987654321',
            'role' => 'paciente',
        ]);

        User::factory()
            ->count(50)
            ->create();
    }
}
