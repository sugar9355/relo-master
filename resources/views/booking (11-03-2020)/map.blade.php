@extends('user.layout.app')

@section('styles')
   
@endsection

@section('content')

 <div class="container my-5"> 
    <h4 class="text-center animated fadeIn delay-0-2s">SELECT LOCATION</h4>
        <hr>
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
                <div class="col-md-8  animated fadeIn">
                    {{--map--}}
                    <div id="map"  style="width:100%;height:600px;background:#ccc"></div>
                </div>
                {{--End map --}}
                <div class="col-md-4">
                    <div class="card mb-3 animated slideInRight delay-0-2s">
                        <div class="card-body hvr-shadow d-block">                            
                            <h4> Select Route <i class="fas fa-shipping-fast fa-flip-horizontal float-right animated slideInLeft delay-1s"></i></h4>
                            <hr>

                            <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                  </div>
								  
                                  <input class="form-control m-0" id="start" name="location[]" value="@if(isset($booking->s_address)) {{$booking->s_address}} @endif" type="text" placeholder="Start Location" required>
                                </div>
                            </div>
                                <input type="hidden" id="s_lat" name="s_lat" value="">
                                <input type="hidden" id="s_lng" name="s_lng" value="">
                                <input type="hidden" id="d_lat" name="d_lat" value="">
                                <input type="hidden" id="d_lng" name="d_lng" value="">
								
                                <input type="hidden" id="distance" name="distance" value="">
                                <input type="hidden" id="minutes" name="minutes" value="">
								
								<input type="hidden" id="distanceMinutes" name="distanceMinutes" value="">
								<input type="hidden" id="distanceShow" name="distanceShow" value="">
								
                                <input type="hidden" id="over_all_distance" name="over_all_distance" value="">
                                <input type="hidden" id="over_all_minutes" name="over_all_minutes" value="">
								
                                <div id="way_points_list"></div>

                            <a class="my-3 btn btn-outline-secondary btn-block" onclick="add_new_map_row()" href="javascript:;">
                                <i class="far fa-plus-square"></i>  Add Another Stop
                            </a>

                            <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                  </div>
                                  <input class="form-control m-0" id="end" name="location[]" type="text" value="@if(isset($booking->d_address)) {{$booking->d_address}} @endif " placeholder="Destination" required>
                                </div>
                            </div>
                    </div>

                </div>
				<div class="col-md-12 text-center">
                <hr>
				<a href="/booking/{{ ($booking->booking_id) ?: null }}/1" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
				<button id="dataFormBtn" name="btn_submit" type="submit" value="2" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue  <i class="fas fa-chevron-right hvr-icon"></i></button>
				
			</div>

                <div id="present_text" style="display:none;" class="card card-body bg-dark text-white mt-3 animated slideInUp delay-0-6s">
                    
					<div class="col-md-12">Travel Distance :  <font id="distance_text"></font> km</div>
					<div class="col-md-12">Travel Minutes :  <font id="time_text"></font> mins</div>
					
                </div>
				
                </div>
			
			
		</div>

			
    </form>
	

	
</div>

@endsection

@section("scripts")
    <script src="{{asset('asset/js/map-autocomplete.js')}}"></script>
    <script>
	
	$(document).ready(function() 
	{
	  $(window).keydown(function(event){
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	  });
	});
	
        $(document).ready(function() 
		{
		
			
			@if(isset($booking->s_address)) 
				$("#start").val('{{$booking->s_address}}'); 
			@endif
			@if(isset($booking->d_address)) 
				$("#end").val('{{$booking->d_address}}'); 
			@endif
		
        });

   
        var map, info;
        let markers = [];
        let status = "ALL";
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();


        if( navigator.geolocation ) {
            navigator.geolocation.getCurrentPosition( success, fail );
        } else {
            console.log('Sorry, your browser does not support geolocation services');
            initialize();
        }

        function success(position)
        {

            if(position.coords.longitude != "" && position.coords.latitude != ""){
                current_longitude = position.coords.longitude;
                current_latitude = position.coords.latitude;
            }

            initialize(current_latitude, current_longitude);
        }

        function fail()
        {
            initialize();
        }

        function initialize(latitude = 0, longitude = 0) {

            let mapOptions = {
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
				
				@if(isset($booking->s_lat) && isset($booking->s_lng))	
					center: new google.maps.LatLng({{$booking->s_lat}}, {{$booking->s_lng}})
				@else
					center: new google.maps.LatLng(latitude, longitude)
				@endif
				
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
			
            directionsDisplay.setMap(map);
			
			@if(isset($booking_location[0]))
			@foreach($booking_location as $k => $location)
			
				var myLatlng = new google.maps.LatLng({{$location->lat}},{{$location->lng}});
				var marker = new google.maps.Marker({
					position: myLatlng,
					title:"Hello World!"
				});
				
				//marker.setMap(map);
			
			@endforeach
			@endif
			
			// var lat_min = {{$booking->s_lat}};
			// var lat_max = {{$booking->d_lat}};
			// var lng_min = {{$booking->s_lng}};
			// var lng_max = {{$booking->d_lng}};
			
			// map.setCenter(new google.maps.LatLng(
			  // ((lat_max + lat_min) / 2.0),
			  // ((lng_max + lng_min) / 2.0)
			// ));
			// map.fitBounds(new google.maps.LatLngBounds(
			  // //bottom left
			  // new google.maps.LatLng(lat_min, lng_min),
			  // //top right
			  // new google.maps.LatLng(lat_max, lng_max)
			// ));
			
        }

        function hideinfoWindow() {
            if(typeof info != 'undefined' && info != null){
                info.close();
            }

        }

        function add_new_map_row() 
		{
            let index = $(".way_points").length;
            let html = `<div><ul class="dots"></ul>
            <div class="form-group">
				<div class="input-group"><div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-map-pin" onclick="removeRow(this)"></i></div>
					<input id="way_point${index}" name="waypoints[${index}][location]" class="way_points form-control m-0" type="text" placeholder="New Stop">
				</div>
			</div>`;
            html += `<input type="hidden" id="way_point_lat${index}" name="waypoints[${index}][lat]">
                <input type="hidden" id="way_point_lng${index}" name="waypoints[${index}][lng]"></div>`;
            $("#way_points_list").append(html);
            let id = "way_point"+index;
            let newWayPoint = document.getElementById(id);
            let wayPointSource = new google.maps.places.Autocomplete(newWayPoint);
            wayPointSource.addListener('place_changed',(function() {

                return function() 
				{
                    addWayPoint(this);
                }
            }(wayPointSource)));
        }
		
        function addWayPoint(searchBox) 
		{
            var place = searchBox.getPlace();
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            }

            updateRoute();
        }

        function removeRow(me) {
            $(me).parent().remove();
            updateRoute();
        }
    </script>
@endsection
