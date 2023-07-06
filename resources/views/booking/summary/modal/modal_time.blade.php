<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-body text-center">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
<div class="p-5 my-2 mx-4">

<h5 class="font-weight-bolder text-info">Please Select your desired date/time</h5>
<p class="text-muted">(Tip: The Larger the window better the chance of service)</p>

<div class="row mt-2">
<div class="col-md-2">
  <div class="card hvr-shadow w-100 text-center border-info">
	<div class="card-header bg-info text-white p-1">{{date('F', strtotime($booking->booking_date))}}</div>
	<div class="card-body lead font-weight-bold p-2">{{date('d', strtotime($booking->booking_date))}}</div>
  </div>
</div>
<div class="col-md-9">
	<div class="form-group">
	
		<label id="time_slider_{{1}}_{{1}}" class="font-weight-bold" for="customRange3" >Time Range: 6:00 AM - 6:00 PM</label>
		
		<div id="slider_{{1}}_{{1}}" class="slider"></div>
		<div class="break text-center" style="background: ;"></div>
		<div class="clock">
			@foreach($working_hours as $clock)
				<span class="segment">{{explode(' ',$clock->time)[0]}}<br></span>
			@endforeach
		</div>
	</div>
</div>

</div>

<p class="text-info">Last minute request can be served but we will need to verify which out the crew members. There may be additional fees.</p>

<a type="button" class="btn btn-secondary text-white btn-lg mt-3" id="reload" data-dismiss="modal">Request Time</a>

</div>
  </div>
</div>
</div>
</div>
