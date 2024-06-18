@extends('main')

@section('content')
    @parent
    <div class="container">
        <div class="row justify-content-center">
            <div>

                <h1> Armários Emprestados </h1>

                @if (Auth::user()->hasRole(['Admin', 'Secretaria']))
                    
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2">Número</th>
                                <th rowspan="2">Estado</th>
                                <th colspan="3">Empréstimos ativos</th>
                            </tr>
                            <tr>
                                <th>Aluno(a)</th>
                                <th>Início do empréstimo</th>
                                <th>Limite do empréstimo</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($armarios as $armario)
                                <tr>
                                    <td><a href="/armarios/{{ $armario->id }}" class="btn btn-lg btn-secondary">{{ $armario->numero }}</a>
                                    </td>
                                    <td>{{ $armario->estado }}</td>
                                    @if ($armario->emprestimos->isNotEmpty())
                                    <td>{{ $armario->emprestimos->first()->user->name }}</td>
                                    @if ($armario->emprestimos->first()->created_at)
                                        <td>{{ $armario->emprestimos->first()->created_at->format('d/m/Y H:i') }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                    @if ($armario->emprestimos->first()->datafim)
                                        <td>{{ $armario->emprestimos->first()->datafim->format('d/m/Y H:i') }}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
                
            </div>
        </div>
    </div>
@endsection
