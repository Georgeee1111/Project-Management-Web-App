<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\Tasks\Backup\BackupIncremental;

class FetchIncrementalChanges extends Command
{
    protected $signature = 'backup:fetch-incremental';
    protected $description = 'Fetch incremental changes since last backup';

    public function handle()
    {
        $handler = new BackupIncremental();
        $handler->handle($this); 
    }
}
