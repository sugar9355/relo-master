@extends('user.layout.base')

@section('title', 'My Trips ')

@section('content')

    <style>
        p{
            padding: 1px!important;
        }
        .head-ing{
            margin-top: 500px;
            padding: 15px;
            width: 99%;
            margin-left: 5px;
        }
        .form-section2{
            padding: 15px;
            width: 99%;
            margin-left: 5px;
        }
        .form-section3{
            border-top: 1px solid #fff!important;
            margin-left: 15px!important;
            margin: 5px;
            margin-bottom: 15px;
            width: 93%;
        }
        .form-section4{
            border-top: 1px solid #fff!important;
            margin-left: 15px!important;
            margin: 5px;
            width: 93%;
            margin-bottom: 15px;
        }

    </style>
    <div class="col-md-9">
        <div class="dash-content">
            <div class="row">
                <div class="col-md-12">
                    <div id="map"></div>
                </div>
                <div class="form-body">
                    <h3 class="head-ing alert-info">Request details</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">User Name:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->user->first_name . ' ' . $request->user->last_name }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Booking Date:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->booking_date }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Accuracy:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->accuracy }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Packaging:</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->packaging }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <h3 class="form-section2 alert-info">Junk Removal details</h3>
                    <!--/row-->
                    @foreach(json_decode($request->junk_removal) as $junk_removal)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Item:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ \App\Inventory::find($junk_removal->id)->name }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Qty:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ $junk_removal->qty }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <h3 class="form-section2 alert-info">Address details</h3>
                    <div class="row">
                        @if($request->s_lat != null)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Start Location:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ $request->s_address }} </p>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <hr class=" form-section3 col-md-11">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Floor :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->floor }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Zip Code :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->zip_code }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">How will the movers be moving the furniture?:</label>
                                <div class="col-md-6">
                                    @if($request->locations->first()->flight == null)
                                        <p class="form-control-static"> Elevator </p>
                                    @elseif($request->locations->first()->elevator_type == null)
                                        <p class="form-control-static"> Stairs </p>
                                    @else
                                        <p class="form-control-static"> Both </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of stairs are they?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->stair_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">how many flights are there ?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->flight }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of elevator will they be using?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->elevator_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Detailed Address :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->detail_address }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Note :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->location_note }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Long Walk :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->first()->location_question2 }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Distance :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->distance . ' MI' }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        @foreach(json_decode($request->waypoints) as $index => $locations)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Stop Location {{ $index + 1 }}:</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ $locations }} </p>
                                    </div>
                                </div>
                            </div>
                            <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Floor :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->floor }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Zip Code :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->zip_code }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">How will the movers be moving the furniture?:</label>
                                <div class="col-md-6">
                                    @if($request->locations[$index+1]->flight == null)
                                        <p class="form-control-static"> Elevator </p>
                                    @elseif($request->locations[$index+1]->elevator_type == null)
                                        <p class="form-control-static"> Stairs </p>
                                    @else
                                        <p class="form-control-static"> Both </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of stairs are they?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->stair_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">how many flights are there ?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->flight }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of elevator will they be using?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->elevator_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Detailed Address :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->detail_address }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Note :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->location_note }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Long Walk :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations[$index+1]->location_question2 }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Distance :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->distance . ' MI' }} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Destination Address :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->d_address }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Floor :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->floor }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Zip Code :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->zip_code }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">How will the movers be moving the furniture?:</label>
                                <div class="col-md-6">
                                    @if($request->locations->last()->flight == null)
                                        <p class="form-control-static"> Elevator </p>
                                    @elseif($request->locations->last()->elevator_type == null)
                                        <p class="form-control-static"> Stairs </p>
                                    @else
                                        <p class="form-control-static"> Both </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of stairs are they?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->stair_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">how many flights are there ?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->flight }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">What kind of elevator will they be using?</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->elevator_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <hr class=" form-section3 col-md-11">
                    <!-- row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Detailed Address :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->detail_address }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Note :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->location_note }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Long Walk :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->location_question2 }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else:
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Note :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $request->locations->last()->location_note }} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <h3 class="form-section2 alert-info">Insurance details</h3>
                @foreach($request->insuranceDetails as $insuranceDetails)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label col-md-6">Insurance Type</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $insuranceDetails->insurance_type }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label col-md-6">Category</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $insuranceDetails->category_name }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label col-md-6">Qty</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $insuranceDetails->qty }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label col-md-6">Ratio</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $insuranceDetails->ratio }} </p>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                @endforeach

                <h3 class="form-section2 alert-info">Item details</h3>
                @foreach($request->userMovingRequestItems as $item)
                    <hr class=" form-section4 col-md-11">
                    {{--                        <span ></span>--}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Name :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $item->name }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <span class="col-md-12">Q/As</span>

                    <?php $cartOptions = json_decode($request->userMovingRequestItems[0]->options); ?>
                    @foreach($cartOptions->answersArray as $option)
                        @php $questionAnswerArray = explode('_', $option); @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Question :</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ \App\Question::find($questionAnswerArray[0])->title }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-6">Answer :</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static"> {{ $questionAnswerArray[1] }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                    @endforeach

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Additional Information :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ $cartOptions->additional_info }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Pickup Location :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ (isset($cartOptions->pickup)) ? $cartOptions->pickup : 'N/A' }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-6">Drop Locations :</label>
                                <div class="col-md-6">
                                    <p class="form-control-static"> {{ (isset($cartOptions->drop)) ? $cartOptions->drop : 'N/A' }} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
    </div>
@endsection

@section('styles')
    <style type="text/css">
        #map {
            height: 450px;
        }
    </style>
@endsection

@section('scripts')
    <script type="text/javascript">
		var map;
		var zoomLevel = 11;

		function initMap() {

			map = new google.maps.Map(document.getElementById('map'));

			let marker = new google.maps.Marker({
				map: map,
				icon: '/asset/img/marker-start.png',
				anchorPoint: new google.maps.Point(0, -29)
			});

			let markerSecond = new google.maps.Marker({
				map: map,
				icon: '/asset/img/marker-end.png',
				anchorPoint: new google.maps.Point(0, -29)
			});

			let bounds = new google.maps.LatLngBounds();
			let waypts = [];

            @foreach(json_decode($request->waypoints) as $index => $locations)
			waypts.push({
				'location': "{{ str_replace(' ', '+', $locations) }}",
				'stopover': true
			});
            @endforeach

				source = new google.maps.LatLng("{{ $request->s_lat }}", "{{ $request->s_lng }}");
			destination = new google.maps.LatLng("{{ $request->d_lat }}", "{{ $request->d_lng   }}");

			marker.setPosition(source);
			markerSecond.setPosition(destination);

			let directionsService = new google.maps.DirectionsService;
			let directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
			directionsDisplay.setMap(map);

			directionsService.route({
				origin: source,
				destination: destination,
				waypoints: waypts,
				travelMode: google.maps.TravelMode.DRIVING
			}, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK) {
					directionsDisplay.setDirections(result);
				}
			});

			bounds.extend(marker.getPosition());
			bounds.extend(markerSecond.getPosition());

                    @foreach(json_decode($request->way_point_lats) as $index => $lat)
			let marker{{ $index }} = new google.maps.Marker({
					map: map,
					icon: '/asset/img/marker-end.png',
					anchorPoint: new google.maps.Point(0, -29)
				});

			let markerPosition{{ $index }} = new google.maps.LatLng({{ $lat }}, {{ json_decode($request->way_points_lngs)[$index] }});
			marker{{ $index }}.setPosition(markerPosition{{ $index }});
			bounds.extend(marker{{ $index }}.getPosition());
            @endforeach

			map.fitBounds(bounds);
		}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places&callback=initMap" async defer></script>
@endsection

