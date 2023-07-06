@extends('admin.layout.base')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="m-0">Godseye 
                 <div class="btn-group float-right">
                    <button class="btn btn-primary godseye_menu" data-value="true">On Trip</button>
                    <button class="btn btn-primary godseye_menu" data-value="false">Off Trip</button>
                    <button class="btn btn-primary godseye_menu" data-value="ALL">All</button>
                </div>
            </h4>
            <hr>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <div class="input-group">
                        <input type="text" name="s_address" class="form-control form-control-lg" id="s_address" placeholder="Pickup Address" required>
                        <input type="hidden" id="s_latitude">
                        <input type="hidden" id="s_longitude">
                        <span class="input-group-append">                            
                            <span class="input-group-text bg-primary border-primary text-white">
                                <i class="icon-pin-alt"></i>
                            </span>
                        </span>
                    </div>
                    </div>
                    
                    <h3 class="m-0 py-1 border-bottom">All</h3>
                    <ul class="media-list provider_list pt-3">                                 

                        
                    </ul>
                </div>
                <div class="col-md-8">
                    <div id="map" style="width:100%;height:500px;background:#ccc"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script type="text/javascript" src="{{asset('asset/js/rating.js')}}"></script>
    <script type="text/javascript" src="{{ asset('asset/js/dispatcher-map-admin.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places"></script>
    <script type="text/javascript">

        var map, info;
        let markers = [];
        let status = "ALL";

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

            let mapInterval = setInterval(getProviders, 5000);

            let mapOptions = {
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                center: new google.maps.LatLng(latitude, longitude)
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Create the search box and link it to the UI element.
            let input = document.getElementById('s_address');
            let searchBox = new google.maps.places.SearchBox(input);
            // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            let markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                let places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                let bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    let icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                clearInterval(mapInterval);
                getProviders();
                mapInterval = setInterval(getProviders, 5000);
                map.fitBounds(bounds);
            });

            $('.godseye_menu').on('click', function() {
                $('.provider_title').text($(this).text());
                status = $(this).data('value');
                $(this).addClass('btn-primary').siblings().removeClass('btn-primary');
                clearInterval(mapInterval);
                getProviders();
                mapInterval = setInterval(getProviders, 5000);
            });


            function getProviders() {

                $.get("/admin/godeye/status/"+status, function(data) {
                    removeMarkers();
                    let locations = data.data.locations;
                    let providers = data.data.providers;

                    $('.provider_list').empty();

                    for (let i = 0; i < locations.length; i++) {

                        let marker = new google.maps.Marker({
                            icon: { scaledSize: new google.maps.Size(20, 35), url : locations[i].car_image },
                            map: map,
                            position: new google.maps.LatLng(locations[i].lat, locations[i].lng)
                        });

                        marker.provider = providers[i];

                        marker.addListener('click', function(e) {
                            selectProvider(this);
                            scrollList(this);
                        });


                        let onClick = function(marker){
                            return function() {
                                selectProvider(marker);
                            }
                        };

                        let image = "/asset/img/grey.png";


                        if(providers[i].onTrip == true) {
                            image = "/asset/img/green.png";
                        }
                        if(providers[i].onTrip == false) {
                            image = "/asset/img/blue.png";
                        }

                        let avatar = (providers[i].avatar == null || providers[i].avatar == "") ? "https://schedule.tranxit.co/main/avatar.jpg" : providers[i].avatar ;

                        avatar = (avatar.startsWith("http")|| avatar.startsWith("https")) ? avatar : "/storage"+"/"+providers[i].avatar;

                        let li = $(`<li class="media border-bottom" id="`+providers[i].id+`">
                                        <div class="mr-3">
                                                <img class="rounded-circle" src="`+avatar+`" width="auto" height="70">
                                           
                                            <img src="`+image+`">
                                        </div>
                                        <div class="media-body">
                                        <div class="media-title font-weight-semibold">`+providers[i].name+`</div>
                                        <span class="text-muted mr-2">`+providers[i].location+`</span><br>
                                        <span class="text-muted mr-2">Speed: `+Math.round(providers[i].speed)+`</div>
                                    </li>`).on('click', onClick(marker) );

                        $('.provider_list').append(li);

                        markers.push(marker);
                    }


                });
            }

            function selectProvider(marker) {
                return showinfoWindow(marker);
            }

            function scrollList(marker){
                let item = $('.provider_list').find('li[id='+marker.provider.id+']');

                if(item) {
                    let position = $(".provider_list").scrollTop() - $(".provider_list").offset().top + item.offset().top;
                    $(".provider_list").animate({scrollTop : position}, 500);
                }
            }

            function removeMarkers() {
                for (let i in markers) {
                    if(typeof markers[i] !== 'undefined') markers[i].setMap(null);
                }
            }

            function showinfoWindow(marker) {

                hideinfoWindow();


                let avatar = (marker.provider.avatar == null || marker.provider.avatar == "") ? "https://schedule.tranxit.co/main/avatar.jpg" : marker.provider.avatar ;

                let html = `<table>
				<tbody>
					<tr><td rowspan="5"><img src="`+avatar+`" width="auto" height="70"></td></tr>
					<tr><td>&nbsp;&nbsp;Name: </td><td><b>`+marker.provider.name+`</b></td></tr>
					<tr><td>&nbsp;&nbsp;Speed: </td><td><b>`+Math.round(marker.provider.speed)+`</b></td></tr>
					<tr><td>&nbsp;&nbsp;Location: </td><td><b>`+marker.provider.location+`</b></td></tr>`+
                    `</tbody>
			</table>`;

                info = new google.maps.InfoWindow({
                    content: html,
                    maxWidth: 350
                });

                info.open(map, marker);
            }

            getProviders();
        }

        function hideinfoWindow() {
            if(typeof info != 'undefined' && info != null){
                info.close();
            }

        }


    </script>

@endsection
