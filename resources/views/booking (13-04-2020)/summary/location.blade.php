<section class="bg-white py-3 px-md-3">

<div class="container-fluid">

<form id="frm_save_location" action="/update_location/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
    
	<div class="row form-inline">
	
		<div class="col-md-6">	
			<h5 class="pb-2">Trip</h5>
		</div>
		<div class="col-md-6">	
			<button type="button" id="btn_edit_location"   onclick="update_location();"  class="btn btn-sm btn-outline-dark float-right hvr-icon-wobble-horizontal">Edit <i class="far fa-edit"></i></button>
			<button type="submit" id="btn_save_location" class="btn btn-sm btn-outline-dark float-right hvr-icon-wobble-horizontal " style="display:none;">Save <i class="icon-checkmark2"></i></button>
			<button type="button" id="btn_cancel_location" onclick="cancel_location();" class="btn btn-sm  btn-outline-dark float-right hvr-icon-wobble-horizontal mr-2 " style="display:none;">Cancel <i class="icon-cross3"></i></button>
		</div>
	</div>

	<div class="row">
	<div class="col-md-9">
	<div class="row">
	@foreach($booking_location as $k => $loc)
	  <div class="col-md-6">
		
		<strong> @if($k==0) <i class="icon-location4"></i>Pickup Location @else <i class="icon-location3"></i> Dropoff Location @endif</strong><br>
		
		<p id="loc_{{$k+1}}">{{$loc->location}}</p>
		
		<div id="loc_{{$k+1}}_edit" style="display:none;">
			<input class="form-control m-0" @if($k==0) id="start" @else id="end" @endif name="location[{{$k+1}}][location]" value="@if(isset($loc->location)) {{$loc->location}} @endif" type="text" placeholder="@if($k==0) Start @else End @endif Location" required>
			
			<input type="hidden" id="lat_{{$k+1}}" name="location[{{$k+1}}][lat]" value="{{$loc->lat}}">
			<input type="hidden" id="lng_{{$k+1}}" name="location[{{$k+1}}][lng]" value="{{$loc->lng}}">
			<input type="hidden"  name="location[{{$k+1}}][booking_loc_id]" value="{{$loc->booking_loc_id}}">
		</div>
		
	  </div>
	@endforeach  
	 
	</div>
	</div>
	<div class="col-md-3">
	<div class="row">
	  <div class="col-md-6 p-0">
		<p><strong><i class="far fa-calendar-check"></i> Move Date</strong><br>12/03/2019</p>
	  </div>
	  <div class="col-md-6 p-0">
		<p><strong><i class="far fa-clock"></i> Pickup Time</strong><br>11:30 AM</p>
	  </div>
	</div>            
	</div>
	</div>    
	</div>
</form>
</section>
