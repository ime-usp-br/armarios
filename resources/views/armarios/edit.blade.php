@extends('main')
@section('content')
  <form method="POST" action="/armarios/{{ $armario->id }}">
    @csrf
    @method('patch')
    @include('armarios.partials.form')
  </form>
@endsection