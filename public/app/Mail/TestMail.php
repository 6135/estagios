<?php

namespace App\Mail;

use App\EmpresaColaborador;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Mixed_;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('guibscosta@hotmail.com', 'estagios.dei.uc.pt')
                    ->from('noreply@dei.uc.pt', 'Plataforma de estágios')
                    ->subject("Email de teste")
                    ->view('emails.testmail', array());
    }
}
