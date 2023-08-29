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
                <td> <a href="/armarios/{{$armario->id}}">{{ $armario->numero }}</a></td>
                <td>{{ $armario->estado }}</td>
                <td>
                    <form method="POST" action="{{ route('armarios.emprestimo', $armario) }}">
                        @csrf
                        <button id="btn-addEvent" class="btn btn-outline-primary" type="submit">Solicitar empréstimo</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@else
    <div class="alert alert-danger">
        É necessário estar logado para solicitar empréstimo.
    </div>
@endif

@endsection