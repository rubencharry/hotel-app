<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class SetupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create';
    protected $description = 'Crear la base de datos PostgreSQL, ejecutar migraciones y semillas';

    public function handle(): void
    {
        $dbName = Config::get('database.connections.pgsql.database');
        $dbUser = Config::get('database.connections.pgsql.username');
        $dbPassword = Config::get('database.connections.pgsql.password');

        $this->info("Creando la base de datos '{$dbName}' en PostgreSQL...");

        Config::set('database.connections.pgsql.database', 'postgres');

        try {
            DB::statement("CREATE DATABASE {$dbName} OWNER {$dbUser}");
            $this->info("Base de datos '{$dbName}' creada exitosamente.");
        } catch (\Exception $e) {
            $this->error("Error al crear la base de datos: " . $e->getMessage());
            return;
        }

        Config::set('database.connections.pgsql.database', $dbName);
    }
}
