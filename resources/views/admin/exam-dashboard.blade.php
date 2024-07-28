@extends('layout/admin-layout')

@section('space-work')

<h2 class="mb-4">Exams</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExamModel">
  Add Exam
</button>

<table class="table">
  <thead>
    <tr>
      <th>#</th>
      <th>Exam Name</th>
      <th>Subject</th>
      <th>Date</th>
      <th>Time</th>
      <th>Edit</th>
    </tr>
  </thead>

  <tbody>
    @if(count($exams) > 0 )
      @foreach($exams as $exam)
         <tr>
            <td>{{ $exam->id }}</td>
            <td>{{ $exam->exam_name }}</td>
            <td>{{ $exam->subjects[0]['subject'] }}</td>
            <td>{{ $exam->date }}</td>
            <td>{{ $exam->time }} Hrs</td>
            <td>
              <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#editExamModel" >Edit</button>
            </td>
         </tr>
      @endforeach
    @else
      <tr>
        <td colspan="5">Exams Not Found</td>
      </tr>
    @endif
  </tbody>
</table>

<!-- Add Exam Modal -->
<div class="modal fade" id="addExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Exam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addExam">
        @csrf
            <div class="modal-body">
            <input type="text" name="exam_name" placeholder="Enter Exam Name" class="w-100" required>
            <br><br>
            <select name="subject_id" required class="w-100" >
                <option value="">Select Subject</option>
                @if( count($subjects) > 0 )
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                    @endforeach
                @endif
            </select>
            <br><br>
            <input type="date" name="date"  class="w-100" required  min="@php echo date('Y-m-d'); @endphp">
            <br><br>
            
            <input type="time" name="time" placeholder="select Time duration" class="w-100" id='examTime' required >

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Exam</button>
            </div>
            </form>
      </div>
  </div>
</div>

<!-- edit Exam Modal -->
<div class="modal fade" id="editExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Edit Exam</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editExam">
        @csrf
            <div class="modal-body">
            <input type="text" name="exam_name" placeholder="Enter Exam Name" class="w-100" required>
            <br><br>
            <select name="subject_id" required class="w-100" >
                <option value="">Select Subject</option>
                @if( count($subjects) > 0 )
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                    @endforeach
                @endif
            </select>
            <br><br>
            <input type="date" name="date"  class="w-100" required  min="@php echo date('Y-m-d'); @endphp">
            <br><br>
            
            <input type="time" name="time" placeholder="select Time duration" class="w-100" id='editexamTime' required >

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
      </div>
  </div>
</div>


<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var examTimeInput = document.getElementById('examTime');
    if (examTimeInput) {
      flatpickr(examTimeInput, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        //minuteIncrement: 1,
      });
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    var examTimeInput = document.getElementById('editexamTime');
    if (examTimeInput) {
      flatpickr(examTimeInput, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        //minuteIncrement: 1,
      });
    }
  });
</script>

<script>
    $(document).ready( function(){
    $("#addExam").submit(function(e){
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url:"{{ route('addExam') }}",
            type:"POST",
            data:formData,
            success:function(data){
                if(data.success == true){
                    location.reload();
                }
                else{
                    alert(data.msg);
                }
            }
        });

    });
  } )
</script>



@endsection