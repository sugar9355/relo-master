<!-- Modal -->
<div id="celender{{$day[0]}}" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	
	<form action="/save_date/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
		
		{{ csrf_field() }}
	<div class="modal-header">
	  <h4 class="modal-title" id="staticBackdropLabel"><i class="far fa-clock"></i> Confirm Date & Time</h4>
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>
	<div class="modal-body text-center text-dark">
	
	
	@if(!empty($year) && !empty($month) && !empty($day[0]))
		<input type="hidden" name="booking_date" value="{{$date}}" >
		<input type="hidden" id="start_slider_{{$month}}_{{$day[0]}}" name="start_time" value="" >
		<input type="hidden" id="end_slider_{{$month}}_{{$day[0]}}" name="end_time" value="" >
	@endif

	<div class="row">
		<div class="col text-center">

		  <div class="card w-75 text-center m-auto mb-4 shadow border-0">
			<div class="card-header bg-warning p-2 border-warning">
			  <h5 class="m-0">{{date("F", mktime(0, 0, 0, $month, 10))}}</h5>
			</div>
			<div class="card-body bg-warning p-3">
			  <h2 class="h1">{{$day[0]}}</h2>
			</div>
		  </div>
			
		</div>
		<div class="col text-center">

			<div class="card w-75 text-center m-auto mb-4 shadow low">
			<div class="card-header bg-transparent p-2">
			  <h5 class="m-0">Demand</h5>
			</div>
			<div class="card-body bg-transparent p-3">
			  <h2 class="h1">Low</h2>
			</div>
		  </div>
			
		</div>
	</div>

		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="form-group card card-body bg-light mt-5">
				<label class="font-weight-bold h5" for="customRange3">
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

				<div class="card card-body mt-2 p-2">
					<div class="row m-0">
						<div class="col-md-1 py-2 bg-danger">
							
						</div>
						<div class="col-md-10 text-left">
							<strong>Pricing $20</strong>
						</div>
					</div>
					 
				</div>

			</div>
		</div>
	  
	  

	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-outline-dark border-warning px-5" data-dismiss="modal">Close</button>
	  <button type="submit" class="btn btn-success px-5">Save</button>
	</div>
	</form>
	</div>
	</div>
</div>