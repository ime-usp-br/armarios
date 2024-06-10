<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use Illuminate\Http\Request;
use App\Http\Controllers\ArmarioController;
use App\Models\Armario;
use Uspdev\Replicado\DB;
use App\Models\User;
use App\Http\Requests\EmprestimoRequest;
use Auth;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SistemaDeArmarios;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Mail\AvisoSecEmprestimo;
use App\Http\Requests\SolicitarEmprestimoRequest;
use App\Events\EmprestimoCriado;
use App\Listeners\EnviarEmailsEmprestimo;




class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $armariosLivres = null;
       
        if (!$user == null){
            $emprestimo = Emprestimo::where(
                [
                    'user_id' => $user->id,
                    'estado'  => Emprestimo::ATIVO,
                ]
            )->first();

        }
        

       

        if (Auth::check()) {
            if ($emprestimo === null) {
                $armariosLivres = Armario::where("estado", Armario::LIVRE)->get()->sortBy('numero');
            } 

            return view('emprestimos.index', compact('emprestimo', 'armariosLivres'));
        } else {
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emprestimo  $emprestimo
     * @return \Illuminate\Http\Response
     */
    public function show(Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Emprestimo  $emprestimo
     * @return \Illuminate\Http\Response
     */
    public function edit(Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emprestimo  $emprestimo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emprestimo $emprestimo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Emprestimo  $emprestimo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emprestimo $emprestimo)
    {
        //
    }

    public function emprestimo(SolicitarEmprestimoRequest $request)
    {
        
        if (!auth()->user()->hasRole(['Aluno de pós'])) {
            abort(403);
        }
        
        $user = auth()->user();
        $validated = $request->validated();

        $armario = Armario::where("numero", $validated["numero"])->first();

        if ($armario->estado == Armario::LIVRE) {
            $armario->estado = Armario::OCUPADO;

            $armario->save();

            $emprestimo = new Emprestimo;
            $emprestimo->user_id = auth()->user()->id;
            $emprestimo->estado = Emprestimo::ATIVO;
            $emprestimo->armario_id = $armario->id;
            $emprestimo->save();
            \Log::info('Disparando evento EmprestimoCriado');
            event(new EmprestimoCriado($emprestimo));
            //$event = new EmprestimoCriado($emprestimo);
            //$listener = new EnviarEmailsEmprestimo();
            //$listener->handle($event);
           

            return redirect("/");
        }
    }

    
}
