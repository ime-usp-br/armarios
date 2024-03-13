<style>
  .form-element {
      font-size: 18px;
  }
</style>
@extends('main')

@section('content')
@parent
<div id=layout_conteudo>
  <div style="display: flex; justify-content: center;">
      <form action='{{route("armarios.store")}}' method='post' class="form-element">
          @csrf
          @method('POST')
          <div style="text-align: center;">
              <label for="numero_inicial" class="form-element">Número inicial:</label><br>
              <input type="number" name="numero_inicial" value="{{ $armario->numero_inicial }}" class="form-element"><br><br>
              
              <label for="numero_final" class="form-element">Número final:</label><br>
              <input type="number" name="numero_final" value="{{ $armario->numero_final }}" class="form-element"><br><br>
              
              <button type="submit" class="form-element">Enviar</button> 
          </div>
      </form>
  </div>
</div>
@endsection