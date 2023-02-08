@extends ('main')

@section('content')
@parent



<form action="{{route('armarios.emprestimo') }}" method='post'>
@csrf
@method('POST')
Número do armário desejado: <input type="number" name="numero" >
<button type="submit">Enviar</button> 

</form>






                     

    
@endsection