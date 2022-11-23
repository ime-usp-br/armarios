@extends ('main')

@section('content')

<table class="table table-bordered table-striped table-hover" style="font-size:15px;">
    <tr>
        <th style="vertical-align: middle;">Número</th>
        <th style="vertical-align: middle;">Estado</th>
        
       
        
    </tr>
    @foreach($armarios as $armario)
    <tr> 
        <td> <a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></td>
        <td>{{ $armario->estado }}</td>
        
    </tr>

    @endforeach

</table>

                     

    
@endsection
