<ul>
  <li><a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></li>
  <li>{{ $armario->estado }}</li>
  <li><a href="/armarios/{{$armario->id}}/edit">Editar</a></li>
  
  <li>
    <form action="/armarios/{{ $armario->id }} " method="post">
      @csrf
      @method('delete')
      <button type="submit" onclick="return confirm('Tem certeza?');">Apagar</button> 
    </form>
  </li> 
</ul>