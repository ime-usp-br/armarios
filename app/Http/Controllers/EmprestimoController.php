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



class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $armarios = Armario::where("estado", "Disponível")->get()->sortBy('numero');
        return view('emprestimos.index',[
            'armarios' => $armarios
        ]);
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

    public function emprestimo(Armario $armario)
    {
        //if(!Auth::user()->isAluno()){
          //  abort(403);
        
        //}
        if (Emprestimo::where('user_id',auth()->user()->id)->first()){
            Session::flash('alert-warning', 'Usuário já possui empréstimo de armário.');
            return back();
        }
        $user = auth()->user();

        
        
        $armario->estado = 'Emprestado';
        
        $armario->save();

        $emprestimo = new Emprestimo;
        $emprestimo->user_id = auth()->user()->id;
       
        $emprestimo->armario_id = $armario->id;
        if($user->codpes == 11883052){
            $emprestimo->dataprev = Carbon::today()->format('d/m/Y');
            $datafinal = Carbon::createFromFormat('d/m/Y', $emprestimo->dataprev)->addDays(30)->format('d/m/Y');
            $emprestimo->datafinal = $datafinal;

        }elseif(User::testDataDefesa($user->codpes) == null){
            
        }else{
            $emprestimo->dataprev = User::testDataDefesa($user->codpes)->format('d/m/Y');
            $datafinal = Carbon::createFromFormat('d/m/Y', $emprestimo->dataprev)->addDays(30)->format('d/m/Y');
            $emprestimo->datafinal = $datafinal;
        }
        
        Mail::to($user->email)->send(new SistemaDeArmarios($user, $armario));
        $emprestimo->save();
        Session::flash('success', 'Empréstimo realizado com sucesso!');
        
        
        return redirect("/");
        
    }

    public function meuarmario(Armario $armario)
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole(['Aluno de pós'])) {
                
    
                return view('emprestimos.meuarmario',[
                ]);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
    }
       


}


