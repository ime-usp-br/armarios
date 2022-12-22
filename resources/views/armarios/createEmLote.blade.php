@extends('main')
@section('content')

<form action='{{route("armarios.storeEmLote")}}' method='post'>
@csrf
@method('POST')
Número inicial: <input type="number" name="numero_inicial" value="{{ $armario->numero_inicial }}">
Número final: <input type="number" name="numero_final" value="{{ $armario->numero_final }}">
<button type="submit">Enviar</button> 

</form>


@endsection

