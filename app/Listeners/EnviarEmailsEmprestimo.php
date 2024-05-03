<?php

namespace App\Listeners;

use App\Events\EmprestimoCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarEmailsEmprestimo
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\EmprestimoCriado  $event
     * @return void
     */
    public function handle(EmprestimoCriado $event)
    {
        $emprestimo = $event->emprestimo;
        $user = $emprestimo->user;
        $armario = $emprestimo->armario;

        // Enviar e-mail para o usuário
        Mail::to($user->email)->send(new SistemaDeArmarios($user, $armario));

        // Enviar e-mails para as secretarias
        $secretarias = User::with('roles')->get()->filter(
            fn ($usuario) => $usuario->roles->where('name', 'Secretaria')->isNotEmpty()
        );
        foreach ($secretarias as $secretaria) {
            Mail::to($secretaria->email)->send(new AvisoSecEmprestimo($user, $armario));
        }
    }
}
