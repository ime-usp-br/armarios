Número do armário: <input type="number" name="numero" value="{{ $armario->numero }}">
<br><select name="estado">
    <option value="" selected=""> - Estado  -</option>
    @foreach ($armario::estados() as $estado)
        <option value="{{$estado}}" {{ ( $armario->estado == $estado) ? 'selected' : ''}}>
            {{$estado}}
        </option>
    @endforeach
</select>
<br>
<button type="submit">Enviar</button>

