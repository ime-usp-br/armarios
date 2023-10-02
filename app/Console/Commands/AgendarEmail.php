<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AgendarEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agendar:email';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Agendar e-mails de lembrete';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
    $prazoLimite = \Carbon\Carbon::today()->addDays(30);
    $users = \App\Models\User::has('emprestimos')->get();

    foreach ($users as $user) {
        $emprestimos = $user->emprestimos()->get();

        foreach ($emprestimos as $emprestimo) {
            // Converta a coluna dataprev para um objeto Carbon
            $dataprev = \Carbon\Carbon::createFromFormat('Y-m-d', $emprestimo->dataprev);

            // Verifique se a data é maior ou igual ao prazo limite
            if ($dataprev->greaterThanOrEqualTo($prazoLimite)) {
                Mail::to($user->email)->send(new AvisoPrazoEmprestimo($user, $emprestimo));
            }
        }
    }
    }   
}
