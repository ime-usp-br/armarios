@extends('main')

@section('content')
    @parent
    <div class="container">
        <div class="row justify-content-center">
            <div>

                <h1> Armários </h1>

                @if (Auth::user()->hasRole(['Admin', 'Secretaria']))
                    <a class="btn btn-primary btn-lg text-center m-3" href="{{ '/armarios/create' }}"><i
                            class="fas fa-plus"></i> Cadastrar armário</a>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">Número</th>
                                <th rowspan="2">Estado</th>
                                <th colspan="2">Empréstimos ativos</th>
                                <th rowspan="2">Ações</th>
                            </tr>
                            <tr>
                                <th>Aluno(a)</th>
                                <th>Início do empréstimo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($armarios as $armario)
                                <tr>
                                    <td><a href="/armarios/{{ $armario->id }}">{{ $armario->numero }}</a>
                                    </td>
                                    <td>{{ $armario->estado }}</td>
                                    @if ($armario->emprestimos->isNotEmpty())
                                        <td>{{ $armario->emprestimos[0]->user->name }}</td>
                                        <td>{{ $armario->emprestimos[0]->created_at->format('d/m/Y H:i') }}</td>
                                    @else
                                        <td></td>
                                        <td></td>
                                    @endif
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                       
                                       
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
                                                <button type="submit" class="btn btn-secondary m-3">Bloquear</button>
                                            </form>
                                        
                                        @endif


                                        @if ($armario->estado === \App\Models\Armario::OCUPADO)
                                        <form action="{{ route('armarios.liberar', $armario) }}" method="post">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-danger m-3" onclick="return confirm('Tem certeza que deseja liberar o armário?');">Liberar</button>
                                        </form>
                                    @endif
                                    
                                        </div>

                                       
                                       
                                        
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                
            </div>
        </div>
    </div>
@endsection
