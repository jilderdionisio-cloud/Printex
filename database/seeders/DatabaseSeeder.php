<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Inicia la base de datos de la aplicacion
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                // password hashed via factory, ensure default if not set
                'password' => bcrypt('password'),
            ]
        );

        $this->call(CategorySeeder::class);
        $this->call(InstructorSeeder::class);
    }
}
