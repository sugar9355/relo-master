@extends("user.layout.app")

@section("styles")
    <link rel="stylesheet" href="{{ asset('asset/css/newDesignStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('noUiSlider/nouislider.css') }}">
	
	<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}"> 
	
	<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->
	
	<!-- Theme JS files -->
		<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/app.js')}}"></script>
		<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
	<!-- /theme JS files -->
	
@endsection

@section("content")


<div class="container my-5">
         <h4 class="text-center animated fadeIn delay-0-2s">SELECT DATE & TIME</h4>
        <hr>
		@if(session()->get("msg") != '') 
			
			<div class="alert alert-danger">
			  <strong>Oops!</strong> {!! session()->get("msg") !!} 
			</div>
		
			@php session()->remove("msg"); @endphp
		
		@endif
		 @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
		
        {{ csrf_field() }}

            <div class="row">
                <div class="col-12 m-auto text-center mb-3">
                    <div class="card card-body bg-dark mb-3 animated fadeIn delay-0-5s">                        
                    <h5>
                        When would you like to move?
                    </h5>                
                  </div>
                </div>

             
            </div>

            <div id="dateRange">
			<input id="selector" value="0" type="hidden" >
			<div class="row mt-3">
                <div class="col-md-6" id="div_primary_date">
				<div id="preferDate" style="display:none;"></div>
                    <div class="card card-body animated fadeIn delay-0-6s" >
					
                        <h6 class="text-center">Preferred Date</h6>
                        
								<table class="table table-bordered">	
									<tr class="bg-info text-white">
										<th id="1"  class="text-center">MON</th>
										<th id="2"  class="text-center">TUE</th>
										<th id="3"  class="text-center">WED</th>
										<th id="4"  class="text-center">THU</th>
										<th id="5"  class="text-center">FRI</th>
										<th id="6"  class="text-center">SAT</th>
										<th id="7"  class="text-center">SUN</th>
									</tr>

									@foreach ($calender[2] as $k =>$week) 

									<tr>
									@foreach($week as $day) 
										<td id="td_{{$day}}" onclick="select_time({{$day}});">{{ ($day ? $day : '&nbsp;') }}</td>
									@endforeach
									</tr>

									@endforeach
									</table>
							
					</div>
				</div>
				<div class="col-md-6" id="div_secondary_date">
						<div class="card-header bg-dark text-white header-elements-inline">
						<h6 class="card-title">Threshold</h6>
						<div class="header-elements">
							<div class="list-icons">
								<input id="threshold" name="threshold" type="hidden" value="" class="switchery" data-fouc>
							</div>
						</div>
					</div>
				</div>	
				
				<!--
				<div class="col-md-6" id="div_secondary_date">
					<div class="card card-body animated fadeIn delay-0-8s">
						<h4 class="text-center m-0">select time</h4>
						<hr>
						@for ($i = 1; $i <=4; $i++) 
						<div id="specificTime{{$i}}" >
							<div id="specificPickedTime{{$i}}">
								<span class="slider-specific-time{{$i}}">08:00 AM </span>
							</div>
							<div class="sliders_step{{$i}}">
								<div id="slider-specific{{$i}}"></div>
							</div>
							<input type="hidden" name="secondary_date" id="date{{$i}}">
							<input type="hidden" name="primary_date" id="preferDate{{$i}}" value="{{ date('Y-m-d') }}">	
							<input type="hidden" name="start_time" id="time{{$i}}" value="8:00 AM">
							<hr>
						</div>
						
						@endfor
						
					</div>
				</div>	
				
				-->
			</div>

            </div>
            

			
		
			<div class="col-md-12 text-center">
                    <hr>
					<a href="/booking/{{ ($booking->booking_id) ?: null }}/2" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal"><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
					<button id="dataFormBtn" name="btn_submit" type="submit" value="3" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
				</div>
			</div>
		

		<div class="col-md-12 text-center">
			<hr>                
			
		</div>
    </form>
	

</div>
@endsection

@section("scripts")
    <script src="{{ asset('noUiSlider/nouislider.js') }}"></script>
    <script src="{{ asset('js/wNumb.js') }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>
	
	<script>
	
	// $(function() {
    // $("#preferDate").click(function() 
	// {
	
		// // var selector = $("#selector").val();
		// // $("#selector").val(selector+1);
		// // //console.log($(this).html());
		// // $("#specificTime1").show();
    // });
    
// });
	function select_time(id)
	{
		//$('#td_'+id).addClass('bg-dark text-white');
		$('#td_'+id).toggleClass('bg-dark text-white');

	}
	function celender()
	{
		
		var isChecked = $('#FS:checked').val()?true:false;
		if(isChecked == true)
		{
			$('#div_primary_date').show();
			$('#div_secondary_date').show();
		}
		
		var isChecked = $('#SF:checked').val()?true:false;
		if(isChecked == true)
		{
			$('#div_primary_date').show();
			$('#div_secondary_date').hide();
		}
		
		var isChecked = $('#SS:checked').val()?true:false;
		if(isChecked == true)
		{
			$('#div_primary_date').show();
			$('#div_secondary_date').hide();
		}
		
		var isChecked = $('#FF:checked').val()?true:false;
		if(isChecked == true)
		{
			$('#div_primary_date').show();
			$('#div_secondary_date').show();
		}

		
	}
	
    </script>

@endsection


