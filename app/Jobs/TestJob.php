<?php
namespace App\Jobs;
use App\Mail\Demomail;
use App\Models\Sender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {
        //
    }

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
