<div class="armario-info">


    <div class="container">
        <div class="row justify-content-center d-block">










            <h1 class="text-center"><span class="badge badge-secondary p-4">{{ $armario->numero }} </span></h1>


            <p class="text-center"><span class="badge badge-info m-3 p-2">{{ $armario->estado }}</span></h1>




            <div class="d-flex justify-content-center btn-toolbar" role="toolbar">

                <div class="btn-group m-2" role="group">

                    @if ($armario->estado === \App\Models\Armario::BLOQUEADO)
                        <form action="{{ route('armarios.desbloquear', $armario) }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-primary m-3">Desbloquear</button>
                        </form>
                    @else
                        <form action="{{ route('armarios.bloquear', $armario) }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-warning m-3">Bloquear</button>
                        </form>
                    @endif


                    @if ($armario->estado === \App\Models\Armario::OCUPADO)
                        <form action="{{ route('armarios.liberar', $armario) }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success m-3"
                                onclick="return confirm('Tem certeza que deseja liberar o armário?');">Liberar</button>
                        </form>
                    @endif

                    <form>
                        <a href="{{ route('armarios.index') }}" class="btn btn-primary m-3" role="button">Voltar</a>
                    </form>
                </div>



            </div>





            <div class="m-5" />

            <h2 class="text-center">Histórico de empréstimos do armário</h2>


            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Aluno(a)</th>
                            <th>Início</th>
                            <th>Término</th>
                            <th>Situação</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emprestimos as $emprestimo)
                            <tr>
                                <td>{{ $emprestimo->user->name }} ( {{ $emprestimo->user->codpes }} )</td>
                                <td>{{ $emprestimo->created_at ? \Carbon\Carbon::parse($emprestimo->created_at)->format('d/m/Y H:i') : '' }}
                                </td>
                                <td>{{ $emprestimo->datafim ? \Carbon\Carbon::parse($emprestimo->datafim)->format('d/m/Y H:i') : '' }}
                                </td>
                                <td>{{ $emprestimo->estado }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>


        </div>


    </div>
</div>
