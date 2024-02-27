
@extends('main')

@section('content')
@parent
<script>
    var armariosDisponiveis = {!! json_encode($armarios) !!};
</script>

@if (session('success'))
    <div id=layout_conteudo>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('alert-warning'))
    <div id=layout_conteudo>
        <div class="alert alert-warning">
            {{ session('alert-warning') }}
        </div>
    </div>
@endif

@if (auth()->check())
    @if ($armarios->isEmpty())
        <div id=layout_conteudo>
            <div class="alert alert-info">
                Todos os armários estão ocupados no momento.
            </div>
        </div>
    @else
    <div id=layout_conteudo>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" style="font-size:15px;">
                            <thead>
                                <tr>
                                    <th>Selecionar Armário</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <form method="POST" action="{{route('armarios.emprestimo')}}">
                                    @csrf
                                    
                                    <td>
                                        <select id="selectArmario" name="numero" class="form-control">
                                            @foreach($armarios as $armario)
                                            <option value="{{ $armario->id }}">{{ $armario->numero }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button id="btn-solicitar-emprestimo" class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modalSolicitarEmprestimo">Solicitar empréstimo</button>
                                    </td>
                                </form>
                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal" id="modalSolicitarEmprestimo">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Cabeçalho do Modal -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Termos e Condições</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Corpo do Modal -->
                                            <div class="modal-body">
                                                <p>O uso dos armários é facultativo e se restringe ao período em que o aluno está ativo junto à Pós-Graduação do IME. 
                                                    Não é permitida a utilização dos armários para guardar alimentos, bebidas e itens molhados (como guarda-chuvas, capas de chuva, etc). Os pertences neles depositados são de responsabilidade do usuário. A CPG / CCPs não se responsabilizam pelo extravio, dano ou perda de objetos neles guardados. Estou ciente que, ao defender minha tese / dissertação, terei o prazo de 1 (um) mês para desocupá-lo. Após este prazo, os pertences serão retirados e guardados por mais 15 (quinze) dias, sendo doados e destinados da seguinte forma: Livros serão doados para a Biblioteca do Instituto; Objetos diversos serão doados caso haja alguma utilidade.</p>
                                            </div>

                                            <!-- Rodapé do Modal -->
                                            <div class="modal-footer">
                                                
                                                <form method="POST" action="{{ route('armarios.emprestimo') }}">
                                                    @csrf
                                                    <input type="hidden" id="numeroArmario" name="numero" value="">
                                                    <button type="submit" class="btn btn-primary">Confirmar Empréstimo</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>       

    @endif
@section('javascripts_bottom')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            document.getElementById("selectArmario").addEventListener("change", function() {
                var numeroSelecionado = this.value;
                document.getElementById("numeroArmario").value = numeroSelecionado;
            });
        });
    </script>
@endsection

@else
    <div class="jumbotron">
    <div style="font-family: Arial, sans-serif; line-height: 1.6;">
    <h1 style="text-align: center;">Bem-vindo ao Sistema de Gerência de Armários</h1>
    
    <p>O Sistema de Gerência de Armários é uma iniciativa dedicada a oferecer comodidade e praticidade aos alunos de pós-graduação do IME-USP.</p>

    <p>Como parte de nosso compromisso em apoiar sua jornada acadêmica, todo aluno de pós-graduação tem o direito a um armário pessoal durante o período em que estiver matriculado em qualquer programa de pós-graduação.</p>

    <p>Esses armários são projetados para auxiliar na organização e armazenamento de materiais essenciais, proporcionando um ambiente de estudo mais eficaz e conveniente.</p>

    <p>Estamos aqui para tornar sua experiência acadêmica mais fluida e produtiva, e nosso sistema de gerência de armários é mais uma maneira de atender a essa necessidade.</p>

    <p>Você ainda não fez seu login com a senha única USP. <a href="login">Faça seu login!</a>
</p>
</div>
    </div>

@endif



@endsection


