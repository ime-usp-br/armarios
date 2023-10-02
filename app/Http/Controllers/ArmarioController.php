<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArmarioRequest;
use App\Http\Requests\CriacaoEmLoteArmarioRequest;
use App\Http\Requests\UpdateArmarioRequest;
use App\Models\Armario;
use App\Http\Controllers\EmprestimoController;
use App\Models\Emprestimo;
use Carbon\Carbon;

class ArmarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                // Se o usuário tiver uma dessas roles, continue com a exibição dos armários.
                $armarios = Armario::all()->sortBy("numero");
    
                return view('armarios.index', [
                    'armarios' => $armarios,
                ]);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        $armarios = Armario::all()->sortBy("numero");
        $today = Carbon::today()->format('d/m/Y');
        
        
        
        return view('armarios.index',[
            'armarios' => $armarios,
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                
    
                return view('armarios.create',[
                    'armario' => new Armario,
                ]);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        
    }



    /**
     * Cria armários em lote
     *
     * @return \Illuminate\Http\Response
     */
    public function createEmLote()
    {        
        
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                
    
                return view('armarios.createEmLote',[
                    'armario' => new Armario,
                ]);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        
    }    

    public function storeEmLote(CriacaoEmLoteArmarioRequest $request)
    {
        $validated = $request->validated();
        for ($i = $validated["numero_inicial"]; $i <= $validated["numero_final"]; $i++){
            Armario::firstOrCreate(["numero"=>$i],["estado"=>'Disponível']);
        }

        return redirect("/armarios");
    }
    






    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArmarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArmarioRequest $request)
    {
        $armario = new Armario;
        $armario->numero = $request->numero;
        $armario->estado = 'Disponível';
        $armario->save();
        return redirect("/armarios/{$armario->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function show(Armario $armario)
    {
        $emprestimo = Emprestimo::where('datafim',null)->where('armario_id',$armario->id)->first();
        
        $user = $emprestimo ? $emprestimo->user : null;
       
        return view('armarios.show',[
            'armario' => $armario,
            'emprestimo' => $emprestimo,
            'user' => $user,


        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function edit(Armario $armario)
    {
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                
    
                return view('armarios.edit',[
                    'armario' => $armario
                ]);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArmarioRequest  $request
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArmarioRequest $request, Armario $armario)
    {
        $armario->numero = $request->numero;
        $armario->estado = $request->estado;
        
        $armario->save();
        return redirect("/armarios/{$armario->id}");
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Armario $armario)
    {
        $armario->delete();
        return redirect('/armarios');
    }

    public function getEmprestimoAtivo()
    {
        return view('armarios.create',[
            'armario' => new Armario,
        ]);
    }
    public function emprestimoAtivo()
    {
        return $this->emprestimos()->whereNull('datafim')->first();
    }
    
    public function liberar(Armario $armario)
    {
        // Verifique se há um empréstimo ativo para este armário
        $emprestimo = $armario->emprestimoAtivo();

        if ($emprestimo) {
            // Exclua o registro de empréstimo
            $emprestimo->delete();
        }

            // Atualize o estado do armário para "Disponível"
        $armario->update(['estado' => 'Disponível']);

        // Redirecione de volta para a página de listagem de armários ou para onde desejar
        return redirect()->route('armarios.index')->with('success', 'Armário liberado com sucesso.');
    }
    
   
}
