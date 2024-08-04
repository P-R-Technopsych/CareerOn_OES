@extends('layout.layout-common')

@section('space-work')
    <div class="container">
        <p style="color:black;">Welcome, {{ Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>

        @if ($success == true)
            @if (count($qna) > 0)
                @php
                    $qcount = 1;
                @endphp
                @foreach ($qna as $data)
                    <h5>Q{{ $qcount++ }}. {{ $data['question'][0]['question'] }}</h5>
                    @php
                        $count = 1;
                    @endphp
                    @foreach ($data['question'][0]['answers'] as $answer)
                        <p><b>{{ $acount++ }}.</b>{{ $answer['answer'] }}</p>
                    @endforeach
                    <br>
                @endforeach
            @else
                <h3 style="color:red;", class="text-center">Questions Answers not available</h3>
            @endif
        @else
            <h3 style="color:red;" class="text-center">{{ $msg }}</h3>
        @endif

    </div>
@endsection
