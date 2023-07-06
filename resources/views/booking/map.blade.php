@extends('user.layout.app')

@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/style-map.css')}}">
<style>
    .container: {
        max-width: 1140px;
    }
    .nopad{
        padding-right: 0px;
        padding-left:7px;
    }
    .pos-icon{
        position: relative;
    right: -97px;
    top: -66px;
    }
    @media only screen and (max-width: 414px)  {
        .pos-icon{
        position:relative; right: -14px;
    top: -66px;
    }
    }
</style>
@endsection

@section('content')
<div class="container my-5"> 
    <h4 class="text-center animated fadeIn delay-0-2s">SELECT LOCATION</h4>
    <hr>
        
    @if(session()->get("msg") != '') 
        
        <div class="alert alert-danger">
            <strong>Oops!</strong> {!! session()->get("msg") !!} 
        </div>
    
        @php session()->remove("msg"); @endphp
    
    @endif
        
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
            {{-- Map --}}
            <div class="col-md-8 animated fadeIn">
                <div id="map" style="width:100%;height:500px;background:#ccc"></div>
            </div>
            {{--End Map --}}
            <div class="col-md-4">
                <p class="map-text">Find your location on the map</p>
                <div class="col-12 d-flex flex-wrap bd-highlight ">
                    <div id="way_points_list">
                    <div class="row">
                    
                       
                            <div class="col-1 ">
                                <img class="mt-3" src="{{asset('asset/img/map-imgs/1.png')}}" alt="">
                            </div>
                            <div  class="flex-column col-11  col-md-10 col-sm-6">
                                <label class="pure-material-textfield-outlined">
                                    <input placeholder=" " id="start" name="location[]" type="text"
                                        value="@if(isset($booking->s_address)) {{$booking->s_address}} @endif" aria-describedby="basic-addon2" required>
                                    <span>Address</span>
                                </label>
                                <label class="pure-material-checkbox" data-toggle="tooltip"
                                data-placement="right" title="We leave Furniture at your Door step (Save up-to $100)">
                                <input class="chk" type="checkbox" name="curbside[1]" @if(isset($booking_location[0])&&$booking_location[0]->curbside==1)checked @endif >
                                <span>Pickup: Curbside</span>
                            </label>
                            </div>                      
                     
                        
                     
                    

          
                      
                </div>  
                    </div>

                    </div>
             <div class="col-12 d-flex flex-wrap bd-highlight">
                    <p class="  cur btnAddtoList" style="cursor: pointer" onclick="add_new_map_row()">
                        <span class="text-primary "> <i class="fas fa-plus-circle"></i> For moves with more </span>
                    </p>
             </div>
                    <div class="col-12 d-flex flex-wrap bd-highlight ">
                  
                        <div class="row">
                        <div  class="col-1 ">
                            
                            <img src="{{asset('asset/img/map-imgs/2.png')}}" alt="">
                        </div>
                        <div style="" class="flex-column col-11  col-md-10 col-sm-6">
           
                <label class="pure-material-textfield-outlined">
                    <input placeholder=" " id="end" name="location[]" value="@if(isset($booking->d_address)) {{$booking->d_address}} @endif" type="text"
                        aria-describedby="basic-addon2" />
                    <span>Destination</span>
                </label>
                <label class="pure-material-checkbox" data-toggle="tooltip"
                    data-placement="right" title="We leave Furniture at your Door step (Save up-to $100)">
                    <input class="chk" type="checkbox" name="curbside[1]" @if(isset($booking_location[1])&&$booking_location[1]->curbside==1)checked @endif >
                    <span>Drop-off: Curbside</span>
                </label>
            </div>
                           
             
                        </div>
                    </div>
                    </div>

                 
                </div>

                <input type="hidden" id="s_lat" name="s_lat" value="">
                <input type="hidden" id="s_lng" name="s_lng" value="">
                <input type="hidden" id="s_zipcode" name="s_zipcode" value="">
                <input type="hidden" id="d_lat" name="d_lat" value="">
                <input type="hidden" id="d_lng" name="d_lng" value="">
                <input type="hidden" id="d_zipcode" name="d_zipcode" value="">
                
                <input type="hidden" id="distance" name="distance" value="">
                <input type="hidden" id="minutes" name="minutes" value="">
                
                <input type="hidden" id="distanceMinutes" name="distanceMinutes" value="">
                <input type="hidden" id="distanceShow" name="distanceShow" value="">
                
                <input type="hidden" id="over_all_distance" name="over_all_distance" value="">
                <input type="hidden" id="over_all_minutes" name="over_all_minutes" value="">
                
                <input type="hidden" id="overallDistanceShow" name="" value="">
                <input type="hidden" id="overallDistanceMinutes" name="" value="">

                <div class="col-md-12 text-center mt-5">
                    <a href="/booking/{{ ($booking->booking_id) ?: null }}/1" name="btn_save_step_back" type="submit" value="5" class="btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal" ><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
                    <button id="dataFormBtn" name="btn_submit" type="submit" value="2" class="btn btn-primary m-auto hvr-icon-wobble-horizontal">Save & Continue  <i class="fas fa-chevron-right hvr-icon"></i></button>
                </div>
    
                <div id="present_text" style="display:none;background-color: {{$Textdefine[0]->color}}" class="card card-body  text-white mt-3 animated slideInUp delay-0-6s" >
                    <div class="col-md-12" ></div>
                    <div class="col-md-12">Travel Distance :  <font id="distance_text"></font> miles</div>
                    <div class="col-md-12">Travel Minutes :  <font id="time_text"></font> mins</div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
<script src="{{asset('asset/js/map-autocomplete.js')}}"></script>
<script>
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

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
    // var directionsDisplay = new google.maps.DirectionsRenderer();

    let directionsDisplay1 = new google.maps.DirectionsRenderer()
    let directionsDisplay2 = new google.maps.DirectionsRenderer()

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
        
        directionsDisplay1.setOptions({
            map,
            suppressMarkers: true,
            suppressInfoWindows: true,
            polylineOptions: {
                strokeColor: 'blue'
            }
        });
        directionsDisplay2.setOptions({
            map,
            suppressMarkers: true,
            suppressInfoWindows: true,
        });
        
        @if(isset($booking_location[0]))
        @foreach($booking_location as $k => $location)
        
            var myLatlng = new google.maps.LatLng({{$location->lat}},{{$location->lng}});
            var marker = new google.maps.Marker({
                position: myLatlng,
                title:"Hello World!",
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

    function removeRow(me) {
        // $(me).parent().remove();
        $(me).parentsUntil("#way_points_list").remove();
        updateRoute();
    }
   
    function add_new_map_row() 
    {
        
        let index = $(".way_points").length;
      let html = `<div class="row"><div class="col-1 nopad"><img  src="{{asset('asset/img/map-imgs/3.png')}}" alt=""></div>`;
        html += `<div class="flex-column col-11  col-md-10 col-sm-6"><label id="xd" class="pure-material-textfield-outlined">`;
        html += `<input placeholder=" " id="way_points${index}" name="waypoints[${index}][location]" class="way_points form-control float-left col-12" placeholder="Additional Location" aria-describedby="basic-addon2"><span>Additional Location</span></label>`;
        html += `<a style="color:red; font-size: 30px; outline:none;float: right; " class="closeee pos-icon" onclick="removeRow(this)"><i  class="fa fa-times"></i></a>`
        html += `<label class="pure-material-checkbox " data-toggle="tooltip" data-placement="right" title="We leave Furniture at your Door step (Save up-to $100)"><input class="chk" style="margin-right:5px;" type="checkbox" name="curbside[${parseInt(index) + 2}]"><span>Drop-off: Curbside</span></label>`
        html += `<input type="hidden" name="waypoints[${index}][lat]" id="way_point_lat${index}">`
        html += `<input type="hidden" name="waypoints[${index}][lng]" id="way_point_lng${index}"></div></div>`

        $("#way_points_list").append(html);
        let id = "way_points"+index;
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

    $(document).ready(function () {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( {'address': $('#start').val()}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
            }
            updateSourceForm(latitude, longitude);
            updateRoute();
        });
        geocoder.geocode( {'address': $('#end').val()}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
            }
            updateDestinationForm(latitude, longitude);
            updateRoute();
        });
    })

</script>
@endsection