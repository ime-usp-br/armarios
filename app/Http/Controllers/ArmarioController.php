<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArmarioRequest;
use App\Http\Requests\CriacaoEmLoteArmarioRequest;
use App\Http\Requests\UpdateArmarioRequest;
use App\Models\Armario;
use App\Http\Controllers\EmprestimoController;
use App\Models\Emprestimo;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiberarArmario;
use App\Mail\AvisoSecLiberar;
use App\Events\ArmarioLiberado;
use App\Listeners\EnviarEmailsArmarioLiberado;


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

                $armarios = Armario::with(['emprestimos' => function ($query) {
                    $query->where('estado', 'ATIVO');
                }, 'emprestimos.user'])
                    ->get();




                return view('armarios.index', [
                    'armarios' => $armarios,
                ]);
            }
        }

        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        $armarios = Armario::all()->sortBy("numero");
        $today = Carbon::today()->format('d/m/Y');



        return view('armarios.index', [
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


                return view('armarios.create', [
                    'armario' => new Armario,
                ]);
            }
        }

        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArmarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArmarioRequest $request)
    {
        $validated = $request->validated();

        if ($validated['numero_final'] == NULL) {
            $armario = new Armario;
            $armario->numero = $validated['numero_inicial'];
            $armario->estado = Armario::LIVRE;
            $armario->save();
        }

        for ($i = $validated["numero_inicial"]; $i <= $validated["numero_final"]; $i++) {
            Armario::firstOrCreate(["numero" => $i], ["estado" => Armario::LIVRE]);
        }

        return redirect("/armarios");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function show(Armario $armario)
    {
        $emprestimos = Emprestimo::where('armario_id', $armario->id)->get();

        
        return view('armarios.show', compact('armario', 'emprestimos'));
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


                return view('armarios.edit', [
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
        return view('armarios.create', [
            'armario' => new Armario,
        ]);
    }
    public function emprestimoAtivo()
    {
        return $this->emprestimos()->whereNull('datafim')->first();
    }

    public function liberar(Armario $armario)
    {
        $usuarioLogado = auth()->user();

        if ($armario->emprestimos()->where('estado', 'ATIVO')->exists()) {
            $emprestimo = $armario->emprestimos()->where('estado', 'ATIVO')->first();


            $user = User::findOrFail($emprestimo->user_id);

            if ($usuarioLogado->hasRole('Secretaria')) {
                Mail::to($user->email)->send(new LiberarArmario($user, $armario));
            } elseif ($usuarioLogado->hasRole('Aluno de pós')) {
                $secretarias = User::with('roles')->get()->filter(fn ($usuario) => $usuario->roles->where('name', 'Secretaria')->toArray());
                foreach ($secretarias as $secretaria) {
                    \Log::info('Enviando email para secretaria: ', ['email' => $secretaria->email]);
                    Mail::to($secretaria->email)->send(new AvisoSecLiberar($user, $armario));
                }
            }

            $armario->update(['estado' => Armario::LIVRE]);
            $emprestimo->estado = Emprestimo::ENCERRADO;
            $emprestimo->datafim = Carbon::now();
            $emprestimo->update();

            return redirect()->route('emprestimos.index')->with('success', 'Armário liberado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'O armário não possui empréstimo ativo.');
        }
    }




    public function bloquear(Armario $armario)
    {
        if ($armario->emprestimos()->where('estado', 'ATIVO')->exists()) {
            $this->liberar($armario);
        }

        $armario->estado = Armario::BLOQUEADO;
        $armario->save();
        return redirect()->route('armarios.index');
    }


    public function desbloquear(Armario $armario)
    {
        $armario->estado = Armario::LIVRE;
        $armario->save();
        return redirect()->route('armarios.index');
    }

    public function armariosEmprestados()
    {
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                // Se o usuário tiver uma dessas roles, continue com a exibição dos armários.

                $armarios = Armario::where('estado', 'OCUPADO')
                ->whereHas('emprestimos')
                ->with(['emprestimos' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }, 'emprestimos.user'])
                ->get();



                return view('armarios.emprestimos', [
                    'armarios' => $armarios,
                ]);
            }
        }

        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        abort(403);
        $armarios = Armario::all()->sortBy("numero");
        $today = Carbon::today()->format('d/m/Y');



        return view('armarios.emprestimos', [
            'armarios' => $armarios,

        ]);
    }
}
