@extends('main')

@section('content')
@parent

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('alert-warning'))
    <div class="alert alert-warning">
        {{ session('alert-warning') }}
    </div>
@endif

@if (auth()->check())
    @if ($armarios->isEmpty())
        <div class="alert alert-info">
            Todos os armários estão ocupados no momento.
        </div>
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" style="font-size:15px;">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($armarios as $armario)
                                    <tr>
                                        <td>{{ $armario->numero }}</td>
                                        <td>{{ $armario->estado }}</td>
                                        <td>
                                            <button id="btn-solicitar-emprestimo-{{ $armario->numero }}" class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modalSolicitarEmprestimo-{{ $armario->numero }}">Solicitar empréstimo</button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal" id="modalSolicitarEmprestimo-{{ $armario->numero }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Cabeçalho do Modal -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Termos e Condições</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Corpo do Modal -->
                                            <div class="modal-body">
                                                <p>O uso dos armários é facultativo e se restringe ao período em que o aluno está ativo junto à Pós-Graduação do IME. Não é permitida a utilização dos armários para guardar alimentos, bebidas e itens molhados (como guarda-chuvas, capas de chuva, etc). Os pertences neles depositados são de responsabilidade do usuário. A CPG / CCPs não se responsabilizam pelo extravio, dano ou perda de objetos neles guardados. Estou ciente que, ao defender minha tese / dissertação, terei o prazo de 1 (um) mês para desocupá-lo. Após este prazo, os pertences serão retirados e guardados por mais 15 (quinze) dias, sendo doados e destinados da seguinte forma: Livros serão doados para a Biblioteca do Instituto; Objetos diversos serão doados caso haja alguma utilidade.</p>
                                            </div>

                                            <!-- Rodapé do Modal -->
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('armarios.emprestimo', $armario) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Confirmar Empréstimo</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    <div class="jumbotron">
        <!-- Conteúdo do jumbotron -->
    </div>
@endif

@endsection
