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

            <div class="card-body">
                <div class="container">
                  <div class="row">
                    <form style="width: 100%;" method="post" id="templateidForm">
<input id="tid" value="{{$template[0]->id}}" hidden >
  <div class="form-group">
    <label for="exampleInputEmail1">Sms Template</label>
    <select class="form-control" id="templateid" name="templateid" required>
      <option value="">Select</option>
      @if($template[0]->template_id==0)
      <option value="0" selected="">Confirmation</option>
      @else
      <option value="0" >Confirmation</option>
      @endif

      @if($template[0]->template_id==100)
      <option value="100" selected >Cancel</option>
      @else
     <option value="100" >Cancel</option>
      @endif
      
      
      @for ($i = 1; $i <= 15; $i++)
    <option value="{{$i}}" {{$template[0]->template_id==$i?"selected":""}}>{{$i}} Day Before</option>
@endfor
<option value="other" {{$template[0]->template_id!="0" && $template[0]->template_id!="100" && $template[0]->template_id>"15" ?"selected":""}}>Other</option>
    </select>
  </div>
   <div class="form-group  otheroptions" style="display: {{$template[0]->template_id!='0' && $template[0]->template_id!='100' && $template[0]->template_id>'15' ?'block':'none'}}">
    <label for="exampleInputPassword1">Other Options</label>
    <input type="text"  class="form-control" id="otheroption" value="{{$template[0]->template_id}}" name="otheroption" placeholder="Other">
  </div>
 

  <div class="form-group">
    <label for="exampleInputPassword1">Sms Subject</label>
    <input type="text" required class="form-control" id="subject" value="{{$template[0]->template_subject}}" name="subject" placeholder="Mail Subject">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Sms Template</label>
    <textarea required name="mailtemplate" id="mailtemplate">{{$template[0]->template}}</textarea>
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
                  data: {'tid':$('#tid').val(),'temp_id':tempidd,'subject':$('#subject').val(),'template_value':CKEDITOR.instances.mailtemplate.getData()},
                  // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
                  headers:{
                  'X-CSRF-TOKEN':'{{ csrf_token() }}'
                  },
                  success: function(data)
                {
                 location.href = "{{url('admin/canned_sms')}}"
                }
                });
                  }
                })
              })

                </script>
@endsection


