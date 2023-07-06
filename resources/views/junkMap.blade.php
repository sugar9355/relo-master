@extends('user.layout.app')

@section('styles')
    <style>
        body {
            height: 100%;
            width: 100%;
            margin: 0 !important;

        }
        .sidebar
        {
            background-color:#FECD2A;
            height:300px;
            overflow: scroll;
        }
        .btn-footer
        {
            background-color:#FECD2A;
            margin-top: 5px;
            border:none;
            width:120px;
            height:30px;
            float:right;
            margin-right:80px;
            text-align: center;
        }
        .sidebar2
        {
            background-color: #fff;
            height:300px;
        }
        .footer
        {
            width:100%;
            height:45px;
            background-color:#1f2b3b;
        }
        .sideimage
        {
            width:80px;
            height:50px;
            margin-top:70px;
        }
        .sidepara
        {
            margin-top:10px;
        }
        p
        {
            margin-top:20px;
        }
        a
        {
            color:#1f2b3b;
        }
        input
        {
            width: 90%;
            margin-top:20px;
            background:transparent;
            border-top:none;
            border-right:none;
            border-left:none;


        }
        .top-bar
        {
            width:100%;
            height:45px;
            background-color:#1f2b3b;
            background: repeating-linear-gradient(
                    -55deg,
                    #222,
                    #222 10px,
                    #333 10px,
                    #333 20px
            )
        }
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        .map {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .scroll{
            height: 360px;
            overflow: scroll;
            overflow-x: hidden;
        }
        .sidebar2
        {
            background-color: #fff;
            height: 186px; !important;
        }
        .dots{
            margin-bottom: -20px;
            margin-left: -20px;
            margin-top: -34px;
            color: white;
        }
    </style>

@endsection

@section('content')
    <form action="/map" method="post" id="mapForm">
        {{ csrf_field() }}
        <div class="heading">
            <h1>SELECT LOCATION</h1>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    {{--map--}}
                    <div id="map"  style="width:100%;height:600px;background:#ccc"></div>
                </div>
                {{--End map --}}
                <div class="col-md-3">
                    <div class="scroll">
                        <i class="fa fa-circle-o" aria-hidden="true"></i>&nbsp &nbsp<input id="start" name="start" value="{{ ($mapDetails['start']) ?: null }}" type="text" placeholder="Start Location"><br/><br/>
                        <input type="hidden" id="s_lat" name="s_lat" value="{{ ($mapDetails['s_lat']) ?: null }}">
                        <input type="hidden" id="s_lng" name="s_lng" value="{{ ($mapDetails['s_lng']) ?: null }}">
                        <input type="hidden" id="distance" name="distance" value="{{ ($mapDetails['distance']) ?: '0' }}">
                        <input type="hidden" id="minutes" name="minutes" value="{{ ($mapDetails['minutes']) ?: '0' }}">
                        <div id="way_points_list">
                            @if(isset($mapDetails['waypoints']))
                                @foreach($mapDetails['waypoints'] as $index => $wayPoint)
                                    <div>
                                        <i class="fa fa-times" onclick="removeRow(this)"></i>&nbsp &nbsp<input id="way_point{{$index}}" name="waypoints[]" class="way_points" type="text" value="{{ $wayPoint }}" placeholder="New Stop"><br/><br/>
                                        <input type="hidden" id="way_point_lat{{ $index }}" name="way_point_lats[]" value="{{ $mapDetails['way_point_lats'][$index] }}">
                                        <input type="hidden" id="way_point_lng{{ $index }}" name="way_points_lngs[]" value="{{ $mapDetails['way_points_lngs'][$index] }}">
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <a onclick="add_new_map_row()" href="javascript:;">
                            <h6> <i class="fa fa-plus-square-o"></i> &nbsp  Add Another Stop</h6>
                        </a>
                    </div>
                    <br/>
                    <br/>
                    <div class="col-md-12">
                        <div class="row sidebar2">
                            <br>
                            <div class="col-sm-4">
                                <img src="http://smallhaulbooking.distance123.com/asset/img/bus.png" class="sideimage">
                            </div>
                            <div class="col-sm-6">
                                <p> <b id="distanceMinutes">{{ ($mapDetails['minutes']) ?: '0' }} </b>Minutes Travel <br> <b id="distanceShow">{{ ($mapDetails['distance']) ?: '0' }} </b> Miles</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="footer">
                    <a href="javascript:;" id="mapFormSubmitBtn" class="btn-footer">Continue</a>
                </div>
            </div>
        </div>
    </form>

@endsection

@section("scripts")
    <script src="{{asset('asset/js/junkMap-autocomplete.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $("#mapFormSubmitBtn").on('click', function () {
                let distance = $("#distance").val();
                console.log(distance);
                if (distance == 0) {
                    alert("Please Enter Atlest Pickup And Drop Location");
                    return false;
                }
                $("#mapForm").submit();
            })

        });

    </script>
    <script>
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
                center: new google.maps.LatLng(latitude, longitude)
            };

            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            directionsDisplay.setMap(map);
        }

        function hideinfoWindow() {
            if(typeof info != 'undefined' && info != null){
                info.close();
            }

        }

        function add_new_map_row() {
            let index = $(".way_points").length;
            let html = `<div><ul class="dots"><li></li><li></li><li></li></ul><i class="fa fa-times" onclick="removeRow(this)"></i>&nbsp &nbsp<input id="way_point${index}" name="waypoints[]" class="way_points" type="text" placeholder="New Stop"><br/><br/>`;
            html += `<input type="hidden" id="way_point_lat${index}" name="way_point_lats[]">
                <input type="hidden" id="way_point_lng${index}" name="way_points_lngs[]"></div>`;
            $("#way_points_list").append(html);
            let id = "way_point"+index;
            let newWayPoint = document.getElementById(id);
            let wayPointSource = new google.maps.places.Autocomplete(newWayPoint);
            wayPointSource.addListener('place_changed',(function() {
                return function() {
                    addWayPoint(this);
                }
            }(wayPointSource)));
        }
        function addWayPoint(searchBox) {
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
