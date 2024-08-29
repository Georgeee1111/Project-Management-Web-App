<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestoreIncrementalBackup extends Command
{
    protected $signature = 'backup:restore {zipFilename} {sqlFilename}';
    protected $description = 'Restore an incremental backup from a specific SQL file within a zip archive.';

    public function handle()
    {
        $zipFilename = $this->argument('zipFilename');
        $sqlFilename = $this->argument('sqlFilename');
        $backupDir = storage_path('app/backup/incremental');
        $zipFilePath = $backupDir . '/' . $zipFilename;
        
        if (!file_exists($zipFilePath)) {
            $this->error("The zip file {$zipFilename} does not exist.");
            return;
        }

        // Create a temporary directory for extracted files
        $tempDir = $backupDir . '/temp';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Extract the zip file
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath) === true) {
            // Extract only the specified SQL file
            if ($zip->locateName($sqlFilename) !== false) {
                $zip->extractTo($tempDir, $sqlFilename);
                $zip->close();
            } else {
                $this->error("The SQL file {$sqlFilename} does not exist in the zip archive.");
                $zip->close();
                return;
            }
        } else {
            $this->error('Failed to open zip file.');
            return;
        }

        // Path to the extracted SQL file
        $sqlFilePath = $tempDir . '/' . $sqlFilename;

        // Check if the SQL file exists
        if (!file_exists($sqlFilePath)) {
            $this->error('Failed to extract SQL file.');
            return;
        }

        // Read the SQL file content
        $sqlContent = file_get_contents($sqlFilePath);
        if ($sqlContent === false) {
            $this->error('Failed to read SQL file: ' . $sqlFilename);
            return;
        }

        // Execute SQL content
        try {
            DB::unprepared($sqlContent);
            $this->info('Successfully restored: ' . $sqlFilename);
        } catch (\Exception $e) {
            $this->error('Failed to restore: ' . $sqlFilename . ' Error: ' . $e->getMessage());
        }

        // Clean up
        unlink($sqlFilePath);
        rmdir($tempDir);

        $this->info('Incremental backup restored successfully.');
    }
}
