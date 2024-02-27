@extends('laravel-usp-theme::master')

@section('styles')
  @parent
  <link rel="stylesheet" href="{{ asset('css/app.css').'?version=3' }}" />
  <link rel="stylesheet" href="{{ asset('css/listmenu_v.css').'?version=2' }}" />
@endsection

@section('content')
@if ($errors->any())
    <div id="layout_conteudo">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
<div id="layout_conteudo">
    <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
        <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        <?php Session::forget('alert-' . $msg) ?>
        @endif
    @endforeach
    </div>
</div>
    @if(Auth::check())
        <div id="layout_menu">
            <ul id="menulateral" class="menulist">
                <li class="menuHeader">Acesso Restrito</li>
                <li>
                    <a href="/">Página Inicial</a>
                </li>
                @if(Auth::user()->hasRole(['Admin',"Secretaria"]))
                    <li>
                        <a href="/armarios">Armários</a>
                    </li>
                @endif
                @if(Auth::user()->hasRole(['Admin',"Secretaria"]))
                    <li>
                        <a href="/armarios/create">Cadastrar armários</a>
                    </li>
                @endif
                @if(Auth::user()->hasRole(['Admin',"Secretaria"]))
                    <li>
                        <a href="/armarios/create/emLote">Cadastrar armários em lote</a>
                    </li>
                @endif
                @if(Auth::user()->hasRole(['Admin',"Secretaria"]))
                    <li>
                        <a href="{{ route('users.index') }}">Usuários</a>
                        <ul>
                            <li>
                                <a href="{{ route('SenhaunicaLoginAsForm') }}">Logar Como</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->hasRole(['Aluno de pós']))
                    <?php $emprestimo = \App\Models\Emprestimo::where('user_id',Auth::user()->id)->first() ?>
                    @if($emprestimo)
                        <li>
                            <a href="/armarios/{{$emprestimo->armario_id}}">Meu armário</a>
                        </li>
                    @else
                        <li>
                            
                        </li>
                    @endif
                @endif
            </ul>
        </div>
    @endif
@endsection