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
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (!auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                abort(403);
            }
        }
        if (Emprestimo::where('user_id',auth()->user()->id)->first()){
            Session::flash('alert-warning', 'Usuário já possui empréstimo de armário.');
            return back();
        }
        $armario->estado = 'Emprestado';
        $armario->save();

        $emprestimo = new Emprestimo;
        $emprestimo->user_id = auth()->user()->id;
       
        $emprestimo->armario_id = $armario->id;
        $emprestimo->save();
        Mail::to(auth()->user()->email)->send(new SistemaDeArmarios(auth()->user(), $armario));
        return redirect("/armarios");
        
        }
    
    

    






     
        
        
        


    
}


