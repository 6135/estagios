<?php

namespace App\Mail;

use App\EmpresaColaborador;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Mixed_;

class MailQueuer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Mail Data
     *
     * @var array
     */

    public array $mailData;

    /**
     * Create a new message instance.
     *
     *
     * @return void
     */
    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailData = $this->mailData;
        if(!isset($mailData['buttonText'])){
            $mailData['buttonText'] = 'Confirmar';
        }
        return $this->to($mailData['emailAddress'], 'estagios.dei.uc.pt')
                    ->from('noreply@dei.uc.pt', 'Plataforma de estágios')
                    ->subject($mailData['subject'])
                    ->view($mailData['view'],$mailData);
    }
}
