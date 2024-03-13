<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use Log;
use App\Models\Emprestimo;
use Uspdev\Replicado\DB;
use Carbon\Carbon;

class AtualizarDataDefesa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:atualizardatadefesa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a data de defesa de um aluno de pós, verificando se ele tem permissão para realizar empréstimo.';

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
        Log::info('Comando Sincronizador em execução...');

        $dt = new DateTime();
        $atualizacoes = 0;
        $relatorio = [];

        $emprestimos = Emprestimo::with('user')->get();
        $codpesList = $emprestimos->pluck('user.codpes')->unique()->toArray();

        $query = "SELECT AGP.codpes, MAX(AGP.dtadfapgm) AS ultima_data"; 
        $query .= " FROM AGPROGRAMA AS AGP";
        $query .= " JOIN ( VALUES ";
        foreach(range(0, count($codpesList)-1) as $i){
            $query .= "('".$codpesList[$i]."')";
            if($i != count($codpesList)-1){
                $query .= ",";
            }
        }
        $query .= " ) AS TEMP(codpes)";
        $query .= " ON AGP.codpes = TEMP.codpes ";
        $query .= " GROUP BY AGP.codpes ";
        $data = DB::fetchAll($query);
        
        foreach ($emprestimos as $emprestimo) {
            $codpes = $emprestimo->user->codpes;

            $dataAluno = collect($data)->firstWhere('codpes', $codpes);

            if ($dataAluno and $dataAluno['ultima_data'] != null) {
                $emprestimo->dataprev = Carbon::createFromFormat('Y-m-d h:i:s', $dataAluno['ultima_data'])->format('d/m/Y');
                $emprestimo->save();

                $atualizacoes++;

                $relatorio[$atualizacoes]['id_emprestimo'] = $emprestimo->id;
                $relatorio[$atualizacoes]['codpes_aluno'] = $codpes;
                $relatorio[$atualizacoes]['dataprev_atualizada'] = $emprestimo->dataprev;
            }
        }

        $interval = $dt->diff(new DateTime());
        Log::info($interval->format('Duração: %Hh %Im %Ss'));
        Log::info("Total de atualizações: " . $atualizacoes);
        Log::info('########## Comando Sincronizador finalizado!');

        
    }

}
