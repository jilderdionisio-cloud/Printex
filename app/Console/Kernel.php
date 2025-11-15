<?php

namespace App\Console;

use App\Console\Commands\TestDBConnectionCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos Artisan proporcionados por su aplicación.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        TestDBConnectionCommand::class,
    ];

    /**
     * Define el horario de comandos de la aplicación.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Registra los comandos para la aplicación.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
