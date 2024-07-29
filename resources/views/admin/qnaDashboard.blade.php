@extends('layout/admin-layout')

@section('space-work')

<h2 class="mb-4">Q&A</h2>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQnaModel">
  Add Q&A
</button>


<!-- Add Exam Modal -->
<div class="modal fade" id="addQnaModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Q&A</h5>

          <button id="addAnswer" class="ml-5 btn btn-info" >Add Answer</button>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addQna" >
            @csrf
            <div class="modal-body">
                <div class="row" >
                    <div class="col">
                        <input type="text" class="w-100" name="question" placeholder="Enter Question" required >
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="error" style="color:red;"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Q&A</button>
            </div>
        </form>
      </div>
  </div>
</div>

<script>
    $(document).ready( function(){

        //form submission
        $('#addQna').submit(function(e){
            e.preventDefault();

            if ($(".answers").length < 2) {
                $(".error").text("please add minimum two answers");
                setTimeout( function(){
                    $(".error").text("");
                }, 2000);
            } else {
                var checkIsCorrect = false;

                for(let i=0; i < $(".is_correct").length; i++ ){
                    if ( $(".is_correct:eq("+i+")").prop('checked') == true ) {
                        checkIsCorrect = true;
                        $(".is_correct:eq("+i+")").val( $(".is_correct:eq("+i+")").next().find('input').val() );
                        
                    }
                }

                if (checkIsCorrect) {
                    
                    var formData = $(this).serialize();

                    $.ajax({
                        url:"{{ route('addQna') }}",
                        type:"POST",
                        data:formData,
                        success:function(data){
                            console.log(data);
                            if(data.success == true){
                                location.reload();
                            }
                            else{
                                alert(data.msg);
                            }
                        }
                    });

                } else {
                    $(".error").text("Please select one correct answer");
                    setTimeout( function(){
                        $(".error").text("");
                    }, 2000);
                }
            }

        });

        //add answers
        $("#addAnswer").click(function(){

            if ($(".answers").length >= 6) {
                $(".error").text("you can add Maximum 6 answers.");
                setTimeout( function(){
                    $(".error").text("");
                }, 2000);
            } else {
                    var html = `
                    <div class="row mt-2 answers" >
                        <input type="radio" name="is_correct" class="is_correct" >
                        <div class="col">
                            <input type="text" class="w-100" name="answers[]" placeholder="Enter Answer" required >
                        </div>
                        <button class="btn btn-danger removeButton">Remove</button>
                    </div>
                `;

                $(".modal-body").append(html);
            }

        });

        $(document).on("click",".removeButton", function(){
            $(this).parent().remove();
        });

    } );
</script>

@endsection