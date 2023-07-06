  <style type="text/css">
        #map {
            height: 450px;
        }
    </style>
<div class="col-md-9">

          <h1>Job Details <small class="float-right">Date: 30 Jan, 2020</small></h1>
          <hr>

          <div class="card card-body mb-4">
		  
		  <div id="map"></div>
		  
            <hr>
            <div class="row">
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-location-arrow"></i> Pickup Location</small> <br>
                @if(isset($booking->s_address)){{$booking->s_address}}@endif</p>
              </div>
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-map-marker-alt"></i> Destination Location</small> <br>
                @if(isset($booking->d_address)){{$booking->d_address}}@endif</p> 
              </div>
            </div>

            <hr>          

            <div class="row">
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-hourglass-start"></i> Start Time:</small><br>@if(isset($booking->start_time)){{$booking->start_time}}@endif</p>
              </div>
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-hourglass-start"></i> End Time:</small><br>@if(isset($booking->end_time)){{$booking->end_time}}@endif</p>
              </div>
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller"><i class="fas fa-people-carry"></i> Service Type:</small><br>Small Move</p>
              </div>

              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller">Secondary Date:</small><br>@if(isset($booking->secondary_date)){{$booking->secondary_date}}@endif</p>
              </div>
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller">Travel Distance:</small><br>@if(isset($booking->minutes)){{$booking->minutes}}@endif mins</p>
              </div>
              <div class="col-md-6">
                <p class="lead text-dark"><small class="text-muted smaller">Over All Distance Time</small><br>@if(isset($booking->over_all_minutes)){{$booking->over_all_minutes}}@endif mins</p>
              </div>
            </div>            
          </div>

            <h4>Selected Items <small>@if(isset($selected_items)) {{count($selected_items)}} @endif</small></h4>
            <hr>
			@if(isset($selected_items[0]))
				@foreach($selected_items as $item)
				<div class="card card-body mb-3">
				  <div class="row">
					<div class="col-md-4">{{$item->item_name}}</div>
					<div class="col-md-4 text-md-center">x @if(isset($item->ratio)){{ explode(':',$item->ratio)[1] }} @endif</div>
					<div class="col-md-4 text-right"><span class="span badge badge-dark">Insured</span> <span class="span badge badge-dark">@if($item->Pakaging == 1) Packeging @endif</span></div>
				  </div>
				</div>
				@endforeach
			@endif
          
        </div>
		
<script type="text/javascript">

	var s_lat =  @if(isset($booking->s_lat)){{$booking->s_lat}}@endif;
	var s_lng = @if(isset($booking->s_lng)){{$booking->s_lng}}@endif;

	var d_lat = @if(isset($booking->d_lat)){{$booking->d_lat}}@endif;
	var d_lng = @if(isset($booking->d_lng)){{$booking->d_lng}}@endif;

</script>

<script src="{{asset('asset/js/location.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places&callback=initMap" async defer></script>