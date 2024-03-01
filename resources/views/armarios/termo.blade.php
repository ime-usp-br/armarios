@extends('main')

@section('content')
@parent

<div class="alert alert-warning">
    <h4>Termo de Responsabilidade para uso dos armários</h4>
    <p>
    O uso dos armários é facultativo e se restringe ao período em que o aluno está
    como ativo junto à Pós-Graduação do IME.
    Não é permitida a utilização dos armários para guardar alimentos, bebidas e
    itens molhados (como guarda-chuvas, capas de chuva, etc).
    Os pertences neles depositados são de responsabilidade do usuário. A CPG /
    CCPs não se responsabilizam pelo extravio, dano ou perda de objetos neles
    guardados.
    Estou ciente que, ao defender minha tese / dissertação, terei o prazo de 1 (um)
    mês para desocupá-lo.
    Após este prazo, os pertences serão retirados e guardados por mais 15
    (quinze) dias, sendo doados e destinados da seguinte forma :
    Livros: serão doados para a Biblioteca do Instituto;
    Objetos diversos: serão doados caso haja alguma utilidade.
    </p>
    <form method="POST" action="{{ route('armarios.confirmar-emprestimo', $armario) }}">
        @csrf
        <button class="btn btn-primary" type="submit">Aceitar Termos</button>
    </form>
</div>

@endsection