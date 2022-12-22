@extends ('main')

@section('content')

<table class="table table-bordered table-striped table-hover" style="font-size:15px;">
    <tr>
        <th style="vertical-align: middle;">Número</th>
        <th style="vertical-align: middle;">Estado</th>
        <th style="vertical-align: middle;">Emprestado para</th>
        <th style="vertical-align: middle;">Data final de empréstimo</th>
        
       
        
    </tr>
    @foreach($armarios as $armario)
    @php
    if ($armario->emprestimoAtivo() and $armario->emprestimoAtivo()->dataprev == carbon\Carbon::today()->format('d/m/Y') ){
        $color = "table-danger";
        
    }elseif( $armario->emprestimoAtivo() and $armario->emprestimoAtivo()->dataprev <= carbon\Carbon::today()->modify('+7 days')->format('d/m/Y') and $armario->emprestimoAtivo()->dataprev >= carbon\Carbon::today()->format('d/m/Y')  ){
        $color = "table-warning";
    }else{
        $color = "";
    }
    @endphp
    
    <tr class={{$color}}>
        <td> <a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></td>
        <td>{{ $armario->estado }}</td>
        <td>{{ $armario->emprestimos()->where('datafim',null)->first() ? $armario->emprestimos()->where('datafim',null)->first()->user->name : ""}}</td>
        <td >{{ $armario->emprestimoAtivo()->dataprev ?? "" }}</td>

        
    </tr>

    @endforeach

</table>

                     

    
@endsection
