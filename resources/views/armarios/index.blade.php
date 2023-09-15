@extends('main')

@section('content')

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
    if ($armario->emprestimoAtivo() && $armario->emprestimoAtivo()->dataprev <= \Carbon\Carbon::today()->format('d/m/Y') && \Carbon\Carbon::today()->format('m/d/Y') <= $armario->emprestimoAtivo()->datafinal) {
    $color = "table-danger";
    } else {
    $color = "";
    }
    $emprestimo = $armario->emprestimoAtivo();
    @endphp

    <tr class={{$color}}>
        <td><a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></td>
        <td>{{ $armario->estado }}</td>
        <td>
            @if ($emprestimo)
                {{ $emprestimo->user->name }}
            @else
                <!-- Exibir um valor vazio ou mensagem quando não houver empréstimo -->
            @endif
        </td>
        <td>
            @if ($emprestimo)
                {{ $emprestimo->dataprev }}
            @else
                <!-- Exibir um valor vazio ou mensagem quando não houver empréstimo -->
            @endif
        </td>
        <td>
            @if ($emprestimo)
                {{ $emprestimo->datafinal }}
            @else
                <!-- Exibir um valor vazio ou mensagem quando não houver empréstimo -->
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
            <!-- Exibir uma mensagem ou valor vazio quando o estado não for "Emprestado" -->
            @endif
        </td>
    </tr>

    @endforeach

</table>

@endsection