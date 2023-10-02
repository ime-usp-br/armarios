@extends('main')

@section('content')
@parent

@if (auth()->check())
    <table class="table table-bordered table-striped table-hover" style="font-size:15px;">
        <tr>
            <th style="vertical-align: middle;">Número</th>
            <th style="vertical-align: middle;">Estado</th>
            <th style="vertical-align: middle;"></th>
        </tr>
        @foreach($armarios as $armario)
            <tr>
                <td>{{ $armario->numero }}</td>
                <td>{{ $armario->estado }}</td>
                <td>
                    <form method="POST" action="{{ route('armarios.emprestimo', $armario) }}">
                        @csrf
                        <button id="btn-addEvent" class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza?');">Solicitar empréstimo</button>
                    </form>

                </td>
            </tr>
            
        @endforeach
    </table>
    <div class="alert alert-danger">
        É necessário estar logado para solicitar empréstimo.
    </div>
@else
    <div class="alert alert-danger">
        É necessário estar logado para solicitar empréstimo.
    </div>
@endif

@endsection