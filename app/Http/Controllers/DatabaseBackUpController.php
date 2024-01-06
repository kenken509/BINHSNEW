<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;

class DatabaseBackUpController extends Controller
{
    public function show()
    {
        $backupFiles = Storage::files('backup');

        return inertia('AdminDashboard/AdminPages/BackUp/BackUpAll',[
            'backupFiles' => $backupFiles,
        ]);
    }

    public function delete($filename)
    {
        $filePath = 'backup/' . $filename;

        
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);

            return redirect()->route('database.backup.show')->with('success', 'Deleted Successfully!');
            
        }

        return redirect()->route('database.backup.show')->with('error', 'Deletion Failed');
    }

    public function restore(Request $request)
    {
        $filename = $request->filename;
        $filePath = 'backup' . DIRECTORY_SEPARATOR . $filename;

        // Convert the path to the correct format for the 'mysql' command on Windows
        $filePath = str_replace('/', DIRECTORY_SEPARATOR, $filePath);

        if (!Storage::exists($filePath)) {
            return redirect()->route('database.backup.show')->with('error', 'Restoration failed: Backup file not found.');
        }

        $databaseConfig = Config::get('database.connections.mysql');
        $databaseName = $databaseConfig['database'];
        $username = $databaseConfig['username'];
        $password = $databaseConfig['password'];
        $host = $databaseConfig['host'];

        
        $realPath = Storage::path($filePath);

        if(Storage::exists($filePath))
        {
            $mysqlPath = 'C:\xampp\mysql\bin\mysql'; // on deployment find the path for mysql
            $command = sprintf(
                '"%s" -u%s -p%s -h%s -P%s %s < %s',
                $mysqlPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg('4306'), // Specify the port here
                escapeshellarg($databaseName),
                escapeshellarg($realPath)
            );
            
            
            // Execute the command
            $output = [];
            $returnVar = 0;
            shell_exec($command);
        }
        
        
        
        // Log the command and its output
        \Log::info('Restore Command: ' . $command);
        \Log::info('Command Output: ' . implode("\n", $output));
        \Log::info('Command Return Code: ' . $returnVar);

        // Check for errors
        if ($returnVar !== 0) {
            // Log the error and provide user feedback
            \Log::error('Database restoration failed. Return code: ' . $returnVar);
            \Log::error('Command Output: ' . implode("\n", $output));

            return redirect()->route('database.backup.show')->with('error', 'Database restoration failed.');
        }

        // Successful restoration
        return redirect()->route('database.backup.show')->with('success', 'Database restored successfully!');
    }

}
