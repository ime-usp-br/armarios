@extends('main')

@section('content')
    @parent
    <script>
        var armariosLivres = {!! json_encode($armariosLivres) !!};
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

    @if (auth()->check() && auth()->user()->hasRole(['Aluno de pós'])) 
        @if ($armariosLivres && $armariosLivres->isEmpty())
            

        <div class="container">
            <div class="row">
                <div class="col-12 justify-content-center text-center">


                    <h3>Não há nenhum armário livre :-(</h3>
                    <p>&nbsp;</p>
                    <p>Olá, <em>{{ Auth::user()->name }}</em>.</p>

                    <p>Infelizmente há nenhum armário livre no momento. </p>
                    <p>Mas não se preocupe, pois a qualquer momento um armário pode ficar livre.</p>
                    <p>Fique de olho!</p>
                </p>


                   

                </div>
            </div>
        </div>


        @else
            @if ( $emprestimo === null )
                <div id=layout_conteudo>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 justify-content-center text-center">


                                <h3>Você pode pegar um armário emprestado :-)</h3>
                                <p>&nbsp;</p>
                                <p>Olá, <em>{{ Auth::user()->name }}</em>.</p>

                                <p>Você pode solicitar o empréstimo de um dos armários livres. <br />Basta escolher o número
                                    do armário e clicar em solicitar empréstimo. </p>


                                <form method="POST" action="{{ route('armarios.emprestimo') }}">
                                    @csrf

                                    <p>
                                        <select id="selectArmario" name="numero" class="form-control-lg text-center" required>
                                            <option value="">Escolha um armário</option>
                                            @foreach ($armariosLivres as $armario)
                                                <option value="{{ $armario->id }}">{{ $armario->numero }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </p>

                                    <p>

                                        <button id="btn-solicitar-emprestimo" class="btn btn-lg btn-primary m-3 p-3"
                                            type="button" data-toggle="modal"
                                            data-target="#modalSolicitarEmprestimo" disabled>Solicitar
                                            empréstimo</button>

                                    </p>
                                </form>


                                <p>
                                    <button type="button" class="btn btn-link" data-toggle="modal"
                                        data-target="#modalTermos">
                                        Termos e Condições para Uso de Armários
                                    </button>
                                </p>

                            </div>
                        </div>
                    </div>
                @else
                    <div class="container">
                        <div class="row">
                            <div class="col-12 justify-content-center text-center">


                                <h3>Você possui um empréstimo ativo!</h3>
                                <p>&nbsp;</p>
                                <p>Olá, <em>{{ Auth::user()->name }}</em>.</p>
                                <p>Veja as informações sobre o armário que está emprestado para você.</p>




                                <div class="card m-5">
                                    <h5 class="card-header"></h5>
                                    <div class="card-body">



                                        <p><strong>Armário</strong> </p>
                                        <h4>{{ $emprestimo->armario->numero }}</h4>

                                        <p><strong>Desde</strong></p>

                                        <h4>{{ Carbon\Carbon::parse($emprestimo->created_at)->format('d/m/Y H:i') }}</h4>



                                        <form action="{{ route('armarios.liberar', $emprestimo->armario) }}" method="post">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-lg btn-primary m-5 p-3">Liberar
                                                armário</button>
                                        </form>

                                    </div>
                                </div>



                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#modalTermos">
                                    Termos e Condições para Uso de Armários
                                </button>





                            </div>
                        </div>
                    </div>
            @endif

            <div class="modal" id="modalSolicitarEmprestimo">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Cabeçalho do Modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Corpo do Modal -->
                        <div class="modal-body">
                            <!-- Corpo do Modal -->
                            @include('partials.termo')
                        </div>

                        <!-- Rodapé do Modal -->
                        <div class="modal-footer">

                            <form method="POST" action="{{ route('armarios.emprestimo') }}">
                                @csrf
                                <input type="hidden" id="numeroArmario" name="numero" value="">
                                <button type="submit" class="btn btn-primary">Confirmar o empréstimo</button>
                            </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Desistir e fechar</button>
                        </div>
                    </div>
                </div>
            </div>




            <div class="modal" id="modalTermos">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Cabeçalho do Modal -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Corpo do Modal -->
                        @include('partials.termo')
                        <!-- Rodapé do Modal -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
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


                document.getElementById('selectArmario').addEventListener('change', function() {
                    var botaoEnviar = document.getElementById('btn-solicitar-emprestimo');
                    botaoEnviar.disabled = this.value === ''; // Desabilita o botão se nenhuma opção for selecionada
                });

                    



            </script>
        @endsection
    @endif



@endsection
