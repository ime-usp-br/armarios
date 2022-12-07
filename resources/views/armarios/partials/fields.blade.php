<ul>
  <li><a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></li>
  <li>{{ $armario->estado }}</li>
  <li><a href="/armarios/{{$armario->id}}/edit">Editar</a></li>
  @if ($armario->estado === "Emprestado")
    <li> Emprestado para {{ $user->name }} às {{ $emprestimo->updated_at }} </li>
  @endif
    <li>
    <form action="/armarios/{{ $armario->id }} " method="post">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
  </li> 
</ul>