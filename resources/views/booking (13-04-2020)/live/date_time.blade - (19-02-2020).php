@extends("user.layout.app")

@section("styles")
    <link rel="stylesheet" href="{{ asset('asset/css/newDesignStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('noUiSlider/nouislider.css') }}">
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

                 <div class="col-md-3">
        <div class="card h-100 pb-0 card-body bg-dark mb-3 animated fadeIn delay-0-5s">
            <div class="custom-control custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="flexibilty" id="FS" value="FS" onclick="celender();" checked>
              <label class="custom-control-label" for="FS">Flexible Date And Specific Time FS</label>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card h-100 pb-0 card-body bg-dark mb-3 animated fadeIn delay-0-5s">  
            <div class="custom-control custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="flexibilty"  id="SF" value="SF" onclick="celender();">
              <label class="custom-control-label" for="SF">Specific Date (Flexible Time) SF</label>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card h-100 pb-0 card-body bg-dark mb-3 animated fadeIn delay-0-5s">  
            <div class="custom-control custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="flexibilty" id="FF" value="FF" onclick="celender();">
              <label class="custom-control-label" for="FF">Flexible Date (Flexible Time) FF</label>
            </div>
        </div>
        </div>
        <div class="col-md-3">
        <div class="card h-100 pb-0 card-body bg-dark mb-3 animated fadeIn delay-0-5s">  
            <div class="custom-control custom-control custom-radio">
              <input type="radio" class="custom-control-input" name="flexibilty"  id="SS" value="SS" onclick="celender();">
              <label class="custom-control-label" for="SS">Specific Date And Time SS</label>
            </div>
        </div>
        </div>

            </div>

            <div id="dateRange">

			<div class="row mt-3">
                <div class="col-md-6" id="div_primary_date">
                    <div class="card card-body animated fadeIn delay-0-6s" id="preferDate">
					
                        <h4 class="text-center m-0">Preferred Date</h4>
                        <hr>
							@if(isset($booking->primary_date))
							<h5> Primary Date : {{ $booking->primary_date }}</h5>	
							@endif
                            <div id="preferDate"></div>
							
                    </div>
                </div>
                <div class="col-md-6" id="div_secondary_date">
                    <div class="card card-body animated fadeIn delay-0-8s">
                        <h4 class="text-center m-0">Secondary Date</h4>
                        <hr>
							@if(isset($booking->secondary_date))
							<h5> Secondary Date : {{ $booking->secondary_date }}</h5>	
							@endif
                            <div class="daterangepicker"></div>
							
                    </div>
                </div>
            </div>

            </div>
            

            <div class="row">
            

                <div class="col-12">
                    <div class="card card-body mt-3  animated fadeIn">
                        <h4 class="text-center m-0">Time Preference</h4>
                        <hr>
                        <div id="specificTime">
                            <div id="specificPickedTime">
                                <span class="slider-specific-time">08:00 AM </span>
                            </div>
                            <div class="sliders_step1">
                                <div id="slider-specific"></div>
                            </div>
                        </div>

                    <div id="flexTime">
                        <div id="time-range">
                            <div id="PickedTimeRange" class="text-center row m-0">
                                <div class="custom-control custom-radio py-4 col-md-3">
                                  <input type="radio" value="Any Time" name="time_0[]" id="box-0-1" class="custom-control-input">
                                  <label class="custom-control-label" for="box-0-1">Any Time</label>
                                </div>
                                <div class="custom-control custom-radio py-4 col-md-3">
                                  <input type="radio" value="Morning" name="time_0[]" id="box-0-2" class="custom-control-input">
                                  <label class="custom-control-label" for="box-0-2">Morning</label>
                                </div>
                                <div class="custom-control custom-radio py-4 col-md-3">
                                  <input type="radio" value="Afternoon" name="time_0[]" id="box-0-3" class="custom-control-input">
                                  <label class="custom-control-label" for="box-0-3">Afternoon</label>
                                </div>
                                <div class="custom-control custom-radio py-4 col-md-3">
                                  <input type="radio" value="Evening" name="time_0[]" id="box-0-4" class="custom-control-input">
                                  <label class="custom-control-label" for="box-0-4">Evening</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="secondary_date" id="date">
					<input type="hidden" name="primary_date" id="preferDate" value="{{ date('Y-m-d') }}">	
                    <input type="hidden" name="start_time" id="time" value="8:00 AM">
                </div>
            </div>

            <!--Modals-->
            <div class="modal fade" id="timeListModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Items</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 px-5" id="timeList">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="submitForm()" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
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


