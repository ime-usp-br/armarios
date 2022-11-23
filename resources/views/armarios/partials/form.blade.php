Número do armário: <input type="integer" name="numero" value="{{ $armario->numero }}">
<select name="estado">
    <option value="" selected=""> - Selecione  -</option>
    @foreach ($armario::estados() as $estado)
        <option value="{{$estado}}" {{ ( $armario->estado == $estado) ? 'selected' : ''}}>
            {{$estado}}
        </option>
    @endforeach
</select>
<button type="submit">Enviar</button>

