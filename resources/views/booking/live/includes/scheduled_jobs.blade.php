
<div class="col-md-9">

  <h1>Scheduled Jobs</h1>
  <hr>
@if(isset($user_bookings[0]))
	@foreach($user_bookings as $booking)
  <div class="card card-body hvr-shadow job-item mb-4">
	<a href="dashboard/{{$booking->booking_id}}">
	<div class="row">
	  <div class="col-md-12">
		<h3 class="h5 pb-2 mb-2 border-bottom">Booking Date: {{$booking->booking_date}} <span class="float-right text-warning">$152</span></h3>
	  </div>
	  <div class="col-md-4">
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-location-arrow"></i> Pickup Location</small> <br>
		{{$booking->s_address}}</p>
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-map-marker-alt"></i> Destination Location</small> <br>
		{{$booking->d_address}}</p>
	  </div>
	  <div class="col-md-4">                
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-hourglass-start"></i> Start Time:</small><br>{{$booking->start_time}}</p>
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-hourglass-start"></i>  End Time:</small><br>{{$booking->end_time}}</p>                
	  </div>
	  <div class="col-md-4">                
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-people-carry"></i> Service Type:</small><br>Small Move</p>
		<p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-tasks"></i> Selected Items:</small>
		<br>{{isset($item_count[$booking->booking_id]) ? $item_count[$booking->booking_id] : 0}}</p>
	  </div>
	</div>
	</a>            
  </div>
@endforeach
@endif

  
</div>
