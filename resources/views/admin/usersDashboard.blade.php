@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Students</h2>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModel">
        Add Student
    </button>

    <a href="{{ route('exportStudents') }}" class="btn btn-primary">Export Students</a>

    <table class="table">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if (count($students) > 0)
                @php
                    $s_no = 1;
                @endphp
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $s_no }}</td><!--<td>{{ $student->id }}</td>-->
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <button type="button" data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                data-email="{{ $student->email }}" class="btn btn-info editButton" data-toggle="modal"
                                data-target="#editStudentModel">
                                Edit
                            </button>
                        </td>
                        <td>
                            <button type="button" data-id="{{ $student->id }}" class="btn btn-danger deleteButton"
                                data-toggle="modal" data-target="#deleteStudentModel">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @php $s_no++; @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="3">Students not Found!</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Add Exam Modal -->
    <div class="modal fade" id="addStudentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
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
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="name" placeholder="Enter Student Name"
                                    required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" placeholder="Enter Student email"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="w-100" name="name" id="name"
                                    placeholder="Enter Student Name" required>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" id="email"
                                    placeholder="Enter Student email" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updateButton">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Student Modal -->
    <div class="modal fade" id="deleteStudentModel" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Delete Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="deleteStudent">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete Student?</p>
                        <input type="hidden" name="id" id="student_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addStudent").submit(function(e) {
                e.preventDefault();

                // Disable the submit button to prevent multiple clicks
                var $submitButton = $(this).find("button[type='submit']");
                $submitButton.prop("disabled", true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('addStudent') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    },
                    complete: function() {
                        // Re-enable the submit button after the request is complete
                        $submitButton.prop("disabled", false);
                    }
                });
            });

            //edit button and show values
            $(".editButton").click(function() {

                $("#id").val($(this).attr('data-id'));
                $("#name").val($(this).attr('data-name'));
                $("#email").val($(this).attr('data-email'));

            });

            $("#editStudent").submit(function(e) {
                e.preventDefault();

                $('.updateButton').prop('disable', true);

                // Disable the submit button to prevent multiple clicks
                var $submitButton = $(this).find("button[type='submit']");
                $submitButton.prop("disabled", true);

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('editStudent') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    },
                    complete: function() {
                        // Re-enable the submit button after the request is complete
                        $submitButton.prop("disabled", false);
                    }
                });
            });


            $(".deleteButton").click(function() {
                var id = $(this).attr('data-id');
                $("#student_id").val(id);
            });


            $("#deleteStudent").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('deleteStudent') }}",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });


        });
    </script>

@endsection
