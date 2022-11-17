@extends('main')
@section('content')
  <form method="POST" action="/armarios">
    @csrf
    @include('armarios.partials.form')
  </form>
@endsection