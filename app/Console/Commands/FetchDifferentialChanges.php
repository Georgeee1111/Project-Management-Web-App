<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\Tasks\Backup\BackupDifferential;

class FetchDifferentialChanges extends Command
{
    protected $signature = 'backup:fetch-differential';
    protected $description = 'Fetch differential changes since last full backup';

    public function handle()
    {
        $handler = new BackupDifferential();
        $handler->handle($this); 
    }
}
