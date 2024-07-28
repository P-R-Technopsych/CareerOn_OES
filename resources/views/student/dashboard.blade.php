@extends('layout.$tudent-layout')

@section('space-work')
    <h2>Exams</h2>
    <table class="table">
        <thead>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject Name</th>
            <th>Date</th>
            <th>Time</th>
            <th>Total Attempt</th>
            <th>Available Attempt</th>
            <th>Copy Link</th>
        </thead>
    </table>

    <tbody>
        @if (count($exams) > 0)
            @php $count = 1; @endphp
            @foreach ($exams as $exam)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $exam->exam_name }}</td>
                    <td>{{ $exam->subjects[0]['subject'] }}</td>
                    <td>{{ $exam->date }}</td>
                    <td>{{ $exam->time }} Hrs</td>
                    <td>{{ $exam->attempt }} Time</td>
                    <td></td>
                    <td><a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="fa fa-copy"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8">No Exams Availablel</td>
            </tr>

            <script>
                $(document).ready(function() {
                    $(this).parent().prepend('<span class="copied_text">Copied</span>');


                    var $temp = $("<input>");
                    $("body").append($temp);
                    $temp.val(url).select();
                    document.execCommand("copy");
                    $temp.remove();

                    setTimeout(() => {
                        $('.copied_text').remove();
                    }, 1000);
                });
            @endsection
