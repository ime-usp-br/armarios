@extends('main')
@section('content')
  <form method="POST" action="/armarios/criacaoEmLote">
    @csrf
    @csrf
    @method('criacaoEmLote')
    @include('armarios.partials.form')
  </form>
@endsection