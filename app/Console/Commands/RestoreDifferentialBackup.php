<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RestoreDifferentialBackup extends Command
{
    protected $signature = 'backup:restore-differential {filename}';
    protected $description = 'Restore a differential backup from a given SQL file in a zip archive.';

    public function handle()
    {
        $filename = $this->argument('filename');
        $backupDir = storage_path('app/backup/differential');
        $zipFilePath = $backupDir . '/' . $filename;

        if (!file_exists($zipFilePath)) {
            $this->error("The backup file {$filename} does not exist.");
            return;
        }

        // Extract the zip file
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath) === true) {
            $sqlFileName = $zip->getNameIndex(0); 
            $extractedSqlFilePath = $backupDir . '/' . $sqlFileName;
            $zip->extractTo($backupDir);
            $zip->close();
        } else {
            $this->error('Failed to open zip file.');
            return;
        }

        // Read the SQL file content
        $sqlContent = file_get_contents($extractedSqlFilePath);
        if ($sqlContent === false) {
            $this->error('Failed to read SQL file.');
            return;
        }

        // Execute SQL content
        DB::unprepared($sqlContent);

        // Clean up
        unlink($extractedSqlFilePath);

        $this->info('Differential backup restored successfully.');
    }
}
