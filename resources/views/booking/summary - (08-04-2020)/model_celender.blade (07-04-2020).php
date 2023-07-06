<!-- Modal -->
<div id="celender{{$day[0]}}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
	
	<form action="/save_date/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
		
		{{ csrf_field() }}
	<div class="modal-header">
	  <h5 class="modal-title" id="staticBackdropLabel">Confirm Date & Time</h5>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body text-center text-dark">
	
	
	@if(!empty($year) && !empty($month) && !empty($day[0]))
		<input type="hidden" name="booking_date" value="{{$date}}" >
		<input type="hidden" id="start_slider_{{$month}}_{{$day[0]}}" name="start_time" value="" >
		<input type="hidden" id="end_slider_{{$month}}_{{$day[0]}}" name="end_time" value="" >
		<input type="hidden" id="week_slider_{{$month}}_{{$day[0]}}" name="end_time" value="{{$day[2]}}" >
	@endif
	  <div class="card w-25 text-center m-auto mb-4 shadow">
		<div class="card-header bg-warning p-2">
		  <h6 class="m-0">{{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
		</div>
		<div class="card-body">
		  <h2>{{$day[0]}}</h2>
		</div>
	  </div>

	  <h5 class="mt-4"><span class="bg-success px-3 py-0 rounded d-inline smaller mr-3"></span> Full Day Availablity</h5>

		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="form-group mt-5">
				<label class="font-weight-bold" for="customRange3">
				<p> Time Range: <span class="text-center" id="time_slider_{{$month}}_{{$day[0]}}">6:00 AM - 6:00 PM</span></p>
				</label>

				<div id="slider_{{$month}}_{{$day[0]}}" class="slider"></div>
				<div class="break text-center" style="background: {{$day[3]}};"></div>
				<div class="clock">
					@foreach($working_hours as $clock)
						<span class="segment">{{explode(' ',$clock->time)[0]}}<br></span>
					@endforeach
				</div>

				</div>
			</div>
		</div>
	  
	  

	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
	  <button type="submit" class="btn btn-dark">Save</button>
	</div>
	</form>
	</div>
	</div>
</div>