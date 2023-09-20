<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $emailData = array();

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($_emailData)
    {
        $this->emailData = $_emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->emailData;

        Log::info("handle()");
        Log::info($email);

        /*Mail::send('emails.welcome', $email, function($message) use($email) {
            $message->to('diogogl@dei.uc.pt', $email['emaildestino'])->subject
            ($email['emailtitulo']);
            $message->from('d139b532fa-66d896@inbox.mailtrap.io',$email['emailtitulo']);
        });*/

        Mail::send('emails.welcome', $email, function($message) use($email) {
            $message->to('diogogl@dei.uc.pt', $email['emaildestino'])->subject
            ($email['emailtitulo']);
            $message->from('diogogl@dei.uc.pt',$email['emailtitulo']);
        });
    }
}
