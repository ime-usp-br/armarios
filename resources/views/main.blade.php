@extends('laravel-usp-theme::master')

@section('styles')
    @parent
    <link rel="stylesheet" href="{{ asset('css/app.css') . '?version=3' }}" />
    <link rel="stylesheet" href="{{ asset('css/listmenu_v.css') . '?version=2' }}" />
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
                @if (Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                    <?php Session::forget('alert-' . $msg); ?>
                @endif
            @endforeach
        </div>
    </div>
    @if (Auth::check())
        @if (Auth::check() && 
            (
                Auth::user()->hasRole(['Admin', 'Secretaria']) || 
                Auth::user()->hasPermissionTo('admin')
            )
            )
            <div id="layout_menu">
                <ul id="menulateral" class="menulist">
                    <li class="menuHeader">Acesso Restrito</li>
                    <li>
                        <a href="/armarios">Armários</a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">Usuários</a>
                        <ul>
                            <li>
                                <a href="{{ route('SenhaunicaLoginAsForm') }}">Logar Como</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        @endif
    @endif
@endsection
