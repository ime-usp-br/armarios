<?php

namespace App\Listeners;

use App\Events\ArmarioLiberado;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiberarArmario;
use App\Mail\AvisoSecLiberar;
use App\Models\Armario;


class EnviarEmailsArmarioLiberado
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
     * @param  \App\Events\ArmarioLiberado  $event
     * @return void
     */
    public function handle(ArmarioLiberado $event)
    {
        $usuarioLogado = auth()->user();

        $armario = $event->armario;
        $emprestimo = $armario->emprestimos()->where('estado', 'ATIVO')->first();
        $user = $emprestimo->user;
        
        
        
        if ($usuarioLogado->hasRole('Secretaria')) {
            Mail::to($user->email)->send(new LiberarArmario($user, $armario));
        } elseif ($usuarioLogado->hasRole('Aluno de pós')) {
            $secretarias = User::with('roles')->get()->filter(fn ($usuario) => $usuario->roles->where('name', 'Secretaria')->toArray());
            foreach ($secretarias as $secretaria) {
                Mail::to($secretaria->email)->send(new AvisoSecLiberar($user, $armario));
            }
        }
    }
}
