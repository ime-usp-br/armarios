<div class="armario-info">
    <h2>Detalhes do Armário</h2>
    <ul>
        <li><strong>Número:</strong> <a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></li>
        <li><strong>Estado:</strong> <span class="{{ $armario->estado === 'Emprestado' ? 'text-danger' : '' }}">{{ $armario->estado }}</span></li>
        <li><a href="/armarios/{{$armario->id}}/edit" class="btn btn-primary">Editar</a></li>
        @if ($armario->estado === "Emprestado")
            <li><strong>Emprestado para:</strong> {{ $user->name }}</li>
            <li><strong>Data Final do Empréstimo:</strong> {{ $emprestimo->datafinal }}</li>
        @endif
        <li>
            <form action="{{ route('armarios.liberar', $armario) }}" method="post">
              @csrf
              @method('POST')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza?');">Liberar armário</button>
            </form>
        </li> 
    </ul>
</div>
