@if(!empty($booking->booking_date))
@if($booking->crew != null && $booking->exist_hours == false)

	<div class="card hvr-shadow w-100 card-body mt-3">
		<h5 class="border-bottom pb-2">Select Date & Time </h5>
		<div class="row">
		
			<div class="col-md-2">
				<div class="card hvr-shadow w-100 text-center border-info">
				<div id="month_tag" class="card-header bg-info text-white p-1">{{date('F', strtotime($booking->booking_date))}}</div>
				<div id="day_tag" class="card-body lead font-weight-bold p-2">{{date('d', strtotime($booking->booking_date))}}</div>
				</div>
			</div>	
	
			<div class="col-md-9">
				<div class="form-group">
				
					<label id="time_slider_{{1}}_{{1}}" class="font-weight-bold" for="customRange3" >Time Range: 6:00 AM - 6:00 PM</label>
					
					<div id="slider"></div>
					<div class="break text-center" style="background: ;"></div>
					<div class="clock">
						@foreach($working_hours as $clock)
							<span class="segment">{{explode(' ',$clock->time)[0]}}<br></span>
						@endforeach
					</div>
					
				</div>
			</div>
		</div>	
	</div>		
	
	<script>
	
	var start_time = '6:00 AM';
	var end_time = '6:00 PM';
	
	$("#slider").slider({
	tooltip: 'always',
	range: true,
	min: 0,
	max: 12,
	step: 1,
	values:[0,12],
	slide: function (e, ui) 
		{
			var week = $("#week_"+e.target.id).val();
			var start = ui.values[0];
			var end = ui.values[1];
			
			if(working_hours[start][week] == 0 || working_hours[end][week] == 0)
			{
				$("#price_"+e.target.id).show();
			}
			else
			{
				$("#price_"+e.target.id).hide();
			}
			
			$("#time_"+e.target.id).empty();
			$("#time_"+e.target.id).append('Time Range: '+working_hours[start].time +' - '+ working_hours[end].time);
			
			start_time = working_hours[start].time;
			end_time = working_hours[end].time;
		
		}
	});
	
	$("#slider").mouseup(function()
	{
	  $.ajax(
		{
			url : "/save_time/"+booking_id+"/"+start_time+"/"+end_time,
			type: "Get",
			success:function(data, textStatus, jqXHR) 
			{
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
			}
		});	
	});
	</script>
	
@elseif($booking->exist_hours == 'hours_not_available')
	
		<div class="row col-md-12 mt-3">
		<div class="alert alert-danger col-md-12 shadow">
		  <strong>Oops!</strong> Hours not available.
		</div>
		</div>

@elseif($booking->crew == null)
	
	
		<div class="row col-md-12 mt-3">
		<div class="alert alert-danger col-md-12 shadow">
		  <strong>Oops!</strong> Workers not available.
		</div>
		</div>
	
	
@else
	
	<div class="card hvr-shadow w-100 card-body mt-3">
		<h5 class="border-bottom pb-2">Select Date & Time </h5>
		<div class="row">
		
			<div class="col-md-2">
				<div class="card hvr-shadow w-100 text-center border-info">
				<div id="month_tag" class="card-header bg-info text-white p-1">{{date('F', strtotime($booking->booking_date))}}</div>
				<div id="day_tag" class="card-body lead font-weight-bold p-2">{{date('d', strtotime($booking->booking_date))}}</div>
				</div>
			</div>

			@foreach(explode(',',$booking->exist_hours) as $k => $exist_hours)
			<div class="d-flex align-items-center mr-1 cursor">
				<div class="hvr-shadow hvr-icon-bob px-2 py-3 rounded  cursor" style="border:2px solid #ccc;">
				<div class="custom-control custom-radio ml-4  cursor">

				@if(strpos($exist_hours, '-') !== false) 
				<input type="radio" class="custom-control-input" name="insurance" id="insurance{{$k}}" onclick="save_time('{{explode('-',$exist_hours)[0]}}','{{explode('-',$exist_hours)[1]}}')">
				@else
				<input type="radio" class="custom-control-input" name="insurance" id="insurance{{$k}}" onclick="save_time('{{$exist_hours}}','{{$exist_hours}}')">
				@endif



				<label class="custom-control-label text-dark" for="insurance{{$k}}">

				@php 
				$seg = explode('-',$exist_hours);
				@endphp
				Start {{current($seg)}} - {{end($seg)}} End

				</label>
				</div>
				</div>
			</div>
			@endforeach

		</div>

		<p class="font-weight-normal lead mt-3"><a href="#" class="text-info"  data-toggle="modal" data-target="#staticBackdrop"><u>I need a specific start time</u></a></p>

	</div>

@endif
@endif