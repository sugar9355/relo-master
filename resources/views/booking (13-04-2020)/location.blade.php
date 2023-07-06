@extends('user.layout.app')
@section('content')

<style>
	.nav.nav-tabs .list-group-item{
		color: #333;
		display: flex;
	}
	.nav.nav-tabs .list-group-item.active{
		background-color: var(--dark);
		color: #fff;
	}
	.nav.nav-tabs .list-group-item i{
		padding: 0.4rem .8rem 0.4rem 0rem;
    	height: 100%;
	}
	.nav.nav-tabs .list-group-item:first-of-type .fa-map-marker-alt:before {
    content: "\f124";
	}
	.col-md-4 .card i {
    position: absolute;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    background-color: #333;
    text-align: center;
    padding-top: 7px;
    color: #fff;
    top: -20px;
    right: 35%;
    border: 5px solid #fff;
    box-shadow: 0px 4px 6px #eee;
}
.shadow {
    box-shadow: 0 .2rem .5rem rgba(0,0,0,.15)!important;
}



form .row .col-md-5:nth-of-type(even){
    float:right;
}

form .row .col-md-5:nth-of-type(odd) {
	float: left;
    margin-right: 16.666667%;
}
form .row .col-md-5:nth-of-type(odd) .card:after{
    content: "\f0a4";
    position:absolute;
    right: -36%;
    font-family: 'Font Awesome 5 Free';
    font-weight: 400;
    top: 40%;
    color:#555;
    font-size: 2em;
}

form .row .col-md-5 .card.border-success:after{
	color: var(--success);
}


.card.border-warning{
	border-color:transparent!important: 
}
</style>

    <div class="container my-5">
	
	   <h4 class="text-center text-uppercase">LOCATION DETAILS</h4>
        <hr>
		<input type="hidden" id="loc_step" value="0">
		<div class="row">
		<div class="col-md-12">
		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
			<div class="row">
				
		
		{{ csrf_field() }}
		
		@php $step_count = count($booking_location) - 1; @endphp

  <div class="col-4">
		<!-- Nav tabs -->
		<input type="hidden" id="step_count" value="{{$step_count}}">
<div class="nav nav-tabs list-group shadow" id="myTab" role="tablist">
	@for ($i = 0; $i <= $step_count; $i++) 
    <button type="button" id="loc_step_{{$i}}" onclick="loc_step({{$i}});" class="list-group-item nav-item nav-link animated bounceIn delay-0-2s text-left @if($i==0) active @endif"  ><i class="fas fa-map-marker-alt"></i> {{ $booking_location[$i]->location }}</button>
  
  @endfor	
  
</div>
</div>

  <div class="col-8">
<!-- Tab panes -->
<div class="tab-content">
		@for ($i = 0; $i <= $step_count; $i++)
  <div class="tab-pane fade show  @if($i==0) active @endif" id="home_{{$i}}" role="tabpanel" aria-labelledby="home-tab{{$i}}">


  	<div class="card">
				<div class="card-body">
				<div style="height:150;">
				
					<h5>{{ $booking_location[$i]->location or '' }}</h5>
					<hr>

					<div class="form-group animated fadeIn delay-0-1s row">
						<input type="hidden" name="booking_location_pk[]" class="form-control" value="{{ $booking_location[$i]->booking_loc_id or '' }}" required>
					</div>
						
				
				<div class="row">

					<div id="div_floor_{{$i}}" class="col-md-5 mb-4 animated fadeIn delay-0-2s">
						<div id="card_floor_{{$i}}" class="card card-body shadow @if($booking_location[$i]->floor == '') @else  border-success  @endif">
						<label for="" class="col-form-label"><i class="fas fa-home mr-3"></i> Unit Or Apartment Number:</label>
						<input id="floor_{{$i}}" name="floor[]" class="form-control" value="{{ $booking_location[$i]->floor or '' }}" onfocusout="set_border('{{$i}}', 'floor')" onkeyup="open_box('{{$i}}','floor')" required>
						</div>
					</div>

					<div id="div_zip_code_{{$i}}" class="col-md-5 mb-4 animated fadeIn delay-0-3s" @if(empty($booking_location[$i]->zip_code)) style="display:none;" @endif>
						<div id="card_zip_code_{{$i}}" class="card card-body shadow">	
							<label for="" class="col-form-label"><i class="fas fa-map-marker-alt mr-3"></i> Zip Code: <br><br></label>
							<input name="zip_code[]" class="form-control" value="{{ $booking_location[$i]->zip_code or '' }}" onfocusout="set_border('{{$i}}', 'zip_code')" onkeyup="open_box('{{$i}}','zip_code')" required>
						</div>
					</div>

					<div id="div_stair_kind_{{$i}}" class="col-md-5 mb-4 animated fadeIn delay-0-4s" @if(empty($booking_location[$i]->stair_kind)) style="display:none;" @endif>
						<div id="card_stair_kind_{{$i}}" class="card card-body shadow">
						<label for="" class="col-form-label"><i class="fas fa-people-carry mr-3"></i> How will the movers be moving the furniture?</label>
						<select id="stair_kind_{{$i}}" name="stair_kind[]" class="form-control"  onfocusout="set_border('{{$i}}', 'stair_kind')" onchange="open_box('{{$i}}','stair_kind')" >
							<option value="" disabled selected>Select</option>
							
							<option value="bulkhead" {{ $booking_location[$i]->stair_kind == 'bulkhead' ? "selected" : '' }} >Bulkhead</option>
							<option value="groundfloor" {{ $booking_location[$i]->stair_kind == 'groundfloor' ? "selected" : '' }} >Ground Floor</option>
							<option value="stairs" {{ $booking_location[$i]->stair_kind == 'stairs' ? "selected" : '' }} >Stairs</option>
							<option value="elevator" {{ $booking_location[$i]->stair_kind == 'elevator' ? "selected" : '' }}>Elevator</option>
							<option value="both" {{ $booking_location[$i]->stair_kind == 'both' ? "selected" : '' }} >Both</option>
						</select>
						</div>
					</div>
					
					
					<div id="div_stair_loc_{{$i}}" class="col-md-5 mb-4" @if(empty($booking_location[$i]->stair_loc)) style="display:none;" @endif>
						<div id="card_stair_loc_{{$i}}" class="card card-body shadow animated fadeIn delay-0-5s">	
							<label for="" class="col-form-label"><i class="fas fa-people-carry mr-3"></i> Where is the stair location?</label>
							<select id="stair_loc_{{$i}}" name="stair_loc[]" class="form-control" onfocusout="set_border('{{$i}}', 'stair_loc')" onchange="open_box('{{$i}}','stair_loc')" >
								<option value="" disabled selected >Select</option>
								<option value="internal" {{ $booking_location[$i]->stair_loc == 'internal' ? "selected" : '' }} >Internal</option>
								<option value="external" {{ $booking_location[$i]->stair_loc == 'external' ? "selected" : '' }} >External</option>
							</select>
						</div>
					</div>

					<div id="div_stair_type_{{$i}}" class="col-md-5 mb-4" @if(empty($booking_location[$i]->stair_type)) style="display:none;" @endif>
						<div id="card_stair_type_{{$i}}" class="card card-body shadow animated fadeIn delay-0-5s">	
							<label for="" class="col-form-label"><i class="fas fa-bacon mr-3"></i> What kind of stairs are they?</label>
							<select name="stair_type[]" class="form-control" onfocusout="set_border('{{$i}}', 'stair_type')" onchange="open_box('{{$i}}','stair_type')">
								<option value="" disabled selected >Select</option>
								<option value="wide" {{ $booking_location[$i]->stair_type == 'wide' ? "selected" : '' }} >Wide</option>
								<option value="spiral" {{ $booking_location[$i]->stair_type == 'spiral' ? "selected" : '' }} >Spiral</option>
								<option value="windy" {{ $booking_location[$i]->stair_type == 'windy' ? "selected" : '' }} >Windy</option>
								<option value="narrow" {{ $booking_location[$i]->stair_type == 'narrow'  ? "selected" : '' }} >Narrow</option>
							</select>
						</div>
					</div>
					
					
					<div id="div_flights_{{$i}}" class="col-md-5 mb-4" @if(empty($booking_location[$i]->flights)) style="display:none;" @endif>
						<div id="card_flights_{{$i}}" class="card card-body shadow animated fadeIn delay-0-6s">	
							<label for="" class="col-form-label"><i class="far fa-building mr-3"></i> How many flights are there ?</label>
							<select name="flights[]" class="form-control" onfocusout="set_border('{{$i}}', 'flights')" onchange="open_box('{{$i}}','flights')">
								<option value="" disabled selected >Select</option>
								<option value="1" {{ $booking_location[$i]->flights == 1  ? "selected" : '' }} >1</option>
								<option value="2" {{ $booking_location[$i]->flights == 2  ? "selected" : '' }} >2</option>
								<option value="3" {{ $booking_location[$i]->flights == 3  ? "selected" : '' }} >3</option>
								<option value="4" {{ $booking_location[$i]->flights == 4  ? "selected" : '' }} >4</option>
								<option value="5" {{ $booking_location[$i]->flights == 5  ? "selected" : '' }} >5</option>
							</select>
						</div>
					</div>

					<div id="div_evelator_type_{{$i}}" class="col-md-5 mb-4" @if(empty($booking_location[$i]->evelator_type)) style="display:none;" @endif>
						<div id="card_evelator_type_{{$i}}" class="card card-body shadow animated fadeIn delay-0-5s">	
							<label for="" class="col-form-label"><i class="fas fa-bacon mr-3"></i> What kind of evelator are they?</label>
							<select name="evelator_type[]" class="form-control" onfocusout="evelator_type('{{$i}}', 'flights')" onchange="open_box('{{$i}}','evelator_type')">
								<option value="" disabled selected >Select</option>
								<option value="freight" {{ $booking_location[$i]->evelator_type == 'freight' ? "selected" : '' }} >freight</option>
								<option value="passenger" {{ $booking_location[$i]->evelator_type == 'passenger'  ? "selected" : '' }} >passenger</option>
							</select>
						</div>
					</div>

					<div id="div_parking_{{$i}}" class="col-md-5 mb-4"  @if(empty($booking_location[$i]->parking)) style="display:none;" @endif>
						<div id="card_parking_{{$i}}" class="card card-body shadow animated fadeIn delay-0-7s">
								<label for="" class="col-form-label"><i class="fas fa-parking mr-3"></i> Parking and building info</label>
								<select name="parking[]" class="form-control" onfocusout="evelator_type('{{$i}}', 'flights')" onchange="open_box('{{$i}}','parking')">
									<option value="" disabled selected >Select Stairs</option>
									<option value="1" {{ $booking_location[$i]->parking == 1 ? "selected" : '' }} >Loading dock will be reserved</option>
									<option value="2" {{ $booking_location[$i]->parking == 2 ? "selected" : '' }} >Parking permit will be pulled</option>
									<option value="3" {{ $booking_location[$i]->parking == 3 ? "selected" : '' }} >Metered parking available</option>
									<option value="4" {{ $booking_location[$i]->parking == 4 ? "selected" : '' }} >Commercial parking available</option>
									<option value="5" {{ $booking_location[$i]->parking == 5 ? "selected" : '' }} >Easy street parking available</option>
									<option value="6" {{ $booking_location[$i]->parking == 6 ? "selected": '' }} >Home driveway available</option>
									<option value="7" {{ $booking_location[$i]->parking == 7 ? "selected" : '' }} >Other</option>
								</select>
						</div>	
					</div>	

				</div>

					
					<div id="div_walk_{{$i}}"  @if(empty($booking_location[$i]->walk)) style="display:none;" @endif>
						<div class="card card-body shadow animated fadeIn delay-0-8s mt-2">
						<div class="row">
							<div class="col-md-9">	
								<p><strong>Are there any long walks at any of the locations specified above?</strong><br>
								Take a stop watch and walk from your items to where our vehicle would be parked. If it takes over 30 seconds, this is considered a long walk. This can greatly affect the estimated time so please do not skip this question.</p>
							</div>
							<div class="col-md-3 animated fadeIn delay-0-9s py-3 border-left">
								<div class="bg-light bg-warning border rounded px-3 my-3 py-2 shadow-sm mx-auto w-100">	
								<div class="custom-control custom-radio  custom-control-inline">
								  <input type="radio" id="yes{{$i}}" name="walk[{{$i}}]" class="custom-control-input" value="1" @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 1) checked @endif class="form-control" required>
								  <label class="custom-control-label" for="yes{{$i}}" onclick="open_box('{{$i}}','walk')">Yes</label>
								</div>
								</div>
								
								<div class="bg-light bg-dark text-white rounded px-3 my-3 py-2 shadow-sm mx-auto w-100">
								<div class="custom-control custom-radio custom-control-inline">
								  <input type="radio" id="no{{$i}}" name="walk[{{$i}}]" class="custom-control-input" value="2"  @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 2) checked @endif
									@if(!isset($booking_location[$i]->walk)) checked @endif								  class="form-control" required>
								  <label class="custom-control-label" for="no{{$i}}" onclick="open_box('{{$i}}','walk')" >No</label>
								</div>
								</div>

							</div>
						</div>
					</div>
					</div>
					<div id="div_walk_time_{{$i}}"  @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 1) @else style="display:none;" @endif >
						<div class="card card-body shadow animated fadeIn delay-0.5s mt-3">
															
							<p><strong>Is the walk from your door to where the truck will be parked longer than 30 seconds ?</strong></p>

							<div class="form-row">
														
								<div class="form-group animated fadeIn col-md-3">
									<label for="">Minutes:</label>
									<select id="walk_min_{{$i}}" name="walk_min[{{$i}}]" class="form-control">
									@for($j=1;$j<=10;$j++)
										<option value="{{$j}}" @if(isset($booking_location[$i]->walk_min) && $booking_location[$i]->walk_min == $j) selected @endif>{{$j}}</option>
									@endfor
									</select>
								</div>

									<div class="form-group animated fadeIn col-md-3">
										<label for="">Seconds:</label>
										<select id="walk_sec_{{$i}}" name="walk_sec[{{$i}}]" class="form-control">
										@for($k=1;$k<=60;$k++)
											<option value="{{$k}}" @if(isset($booking_location[$i]->walk_min) && $booking_location[$i]->walk_sec == $k) selected @endif>{{$k}}</option>
										@endfor
										</select>
									</div>
							</div>
								
							
						</div>							
							
						</div>
					
					
					
					<div id="div_comments_{{$i}}" class="mt-3"  @if(empty($booking_location[$i]->zip_code)) style="display:none;" @endif>
						<div class="form-group animated fadeIn delay-1s">
							<label class="col-form-label">Please give exact details about the location</label>
							<textarea name="comments[{{$i}}]" class="form-control animated fadeIn col-form-label">{{ $booking_location[$i]->comments or '' }}</textarea>
						</div>
					</div>

				</div>
				</div>
				
				
				</div>
	@if($step_count == $i)
	<hr>                
	<button type="button" onclick="loc_step({{$i-1}});" class="btn btn-outline-dark m-auto hvr-icon-wobble-horizontal animated slideInRight"><i class="fas fa-chevron-left hvr-icon"></i> Back </button>
	<button id="btn_submit" name="btn_submit" type="submit" value="4" class="btn btn-dark m-auto hvr-icon-wobble-horizontal animated slideInRight">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
	@else
	<hr>                
		@if($i > 0)
			<button type="button" onclick="loc_step({{$i-1}});" class="btn btn-outline-dark m-auto hvr-icon-wobble-horizontal animated slideInRight"><i class="fas fa-chevron-left hvr-icon"></i> Back </button>
		@endif
 	<button type="button" onclick="loc_step({{$i+1}});" class="btn btn-dark m-auto hvr-icon-wobble-horizontal animated slideInRight">Next <i class="fas fa-chevron-right hvr-icon"></i></button>
	
	@endif	

  </div>
 
  	@endfor	
</div>


<style>
	.tt.active{
		display: none;
	}

</style>

</div>
 
  </div>

<div class="col-md-12 text-right">
	
</div>
</form>
</div>
	
			
	</div>
	
</div>


@endsection
@section("scripts")
<script>
$(document).ready(function(){
  $(".col-md-5 .card").last().css("background-color", "blue");
});
</script>
<script>

	function loc_step(loc_step_value)
	{
		var step_count = $("#step_count").val();
		if(loc_step_value > 0 || loc_step_value < step_count)
		{
			$(".active").removeClass('active');
			$("#loc_step_"+loc_step_value).addClass('active');
			
			$(".tab-pane").hide();
			$("#home_"+loc_step_value).show();		
			
			var loc_step = $("#loc_step").val();
		}
	}


	
	function set_border(box,step){
		if(step == 'floor')
		{
			var val = $("floor_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_floor_"+box).removeClass('border-warning');
			$("#card_floor_"+box).addClass('border-success');
			}
		}

		if(step == 'zip_code')
		{
			var val = $("zip_code_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_zip_code_"+box).removeClass('border-warning');
			$("#card_zip_code_"+box).addClass('border-success');
			}
		}
		if(step == 'stair_kind')
		{
			var val = $("stair_kind_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_stair_kind_"+box).removeClass('border-warning');
			$("#card_stair_kind_"+box).addClass('border-success');
			}
		}
		if(step == 'stair_type')
		{
			var val = $("stair_type_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_stair_type_"+box).removeClass('border-warning');
			$("#card_stair_type_"+box).addClass('border-success');
			}
		}
		if(step == 'stair_loc')
		{
			var val = $("stair_loc_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_stair_loc_"+box).removeClass('border-warning');
			$("#card_stair_loc_"+box).addClass('border-success');
			}
		}
		if(step == 'elevator')
		{
			var val = $("elevator_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_elevator_"+box).removeClass('border-warning');
			$("#card_elevator_"+box).addClass('border-success');
			}
		}
		if(step == 'flights')
		{
			var val = $("flights_"+box).val();
			if(val == ''){

			}
			else{				
			$("#card_flights_"+box).removeClass('border-warning');
			$("#card_flights_"+box).addClass('border-success');
			}
		}

	}
	function open_box(box,step)
	{
	
		if(step == 'floor')
		{
			$("#div_zip_code_"+box).show();
		}
		if(step == 'zip_code')
		{
			$("#div_stair_kind_"+box).show();
		}
		
		if(step == 'stair_kind')
		{
			var res = $("#stair_kind_"+box).val();
			
			if(res == 'stairs' || res == 'both' )
			{
				$("#div_stair_type_"+box).show();
				$("#div_flights_"+box).show();
			}	
			else
			{
				$("#div_stair_type_"+box).hide();
				$("#div_flights_"+box).hide();
			}	
			
			if(res == 'stairs' || res == 'groundfloor')
			{
				$("#div_stair_loc_"+box).show();
			}
			else
			{
				$("#div_stair_loc_"+box).hide();
			}
			
			if(res == 'elevator' || res == 'both' )
			{
				$("#div_evelator_type_"+box).show();
			}	
			else
			{
				$("#div_evelator_type_"+box).hide();
			}
		}
		
		if(step == 'stair_loc')
		{
			var res = $("#stair_loc_"+box).val();
			var kinds = $("#stair_kind_"+box).val();
			if((res == 'internal' || res == 'external') && (kinds == 'groundfloor'))
			{
			
				$("#div_walk_"+box).show();
			}	
			else
			{
				$("#div_walk_"+box).hide();
			}
		}
		
		if(step == 'flights')
		{
			var res = $("#stair_kind_"+box).val();
			if(res == 'stairs')
			{
				$("#div_parking_"+box).show();
			}
			
		}
		if(step == 'evelator_type')
		{
			var res = $("#stair_kind_"+box).val();
			if(res == 'elevator' || res == 'both' )
			{
				$("#div_parking_"+box).show();
			}
			
		}
		if(step == 'parking')
		{
			$("#div_walk_"+box).show();
		}
		if(step == 'walk')
		{
			if($('#yes'+box).is(':checked'))
			{	
				$("#div_walk_time_"+box).hide();
				$("#div_walk_time_"+box).prop("required", false);
			}
			else
			{
				$("#div_walk_time_"+box).show();
				$("#div_walk_time_"+box).prop("required", true);
			}
			
			$("#div_comments_"+box).show();
		}
		
		
	}

	function next_step(box)
	{
		var step = $("#next_"+box).val();
		
		$("#back_"+box).val(step);
		
		//$("div[id*='div_"+box+"']").hide();
		
		var step = parseInt(step) + 1;
		
		$("#next_"+box).val(step);
		
		$("#div_"+box+'_'+step).fadeIn("slow");
		$("#div_"+box+'_'+step).fadeIn(1000);	
		
	}
	
	function back_step(box)
	{
		var step = $("#back_"+box).val();
		
		$("#next_"+box).val(step);
		
		//$("div[id*='div_"+box+"']").hide();
		
		$("#div_"+box+'_'+step).fadeIn("slow");
		$("#div_"+box+'_'+step).fadeIn(1000);	
		
		var step = parseInt(step) - 1;
		
		if(step > 0 && step < 9)
		{
			$("#back_"+box).val(step);	
		}
		
	}
  
</script>
@endsection