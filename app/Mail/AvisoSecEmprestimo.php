<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoSecEmprestimo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user, $armario;
    public function __construct($user, $armario)
    {
        $this->user = $user;
        
        $this->armario = $armario;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $assunto = 'Aluno solicitou empréstimo';
         return $this->subject($assunto)
                     ->view('emails.avisosecemprestimo')
                     ->with([
                         'user' => $this->user,
                         'armario' => $this->armario,
                     ]);
            
    }
}
