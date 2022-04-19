<?php

namespace Dwedaz\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\BufferedOutput;

class ModuleManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateAndSeed(Array $modules)
    {
        $outputLog = new BufferedOutput;

        $this->sqlite($outputLog);

        return $this->migrate($outputLog, $modules);
    }

    /**
     * Run the migration and call the seeder.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function migrate(BufferedOutput $outputLog, Array $modules)
    {
       
        try {
            foreach($modules as $module){
                Artisan::call('module:publish '. $module,[], $outputLog);
                Artisan::call('module:migrate '. $module,[], $outputLog);
                Artisan::call('module:use '. $module,[], $outputLog);
            }
           // Artisan::call('module:migrate ', ['--migration'=> true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('laravel-installer::installer_messages.final.finished'), 'success', $outputLog);
    }

    

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function response($message, $status, BufferedOutput $outputLog)
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    /**
     * Check database type. If SQLite, then create the database file.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     */
    private function sqlite(BufferedOutput $outputLog)
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (! file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
            $outputLog->write('Using SqlLite database: '.$database, 1);
        }
    }
}