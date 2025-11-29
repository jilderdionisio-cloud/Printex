<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $instructors = [
            ['name' => 'María Fernanda Gómez', 'email' => 'maria.gomez@printex.com'],
            ['name' => 'Luis Alberto Rojas', 'email' => 'luis.rojas@printex.com'],
            ['name' => 'Carolina Mejía Torres', 'email' => 'carolina.mejia@printex.com'],
        ];

        foreach ($instructors as $instructor) {
            User::firstOrCreate(
                ['email' => $instructor['email']],
                [
                    'name' => $instructor['name'],
                    'password' => Hash::make('password'),
                    // Usamos un rol permitido en la BD
                    'role' => 'admin',
                ]
            );
        }
    }
}
