<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestDBConnectionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica la conexión a la base de datos ejecutando un SELECT 1';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            DB::select('SELECT 1 as test');
            $this->info('Conexión a la base de datos EXITOSA');
            return self::SUCCESS;
        } catch (Throwable $exception) {
            $this->error('ERROR de conexión: ' . $exception->getMessage());
            return self::FAILURE;
        }
    }
}
