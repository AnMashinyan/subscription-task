<?php

namespace App\Console\Commands;
use App\Jobs\TestJob;
use Illuminate\Console\Command;


class SendEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        TestJob::dispatch();
    }
}




