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
                                <th colspan="3">Empréstimos ativos</th>
                                <th rowspan="2">Ações</th>
                            </tr>
                            <tr>
                                <th>Aluno(a)</th>
                                <th>Início do empréstimo</th>
                                <th>Data da defesa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($armarios as $armario)
                                <tr>
                                    <td><a href="/armarios/{{ $armario->id }}">{{ $armario->numero }}</a></td>
                                    <td>{{ $armario->estado }}</td>
                                    @if ($armario->emprestimos->isEmpty())
                                        <td colspan="3">Nenhum empréstimo ativo</td>
                                    @else
                                        @foreach ($armario->emprestimos as $emprestimo)
                                            <td>
                                                {{ $emprestimo ? $emprestimo->user->name : '' }}
                                            </td>
                                            <td>
                                                {{ $emprestimo ? Carbon\Carbon::parse($emprestimo->created_at)->format('d/m/Y H:i') : '' }}
                                            </td>
                                            <td>
                                                {{ $emprestimo ? $emprestimo->datafinal : '' }}
                                            </td>
                                        @endforeach
                                    @endif
                                    <td>
                                        @if ($armario->estado === \App\Models\Armario::OCUPADO)
                                            <form action="{{ route('armarios.liberar', $armario) }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Liberar</button>
                                            </form>
                                        @endif
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Tem certeza?');">Bloquear</button>
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Tem certeza?');">Histórico</button>
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
