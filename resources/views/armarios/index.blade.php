@extends('main')

@section('content')
@parent

<table class="table table-bordered table-striped table-hover" style="font-size:15px;">
    <tr>
        <th style="vertical-align: middle;">Número</th>
        <th style="vertical-align: middle;">Estado</th>
        <th style="vertical-align: middle;">Emprestado para</th>
        <th style="vertical-align: middle;">Data da defesa</th>
        <th style="vertical-align: middle;">Data final de empréstimo</th>
        <th style="vertical-align: middle;">Ações</th>
    </tr>
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
        <td>
            @if ($emprestimo)
                {{ $emprestimo->user->name }}
            @else
            @endif
        </td>
        <td>
            @if ($dataprev)
                {{ $dataprev }}
            @else
            @endif
        </td>
        <td>
            @if ($emprestimo)
                {{ $emprestimo->datafinal }}
            @else
            @endif
        </td>
        <td>
            @if ($armario->estado === 'Emprestado')
                <form action="{{ route('armarios.liberar', $armario) }}" method="post">
                    @csrf
                    @method('POST')
                    <button type="submit" onclick="return confirm('Tem certeza?');">Liberar armário</button>
                </form>
            @else
            @endif
        </td>
    </tr>
    @endforeach
</table>

@endsection