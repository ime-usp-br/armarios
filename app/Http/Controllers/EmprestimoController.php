<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use Illuminate\Http\Request;
use App\Http\Controllers\ArmarioController;
use App\Models\Armario;
use App\Http\Requests\EmprestimoRequest;
use Session;


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

    public function emprestimo(EmprestimoRequest $request)
    {
        $validated = $request->validated();
        $armario = Armario::where('numero',$validated['numero'])->first();
        
        if(!$armario){
            Session::flash("alert-warning", "Armário não existe");
            return back();
        }elseif($armario->estado == 'Emprestado'){
            Session::flash("alert-warning", "Armário já emprestado");
            return back();
        
        }else{
            
            $armario->estado = 'Emprestado';
            $armario->save();
            $emprestimo = new Emprestimo;
            $emprestimo->user_id = auth()->user()->id;
            $emprestimo->armario_id = $armario->id;
            $emprestimo->save();
        }

       






        //date_default_timezone_set('America/Sao_Paulo');
        //$validated['user_id'] = auth()->user()->id;
        //$validated['armario_id'] = $armario->id;

        //$armario->estado = 'Emprestado';
        //$armario->save();

        //$emprestimo = new Emprestimo;
        //$emprestimo->user_id = auth()->user()->id;
        //$emprestimo->armario_id = $armario->id;
        //$emprestimo->save();
      
        
        
        return redirect("/armarios");
        



    }
}


