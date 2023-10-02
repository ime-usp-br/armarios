<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Armario;
use App\Models\Emprestimo;


class AvisoPrazoEmprestimo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * 
     */
    public $user, $emprestimo;
    public function __construct()
    {
        $this->user = $user;
        
        $this->emprestimo = $emprestimo;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $assunto = 'Empréstimo de armário chegando ao fim';
         return $this->subject($assunto)
                     ->view('emails.prazoemprestimo')
                     ->with([
                         'user' => $this->user,
                         'emprestimo' => $this->emprestimo,
                     ]);
            
    }
}
