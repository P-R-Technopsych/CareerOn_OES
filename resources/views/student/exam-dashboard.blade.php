@extends('layout.layout-common')

@section('space-work')
    <div class="container">
        <p style="color:black;">Welcome, {{ Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>

        @if ($success == true)
        @else
            <h3 style="color:red;" class="text-center">{{ $msg }}</h3>
        @endif

    </div>
@endsection
