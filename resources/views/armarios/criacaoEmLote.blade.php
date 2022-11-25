@extends('main')
@section('content')<form>
Número inicial: <input type="integer" name="numero_inicial" value="{{ $armario->numero_inicial }}">
Número final: <input type="integer" name="numero_final" value="{{ $armario->numero_final }}">


<select name="estado">
    <option value="" selected=""> - Selecione  -</option>
    @foreach ($armario::estados() as $estado)
        <option value="{{$estado}}" {{ ( $armario->estado == $estado) ? 'selected' : ''}}>
            {{$estado}}
        </option>
    @endforeach

</select>
@csrf
@method('storeEmLote')
<button type="submit">Enviar</button> 



@endsection

