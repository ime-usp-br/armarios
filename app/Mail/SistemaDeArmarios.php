<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SistemaDeArmarios extends Mailable
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
        $this->usuario = $user;
        $this->armario = $armario;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $assunto = 'Notificação de Empréstimo de Armário';
        return $this->subject($assunto)
                    ->view('emails.emprestimoarmario')
                    ->with([
                        'usuario' => $this->usuario,
                        'armario' => $this->armario,
                    ]);
        
    }
}
