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
        $emprestimo = null;

        if (Auth::check()) {
            if ($user->emprestimos->isEmpty()) {
                $armariosLivres = Armario::where("estado", Armario::LIVRE)->get()->sortBy('numero');
            } else {
                $emprestimo = $user->emprestimos->first();
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
        if (Emprestimo::where('user_id', auth()->user()->id)->first()) {
            Session::flash('alert-warning', 'Usuário já possui empréstimo de armário.');
            return back();
        }
        $user = auth()->user();
        $validated = $request->validated();

        $armario = Armario::where("numero", $validated["numero"])->first();
        if ($armario->estado == Armario::LIVRE) {
            $armario->estado = Armario::OCUPADO;

            $armario->save();

            $emprestimo = new Emprestimo;
            $emprestimo->user_id = auth()->user()->id;

            $emprestimo->armario_id = $armario->id;

            
            Mail::to($user->email)->send(new SistemaDeArmarios($user, $armario));
            $secretarias = User::with('roles')->get()->filter(fn ($usuario) => $usuario->roles->where('name', 'Secretaria')->toArray());
            foreach ($secretarias as $secretaria) {
                Mail::to($secretaria->email)->send(new AvisoSecEmprestimo($user, $armario));
            }
            
            $emprestimo->save();
           

            return redirect("/");
        }
    }

    
}
