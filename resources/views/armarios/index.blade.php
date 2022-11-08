@extends ('main')

@section('content')

@forelse($armarios as $armario)

@include('armarios.partials.fields')
<br>
@empty
    Não há armários cadastrados nesse sistema ainda
@endforelse
@endsection
