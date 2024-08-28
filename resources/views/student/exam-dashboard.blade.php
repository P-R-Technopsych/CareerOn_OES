@extends('layout.layout-common')

@section('space-work')

    @php
        $time = explode(':', $exam[0]['time']);
    @endphp

    <div class="container">
        <p style="color:black;">Welcome, {{ Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>
        @php
            $qcount = 1;
        @endphp
        @if ($success == true)
            @if (count($qna) > 0)
                <h4 class="text-right time">{{ $exam[0]['time'] }}</h4>
                <form action="{{ route('examSubmit') }}" method="POST" class="mb-5" id="exam_form"">
                    @csrf
                    <input type="hidden" name="exam_id" value="{{ $exam[0]['id'] }}">
                    @php
                        $qcount = 1;
                    @endphp
                    @foreach ($qna as $data)
                        <div>
                            @php
                                $answers = $data['question'][0]['answers']->toArray();
                                shuffle($answers); // Shuffle the answers array
                                $acount = 'A';
                            @endphp
                            <h5><b>Q{{ $qcount++ }}.</b> {{ $data['question'][0]['question'] }}</h5>
                            <input type="hidden" name="q[]" value="{{ $data['question'][0]['id'] }}">
                            <input type="hidden" name="ans_{{ $qcount - 1 }}" id="ans_{{ $qcount - 1 }}">
                            @foreach ($answers as $answer)
                                <p style="color: #808080;"><b>{{ $acount++ }}) </b>{{ $answer['answer'] }}
                                    <input type="radio" name="radio_{{ $qcount - 1 }}" data-id="{{ $qcount - 1 }}"
                                        class="select_ans" value="{{ $answer['id'] }}">
                                </p>
                            @endforeach
                        </div>
                        <br>
                    @endforeach
                    <div class="text-center">
                        <input type="submit" class="btn btn-info">
                    </div>
                </form>
            @else
                <h3 style="color:red;", class="text-center">Questions & Answers not available</h3>
            @endif
        @else
            <h3 style="color:red;" class="text-center">{{ $msg }}</h3>
        @endif

    </div>

    <script>
        $(document).ready(function() {
            $('.select_ans').click(function() {
                var no = $(this).attr('data-id');
                $('#ans_' + no).val($(this).val());
            });

            var time = @json($time);
            $('.time').text(time[0] + ':' + time[1] + ':00 Time Remaining');

            var hours = parseInt(time[0]);
            var minutes = parseInt(time[1]);
            var seconds = 59;

            var timer = setInterval(() => {
                if (hours == 0 && minutes == 0 && seconds == 0) {
                    clearInterval(timer);
                    $('#exam_form').submit();
                }

                if (seconds <= 0) {
                    if (minutes > 0) {
                        minutes--;
                        seconds = 59;
                    } else if (hours > 0) {
                        hours--;
                        minutes = 59;
                        seconds = 59;
                    } else {
                        clearInterval(timer);
                        $('#exam_form').submit();
                    }
                }

                let tempHours = hours.toString().length > 1 ? hours : '0' + hours;
                let tempMinutes = minutes.toString().length > 1 ? minutes : '0' + minutes;
                let tempSeconds = seconds.toString().length > 1 ? seconds : '0' + seconds;

                $('.time').text(tempHours + ':' + tempMinutes + ':' + tempSeconds + ' Time Remaining');

                seconds--;
            }, 1000);


        });

        function isValid() {
            var result = true;
            var qlength = parseInt("{{ $qcount }}") - 1;
            $('.error_msg').remove();
            for (let i = 0; i <= qlength; i++) {
                if ($('#ans_' + i).val() == "") {
                    result = false;
                    $('#ans_' + i).parent().append(
                        '<span style="color:red;" class="error_msg">Please select answer.</span>');
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 10000);
                }
            }

            return result;
        }
    </script>

@endsection
