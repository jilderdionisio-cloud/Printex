<?php
//verifica si hay conexiona la base de datos
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestDBConnectionCommand extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'app:test-db';

    /**
     * La descripción del comando de la consola.
     *
     * @var string
     */
    protected $description = 'Verifica la conexión a la base de datos ejecutando un SELECT 1';

    /**
     * Ejecuta el comando de la consola.
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
