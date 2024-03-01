<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\AvisoPrazoEmprestimo;

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
        $prazoLimite = Carbon::today();
        $users = User::has('emprestimos')->get();

        foreach ($users as $user) {
            $emprestimos = $user->emprestimos;

            foreach ($emprestimos as $emprestimo) {
                $dataprevParts = explode('/', $emprestimo->dataprev);
                if (count($dataprevParts) === 3) {
                    $dataprevFormatted = $dataprevParts[2] . '-' . $dataprevParts[1] . '-' . $dataprevParts[0];
                } else {
                    continue;
                }

                $dataprev = Carbon::createFromFormat('Y-m-d', $dataprevFormatted);

                if ($prazoLimite <= $dataprev) {
                    Mail::to($user->email)->send(new AvisoPrazoEmprestimo($user, $emprestimo));
                }
            }
        }
    }
}