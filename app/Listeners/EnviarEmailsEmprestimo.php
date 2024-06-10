<?php

namespace App\Listeners;

use App\Events\EmprestimoCriado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SistemaDeArmarios;
use App\Mail\AvisoSecEmprestimo;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class EnviarEmailsEmprestimo implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\EmprestimoCriado  $event
     * @return void
     */
    public function handle(EmprestimoCriado $event)
    {
        Log::info('Listener EnviarEmailsEmprestimo foi acionado.');
        
        $emprestimo = $event->emprestimo;
        $user = $emprestimo->user;
        $armario = $emprestimo->armario;

        Log::info('Dados do usuário: ', ['email' => $user->email]);
        Log::info('Dados do armário: ', ['armario' => $armario]);

        // Enviar e-mail para o usuário
        Mail::to($user->email)->send(new SistemaDeArmarios($user, $armario));

        // Enviar e-mails para as secretarias
        $secretarias = User::with('roles')->get()->filter(
            fn ($usuario) => $usuario->roles->where('name', 'Secretaria')->isNotEmpty()
        );
        foreach ($secretarias as $secretaria) {
            Log::info('Enviando email para secretaria: ', ['email' => $secretaria->email]);
            Mail::to($secretaria->email)->send(new AvisoSecEmprestimo($user, $armario));
        }
    }
}
