<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\BackupDestination\BackupDestination;
use Spatie\Backup\Tasks\Restore\RestoreJob;
use Illuminate\Support\Collection;

class RestoreDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:restore-database {zipFilePath : The path to the zip file to restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore databases and files from backup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $zipFilePath = $this->argument('zipFilePath');
        $restorePath = 'app/restore';

        try {
            $backupDestinations = $this->getBackupDestinations();

            // Initialize RestoreJob and set backup destinations
            $restoreJob = new RestoreJob();
            $restoreJob->fromBackupDestinations($backupDestinations);

            // Restore files from the specified zip file and get extraction path
            $extractionPath = $restoreJob->restoreFiles($zipFilePath, $restorePath);

            // Restore databases from the extracted files
            $restoreJob->restoreDatabasesFromBackup($extractionPath);

            $this->info('Database restore completed successfully.');
            return 0;
        } catch (\Exception $e) {
            $this->error('Database restore failed: ' . $e->getMessage());
            return 1;
        }
    }

    /**
     * Simulate fetching backup destinations (replace with actual logic).
     *
     * @return Collection
     */
    protected function getBackupDestinations(): Collection
    {
        $filesystem = \Storage::disk('local');
        $backupName = 'Laravel'; 

        return new Collection([
            new BackupDestination($filesystem, $backupName, 'local'),
        ]);
    }
}

