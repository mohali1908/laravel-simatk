@extends('admin.admin_master')
@section('admin')
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Edit Pegawai </h4><br><br>
            
  

    <form method="post" action="{{ route('employee.update') }}" id="myForm" enctype="multipart/form-data" >
                @csrf

            <input type="hidden" name="id" value="{{ $employee->id }}">
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Nama</label>
                <div class="form-group col-sm-10">
                    <input name="name" value="{{ $employee->name }}" class="form-control" type="text"    >
                </div>
            </div>
            <!-- end row -->




  <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Unit </label>
                <div class="form-group col-sm-10">
                    <input name="unit" value="{{ $employee->unit }}" class="form-control" type="text"  >
                </div>
            </div>
            <!-- end row -->

              <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Photo </label>
                <div class="form-group col-sm-10">
       <input name="image" class="form-control" type="file"  id="image">
                </div>
            </div>
            <!-- end row -->

              <div class="row mb-3">
                 <label for="example-text-input" class="col-sm-2 col-form-label">  </label>
                <div class="col-sm-10">
   <img id="showImage" class="rounded avatar-lg" src="{{ asset($employee->image) }}" alt="Card image cap">
                </div>
            </div>
            <!-- end row -->
        
<input type="submit" class="btn btn-info waves-effect waves-light" value="Update">
            </form>
             
           
           
        </div>
    </div>
</div> <!-- end col -->
</div>
 


</div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                name: {
                    required : true,
                }, 
                 unit: {
                    required : true,
                },
                 
            },
            messages :{
                name: {
                    required : 'Please Enter Your Name',
                },
                unit: {
                    required : 'Please Enter Your Unit',
                },
                 
            },
            errorElement : 'span', 
            errorPlacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });
    
</script>


<script type="text/javascript">
    
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

</script>


 
@endsection 
