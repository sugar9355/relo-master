<style>
.cursor{ cursor: pointer;}
</style>
<form id="frm_save_location" action="/update_location/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}

<div class="bg-white py-3">
  <div class="container-fluid">
	<div class="row loc-points">
		
		@foreach($booking_location as $k => $loc)
		
			<div class="col-md-{{12/count($booking_location)}}">
				<p class="p-0 m-0">	
					<strong>
						@if($k==0)
							<i class="fa fa-location-arrow" aria-hidden="true"></i> Pickup Location 
						@elseif($k > 0 && $k < (count($booking_location)-1)) 
							<i class="fa fa-location-arrow" aria-hidden="true"></i> Add Stop Location 
						@else 
							Dropoff Location 
						@endif
						<i id="btn_edit_location{{$k}}" onclick="update_location({{$k}})" class="icon-pencil text-primary cursor"></i>
						<i id="btn_cancel_location{{$k}}" onclick="cancel_location({{$k}})" class="icon-cancel-circle2 text-danger cursor" style="display:none;"></i>
						<i id="btn_save_location{{$k}}" onclick="update_location({{$k}})" class="icon-checkmark-circle text-success cursor" style="display:none;"></i>
					</strong>
				</p>	
				
				<div id="loc_{{$k+1}}">{{$loc->location}} @if($k==0 || $k < (count($booking_location)-1))<i class="fas text-muted fa-long-arrow-alt-right fa-2x ml-4"></i>@endif</div>	
				
				<div id="loc_{{$k+1}}_edit" class="col-md-12" style="display:none;">
			
					<input class="form-control m-0" @if($k==0) id="start" @else id="end" @endif name="location[{{$k+1}}][location]" value="@if(isset($loc->location)) {{$loc->location}} @endif" type="text" placeholder="@if($k==0) Start @else End @endif Location" required>
					<input type="hidden" id="lat_{{$k+1}}" name="location[{{$k+1}}][lat]" value="{{$loc->lat}}">
					<input type="hidden" id="lng_{{$k+1}}" name="location[{{$k+1}}][lng]" value="{{$loc->lng}}">
					<input type="hidden"  name="location[{{$k+1}}][booking_loc_id]" value="{{$loc->booking_loc_id}}">
				
				</div>			
				
				
				
			</div>	
			
		  	  
		@endforeach 
		
	</div>
  </div>      
</div>

</form>