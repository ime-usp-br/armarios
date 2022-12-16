<ul>
  <li>Número: <a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></li>
  <li>Estado: {{ $armario->estado }}</li>
  <li><a href="/armarios/{{$armario->id}}/edit">Editar</a></li>
  @if ($armario->estado === "Emprestado")
    <li> Emprestado para {{ $user->name }} em {{ $emprestimo->updated_at->format('d/m/Y') }} </li>
  @endif
    <li>
    <form action="/armarios/{{ $armario->id }} " method="post">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
  </li> 
</ul>