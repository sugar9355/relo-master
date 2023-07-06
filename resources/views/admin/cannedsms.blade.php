@extends('admin.layout.base')



@section('title', 'Dashboard ')



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

                  Canned Sms

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
                    <form style="width: 100%;" method="post" id="templateidForm">

  <div class="form-group">
    <label for="exampleInputEmail1">Sms Template</label>
    <select class="form-control" id="templateid" name="templateid" required>
      <option value="">Select</option>
      <option value="0">Confirmation</option>
      <option value="100">Cancel</option>
      @for ($i = 1; $i <= 15; $i++)
    <option value="{{$i}}">{{$i}} Day Before</option>
@endfor
<option value="other">Other</option>
    </select>
  </div>
  <div class="form-group  otheroptions" style="display: none">
    <label for="exampleInputPassword1">Other Options</label>
    <input type="text"  class="form-control" id="otheroption" name="otheroption" placeholder="Other">
  </div>


  <div class="form-group">
    <label for="exampleInputPassword1">Sms Subject</label>
    <input type="text" required class="form-control" id="subject" name="subject" placeholder="Mail Subject">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Sms Template</label>
    <textarea required name="mailtemplate" id="mailtemplate"></textarea>
  </div>
  <button  class="btn btn-primary submit">Submit</button>
</form>
                  </div>

                  <div class="row templatelist mt-5">
                    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Type</th>
      <th scope="col"> Subject</th>
      <th scope="col"> Action</th>

    </tr>
  </thead>
  <tbody>
    @if(count($template)>0)
    @php
    $i=1
    @endphp
    @foreach($template as $value)
    <tr>
      <th scope="row">{{$i++}}</th>
      <td>{{$value->createdat}}</td>
      @if($value->template_id===0)
      <td>Confirmation mail</td>
      @elseif($value->template_id===100)
      <td>Cancel mail</td>
      @else
       <td>{{$value->template_id }}</td>
      @endif
     
      
      <td>{{$value->template_subject}}</td>
      <td><a href="{{url('admin/edit-smstemplate')}}/{{$value->id}}" >Edit</a></td>
    </tr>
    @endforeach
    @endif


  </tbody>
</table>

                  </div>

  </div>

            </div>

        </div>

    </div>

</div>

 <script>
          
          CKEDITOR.replace( 'mailtemplate' );

      $(document).ready(function(){
          $('#templateid').change(function(e){
            if($(this).val()=='other'){
                $('.otheroptions').css('display','block');
          }
          else{
          $('.otheroptions').css('display','none');
          }

          })


          $('.submit').click(function(e){
          e.preventDefault();
          var form = $("#templateidForm")[0];
          var formdata = new FormData($('#templateidForm')[0]);
          if (form.checkValidity() === false) {
              e.preventDefault();
              e.stopPropagation();
              form.classList.add('was-validated');
          } else {
            var tempidd = $('#templateid').val()!='other'?$('#templateid').val():$('#otheroption').val()
                $.ajax({
                  type: "POST",
                  url: "/admin/save-smstemplate",
                  data: {'temp_id':tempidd,'subject':$('#subject').val(),'template_value':CKEDITOR.instances.mailtemplate.getData()},
                  // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
                  headers:{
                  'X-CSRF-TOKEN':'{{ csrf_token() }}'
                  },
                  success: function(data)
                {
                  location.reload();
                }
                });
                  }
                })
              })

                </script>
@endsection


