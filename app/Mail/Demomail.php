<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class Demomail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $post = DB::table('posts')->latest('id')->first();
        return $this->subject('SenderController from ItSolutionStuff.com')
        ->view('emails.demoMail',compact('post'));
    }
}
