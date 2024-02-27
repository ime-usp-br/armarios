<style>
    .form-element {
        font-size: 18px;
    }
</style>
@extends('main')
@section('content')
@parent
<div style="display: flex; justify-content: center;">
  <form method="POST" action="/armarios">
    @csrf
    @include('armarios.partials.form')
    
  </form>
<div>
@endsection