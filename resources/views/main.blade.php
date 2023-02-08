@extends('laravel-usp-theme::master')

@section('content')
<div class="flash-message">
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(Session::has('alert-' . $msg))
    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
    <?php Session::forget('alert-' . $msg) ?>
    @endif
@endforeach
</div>
@endsection