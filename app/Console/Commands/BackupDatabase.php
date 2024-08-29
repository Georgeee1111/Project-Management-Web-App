<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;

class BackupDatabase extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Run the database backup';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $backupJob = BackupJobFactory::createFromArray(config('backup'));
        $backupJob->run();

        $this->info('Backup completed successfully.');
    }
}
