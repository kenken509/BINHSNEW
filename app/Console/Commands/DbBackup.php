<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'automatic database backup';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $filename = now()->format('F-j-Y_g-i-sA') . '.sql';

        $command = 'C:\xampp\mysql\bin\mysqldump --user=' . config('database.connections.mysql.username') . // on deployment find the path for mysqldump
           ' --password=' . config('database.connections.mysql.password') .
           ' --host=' . config('database.connections.mysql.host') .
           ' --port=' . config('database.connections.mysql.port') .
           ' ' . config('database.connections.mysql.database') .
           ' > ' . storage_path('app/public/backup/') . $filename;

        // Execute the command and capture output and return code
        exec($command, $output, $returnVar);

        // Check the return code and log any errors
        if ($returnVar !== 0) {
            $this->error('Database dump failed. Return code: ' . $returnVar);
            Log::info('error backing up: ' . $filename);
            // Log or handle errors as needed
        } else {
            $this->info('Database dump created successfully: ' . $filename);
            Log::info('Database dump created successfully: ' . $filename);
        }
    }
}
