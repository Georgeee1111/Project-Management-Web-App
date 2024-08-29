<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class RestoreIncrementalDatabase extends Command
{
    protected $signature = 'backup:restore-incremental {file : The name of the incremental backup zip file}';
    protected $description = 'Restore incremental database backup from a zip file containing SQL data';

    public function handle()
    {
        $zipFileName = $this->argument('file');
        $zipFilePath = 'backup/incremental/' . $zipFileName;

        // Check if the zip file exists
        if (!Storage::exists($zipFilePath)) {
            $this->error("Backup file {$zipFileName} not found in 'backup/incremental/' directory.");
            return;
        }

        // Extract the SQL backup files from the zip archive
        $extractedSqlFiles = $this->extractSqlFiles($zipFilePath);

        if (empty($extractedSqlFiles)) {
            $this->error("Failed to extract SQL backup files from {$zipFileName}.");
            return;
        }

        // Restore each SQL backup file to the database
        foreach ($extractedSqlFiles as $sqlFilePath) {
            $this->restoreBackup($sqlFilePath);
        }

        $this->info('Incremental database restore completed successfully.');
    }

    protected function extractSqlFiles($zipFilePath)
    {
        $zip = new ZipArchive;
        $tempExtractPath = tempnam(sys_get_temp_dir(), 'backup');
        unlink($tempExtractPath); // Remove the created file so we can use it as a directory
        mkdir($tempExtractPath);

        if ($zip->open(Storage::path($zipFilePath)) === true) {
            $extractedSqlFiles = [];

            // Extract all files from the zip archive
            $zip->extractTo($tempExtractPath);

            // Find all SQL files extracted
            $files = scandir($tempExtractPath);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
                    $extractedSqlFiles[] = $tempExtractPath . DIRECTORY_SEPARATOR . $file;
                }
            }

            $zip->close();

            return $extractedSqlFiles;
        }

        return [];
    }

    protected function restoreBackup($sqlFilePath)
    {
        // Ensure the SQL file exists
        if (!file_exists($sqlFilePath)) {
            $this->error("SQL backup file {$sqlFilePath} not found.");
            return;
        }

        // Read the SQL content
        $sqlContent = file_get_contents($sqlFilePath);

        // Execute SQL statements using Laravel DB facade
        DB::unprepared($sqlContent);
    }
}
