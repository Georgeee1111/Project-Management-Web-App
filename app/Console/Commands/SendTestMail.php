<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class SendTestMail extends Command
{
    protected $signature = 'mail:send-test';
    protected $description = 'Send a test email';

    public function handle()
    {
        Mail::to('minguitogeorgee@gmail.com')->send(new TestMail());
        $this->info('Test email sent successfully!');
    }
}
