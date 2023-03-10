<?php

namespace App\Console\Commands;

use App\Mail\DemoMail;
use App\Models\Sender;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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

        $emailsToSent = Sender::select('id','email')->where("is_send", "0")->chunkById(2, function ($emailsToSent) {
            $mailData = [
                'title' => 'SenderController from ItSolutionStuff.com',
                'body' => 'This is for testing email using smtp.'
            ];
            foreach ($emailsToSent as $emailSent) {
                if (Mail::to($emailSent)->send(new DemoMail($mailData))) {

                    Sender::where('email', $emailSent->email)->update(['is_send' => "1"]);
                }

            }
        });


    }


}




