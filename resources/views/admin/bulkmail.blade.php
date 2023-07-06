@extends('admin.layout.base')



@section('title', 'Bulk Mail ')



@section('styles')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<style>

</style>

@endsection



@section('content')

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <!-- card header -->

            <div class="card-header header-elements-inline">

                <h4 class="card-title">

                  Bulk Mail

                </h4>

                <div class="header-elements">

                    <div class="list-icons">

                        <a class="list-icons-item" data-action="collapse"></a>

                        <a class="list-icons-item" data-action="reload"></a>

                    </div>

                </div>

            </div>

            <!-- card body -->
 <div class="container">
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.canned_mail') }}">Canned Email <span class="sr-only">(current)</span></a>
      </li>
       <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.canned_sms') }}">Canned Sms <span class="sr-only">(current)</span></a>
      </li>
       <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.bulk_email') }}">Bulk Mail <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div>
    
</nav>
            </div>
            <div class="card-body">
                <div class="container">
                  <div class="row">
                    <form style="width: 100%;" method="post" action="{{route('admin.sendbulk_email')}}" id="templateidForm">
                      {{csrf_field()}}

  <div class="form-group">
    <label for="exampleInputEmail1">Booking Status</label>
    <select class="form-control select" id="status" name="status" required>
      <option value="">Select</option>
      <option value="Pending">Pending</option>
      <option value="Confirmed">Confirmed</option>
      <option value="Completed">Completed</option>
    </select>
  </div>
    <div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <select class="form-control select2" id="Email" name="email[]" multiple required>
      <option value="">Select</option>
     
    </select>
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">From Email</label>
    <input type="text" required class="form-control" id="fromemail" name="fromemail" placeholder="Email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">Mail Subject</label>
    <input type="text" required class="form-control" id="subject" name="subject" placeholder="Mail Subject">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Mail Template</label>
    <textarea required name="mailtemplate" id="mailtemplate"></textarea>
  </div>
  <button  class="btn btn-primary submit">Submit</button>
</form>
                  </div>

              

  </div>

            </div>

        </div>

    </div>

</div>

 <script>
  $('.select2').select2({});
          
          CKEDITOR.replace( 'mailtemplate' );

      $(document).ready(function(){
          $('#status').change(function(e){
            $.ajax({
                  type: "POST",
                  url: "/admin/get-email",
                  data: {'status':$('#status').val()},
                  headers:{
                  'X-CSRF-TOKEN':'{{ csrf_token() }}'
                  },
                  success: function(response)
                {
                  if(response.data!=''){
                    $('#Email').select2({});
                    $('#Email').html(response.data);
                  }
                }
                });

          })


         
              })

                </script>
@endsection


