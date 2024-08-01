@extends('layout/admin-layout')

@section('space-work')

<h2 class="mb-4">Students</h2>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModel">
  Add Student
</button>

<table class="table">
    <thead>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
    </thead>
    <tbody>
        @if(count($students) > 0 )
            @php 
            $s_no = 1;
            @endphp
            @foreach($students as $student)
            
                <tr>
                    <td>{{ $s_no }}</td><!--<td>{{ $student->id }}</td>-->
                    <td>{{ $student->name  }}</td>
                    <td>{{ $student->email  }}</td>
                </tr>
                @php $s_no++; @endphp
            @endforeach
        @else
            <tr>
                <td colspan="3" >Students not Found!</td>
            </tr>
        @endif
    </tbody>
</table>

<!-- Add Exam Modal -->
<div class="modal fade" id="addStudentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addStudent">
            @csrf
            <div class="modal-body">
                <div class="row" >
                    <div class="col">
                        <input type="text" class="w-100" name="name" placeholder="Enter Student Name" required >
                    </div>
                </div>
                <div class="row mt-3" >
                    <div class="col">
                        <input type="email" class="w-100" name="email" placeholder="Enter Student email" required >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" >Add Student</button>
            </div>
        </form>
      </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $("#addStudent").submit(function(e){
            e.preventDefault();

            // Disable the submit button to prevent multiple clicks
            var $submitButton = $(this).find("button[type='submit']");
            $submitButton.prop("disabled", true);

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('addStudent') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }
                    else{
                        alert(data.msg);
                    }
                },
                complete: function(){
                    // Re-enable the submit button after the request is complete
                    $submitButton.prop("disabled", false);
                }
            });
        });
    });
</script>

@endsection