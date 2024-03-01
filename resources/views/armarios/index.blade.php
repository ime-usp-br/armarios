@extends('main')

@section('content')
@parent
<div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">


                    @if(Auth::user()->hasRole(['Admin',"Secretaria"]))
                         <a  class="btn btn-primary btn-lg text-center m-3" href="{{'/armarios/create'}}"><i class="fas fa-plus"></i> Cadastrar armário</a>
                    @endif


                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" style="font-size:15px;">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Emprestado para</th>
                                    <th>Data da defesa</th>
                                    <th>Data final de empréstimo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($armarios as $armario)
                                @php
                                $color = "";
                                $emprestimo = $armario->emprestimoAtivo();
                                $dataprev = null; // Inicializa a variável $dataprev com nulo

                                if ($emprestimo) {
                                    $dataPrevista = DateTime::createFromFormat('d/m/Y', $emprestimo->dataprev);
                                    $dataFinal = DateTime::createFromFormat('d/m/Y', $emprestimo->datafinal);

                                    if ($dataPrevista && $dataFinal) {
                                        if ($dataPrevista->format('Y-m-d') <= \Carbon\Carbon::today()->format('Y-m-d') &&
                                            \Carbon\Carbon::today()->format('Y-m-d') <= $dataFinal->format('Y-m-d')) {
                                            $color = "table-danger";
                                        }
                                    }

                                    // Busca a data mais recente da defesa do usuário
                                    $dataprev = \App\Models\Emprestimo::where('user_id', $emprestimo->user->id)->pluck('dataprev')->first();
                                }
                                @endphp

                                <tr class={{$color}}>
                                    <td><a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></td>
                                    <td>{{ $armario->estado }}</td>
                                    <td>{{ $emprestimo ? $emprestimo->user->name : '' }}</td>
                                    <td>{{ $dataprev }}</td>
                                    <td>{{ $emprestimo ? $emprestimo->datafinal : '' }}</td>
                                    <td>
                                        @if ($armario->estado === 'Emprestado')
                                            <form action="{{ route('armarios.liberar', $armario) }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Liberar armário</button>
                                            </form>
                                        @endif
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
