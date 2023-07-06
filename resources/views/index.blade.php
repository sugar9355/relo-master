@extends('user.layout.app')

@section('content')
    <style>
        .nav-active {
            background-color: #c71515;
            border: 2px solid black;

        }

        /* For Firefox */
        input[type='number'] {
            -moz-appearance: textfield;
        }

        /* Webkit browsers like Safari and Chrome */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        textarea {
            resize: none;
        }

        input[type=radio]:checked {
            box-shadow: 0 0 0 3px orange;
            border: 1px #ffff00 solid;
        }
    </style>
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        .radio {
            position: relative;
            cursor: pointer;
            line-height: 20px;
            font-size: 14px;
        }

        .radio .label {
            position: relative;
            display: block;
            float: left;
            margin-right: 10px;
            width: 20px;
            height: 20px;
            border: 2px solid #c8ccd4;
            border-radius: 100%;
            -webkit-tap-highlight-color: transparent;
        }

        .radio .label:after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 10px;
            height: 10px;
            border-radius: 100%;
            background: #225cff;
            transform: scale(0);
            transition: all 0.2s ease;
            opacity: 0.08;
            pointer-events: none;
        }

        .radio:hover .label:after {
            transform: scale(3.6);
        }

        input[type="radio"]:checked + .label {
            border-color: #225cff;
        }

        input[type="radio"]:checked + .label:after {
            transform: scale(1);
            transition: all 0.2s cubic-bezier(0.35, 0.9, 0.4, 0.9);
            opacity: 1;
        }

        .cntr {
            position: absolute;
            top: calc(50% - 35px);
            left: 0;
            width: 100%;
            text-align: center;
        }

        .hidden {
            display: none;
        }

        .credit {
            position: fixed;
            right: 20px;
            bottom: 20px;
            transition: all 0.2s ease;
            -webkit-user-select: none;
            user-select: none;
            opacity: 0.6;
        }

        .credit img {
            width: 72px;
        }

        .credit:hover {
            transform: scale(0.95);
        }

        .parking-info .radio .label {
            display: block;
        }

        .storageHubLabel {
            font-size: 18px;
            text-align: center;
            display: block;
        }

    </style>
    <!--ENDS HEADING-->
    <!--STARTS SLIDER-->

    <!--END SLIDERS-->

    @if(count($locationPoints))
        <form action="location/store" id="formLocation" method="post">
            {{ csrf_field() }}
            <div>
                <div class="heading">
                    <h1>LOCATION DETAILS</h1>
                </div>
            </div>
            @if($storageHubs)
                <div class="container">
                    <div class="heading row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4" id="storageHub">
                            <label for="storageHub" class="storageHubLabel">Select Hub</label>
                            <select name="storageHub" id="storageHub" class="form-control">
                                @foreach($storageHubs as $storageHub)
                                    <option value="{{ $storageHub->name }}">{{ $storageHub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="heading row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div id="choose"></div>
                            <button style="background: #aa0113;" id="showInputField" class="btn btn-danger d-block mx-auto">Choose Your Own</button>
                        </div>
                    </div>
                </div>
            @endif
        <!--ADD LOCATION DETAILS STARTS -->
            {{--<div class="form">
                <div class="col-12 text-center">
                    <a href="/shop"><u> I don't know my location yet</u></a>
                </div>
            </div>--}}
            <div class="">
                <div class="col-12 text-center text">
                    <p>We won't share your exact location until your small haul movers' scheduled with a helper</p>
                </div>
            </div>
            <!--ADD LOCATION ENDS-->
            <!--LOCATION DETAILS BOX STARTS-->
			<table>
				<tr>
            @foreach($locationPoints as $index => $locationPoint)
			<td>
                <div class="container">
                    <div class="row">
                        <section class="border section col-md-10 offset-md-1">
                            <div class="form-row form-group">
                                <div class="col-12 text-center pickup-details">
                                    <h4>Location {{ $index + 1 }}</h4>
                                </div>
                            </div>

                            <div class="form-row form-group">
                                <div class="col-12 text-center pickup-details" style="margin-top: 0;">
                                    <h4>{{ $locationPoint }}</h4>
                                </div>
                            </div>

                            <div class="form-row text-center justify-content-center form-group">
                                <h6 class="h6">
                                    <label class="form-label">Unit Or Apartment Number: &nbsp;</label>
                                </h6>
                                <div class="col-1">
                                    <input type="text" class="from-control wap-form-edit w-100" id="zipCodes"
                                           name="floor[]"
                                           value="{{ isset($locationDetail->floor[$index]) ? $locationDetail->floor[$index] : null }}">
                                </div>
                            </div>

                            <div class="form-row text-center justify-content-center form-group">
                                <h6 class="h6">
                                    <label class="form-label" for="zipCodes">Zip Code: &nbsp;</label>
                                </h6>
                                <div class="col-2">
                                    <input type="number" class="from-control wap-form-edit w-100" id="zipCodes"
                                           name="zip_code[]"
                                           onkeypress="checkLimit(this)"
                                           value="{{ isset($locationDetail->zip_code[$index]) ? $locationDetail->zip_code[$index] : null }}">
                                </div>
                            </div>

                            <div class="form-row  form-group">
                                <div class="col-1"></div>
                                <div class="col-8">
                                    <div class="row">
                                        <input type="checkbox" name="location_question1[]"
                                               onchange="show(this)"
                                               value="check" checked>
                                        <label for="location_question1">How will the movers be moving the furniture?</label>
                                    </div>
                                </div>
                            </div>

                            <div id="stairsElevator_{{ $index }}">
                                <div class="form-row  form-group">
                                    <div class="col-1"></div>
                                    <div class="col-8">
                                        <div class="row">
                                            <div class="form-check-inline">
                                                <label class="form-check-label radio">
                                                    @php
                                                        $objectIndex = "type_".$index
                                                    @endphp
                                                    <input type="radio" class="form-check-input" value="Stairs" {{ isset($locationDetail->$objectIndex) ?
                                                ($locationDetail->$objectIndex == 'Stairs') ? 'checked' : null
                                                : null }} onclick="showHideChild(this, {{ $index }})" hidden checked name="type_{{ $index }}">
                                                    <span class="label"></span>Stairs
                                                </label>
                                            </div>
                                            <div class="form-check-inline p-2">
                                                <label class="form-check-label radio">
                                                    <input type="radio" class="form-check-input" value="Elevator" {{ isset($locationDetail->$objectIndex) ?
                                                ($locationDetail->$objectIndex == 'Elevator') ? 'checked' : null
                                                : null }} onclick="showHideChild(this, {{ $index }})" hidden name="type_{{ $index }}">
                                                    <span class="label"></span>Elevator
                                                </label>
                                            </div>

                                            <div class="form-check-inline p-2">
                                                <label class="form-check-label radio">
                                                    <input type="radio" class="form-check-input" value="Both" {{ isset($locationDetail->$objectIndex) ?
                                                ($locationDetail->$objectIndex == 'Both') ? 'checked' : null
                                                : null }} onclick="showHideChild(this, {{ $index }})" hidden name="type_{{ $index }}">
                                                    <span class="label"></span>Both
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="stairs_{{$index}}">
                                    <div class="form-row form-group">
                                        <div class="col-1"></div>
                                        <div class="col-8">
                                            <div class="row">
                                                <label for="stair_type">What kind of stairs are they? </label>
                                                <div class="col-md-12 px-0">

                                                    <div id="stair_type">
                                                        @php
                                                            $objectIndex = "stair_type_".$index
                                                        @endphp
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label radio">
                                                                <input type="radio" class="form-check-input" name="stair_type_{{ $index }}"
                                                                       {{ isset($locationDetail->$objectIndex) ?
                                                                        ($locationDetail->$objectIndex == 'Windy') ? 'checked' : null
                                                                        : null }} value="Windy" hidden>
                                                                <span class="label"></span>Windy
                                                            </label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label radio">
                                                                <input type="radio" class="form-check-input" name="stair_type_{{ $index }}"
                                                                       {{ isset($locationDetail->$objectIndex) ?
                                                                        ($locationDetail->$objectIndex == 'Narrow') ? 'checked' : null
                                                                        : null }} value="Narrow" hidden>
                                                                <span class="label"></span>Narrow
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row  form-group">
                                        <div class="col-1"></div>
                                        <div class="col-8">
                                            <div class="row">
                                                <label for="">how many flights are there ?</label>
                                                <select  placeholder="How many flights" class="form-control"
                                                       name="flight[]"
                                                       >
                                                       <option>0 to 1</option>
                                                       <option>1 to 2</option>
                                                       <option>2 to 3</option>
                                                       <option>3 to 4</option>
                                                       <option>4 to 5</option>
                                                      
                                                       
                                                       
                                                       </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="elevator_{{$index}}" style="display: none;">
                                    <div class="form-row form-group">
                                        <div class="col-1"></div>
                                        <div class="col-8">
                                            <div class="row">
                                                <label for="elevator_type">What kind of elevator will they be using?</label>
                                                <div class="col-md-12 px-0">
                                                    <div id="elevator_type">
                                                        @php
                                                            $objectIndex = "elevator_type_".$index
                                                        @endphp
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label radio">
                                                                <input type="radio" class="form-check-input" name="elevator_type_{{ $index }}"
                                                                       {{ isset($locationDetail->$objectIndex) ?
                                                                        ($locationDetail->$objectIndex == 'Freight') ? 'checked' : null
                                                                        : null }} value="Freight" hidden>
                                                                <span class="label"></span>Freight
                                                            </label>
                                                        </div>
                                                        <div class="form-check-inline">
                                                            <label class="form-check-label radio">
                                                                <input type="radio" class="form-check-input" name="elevator_type_{{ $index }}"
                                                                       {{ isset($locationDetail->$objectIndex) ?
                                                                        ($locationDetail->$objectIndex == 'Passenger') ? 'checked' : null
                                                                        : null }} value="Passenger" hidden>
                                                                <span class="label"></span>Passenger
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row  form-group">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="row">
                                        <h6 style="display: block;">Parking and building info.</h6>
                                        <div class="col-md-12 parking-info">
                                            <div class="row">
                                                @php
                                                    $objectIndex = "parking_".$index
                                                @endphp
                                                <div class="col-12">
                                                    <label for="opt1_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Loading dock will be reserved') ? 'checked' : null : null }}
                                                               value="Loading dock will be reserved" id="opt1_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Loading dock will be reserved
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt2_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Parking permit will be pulled') ? 'checked' : null : null }}
                                                               value="Parking permit will be pulled" id="opt2_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Parking permit will be pulled
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt3_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Metered parking available') ? 'checked' : null : null }}
                                                               value="Metered parking available" id="opt3_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Metered parking available
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt4_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Commercial parking available') ? 'checked' : null : null }}
                                                               value="Commercial parking available" id="opt4_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Commercial parking available
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt5_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Easy street parking available') ? 'checked' : null : null }}
                                                               value="Easy street parking available" id="opt5_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Easy street parking available
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt6_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Home driveway available') ? 'checked' : null : null }}
                                                               value="Home driveway available" id="opt6_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Home driveway available
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="opt7_{{ $index }}" class="radio">
                                                        <input type="radio" name="parking_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Other') ? 'checked' : null : null }}
                                                               value="Other" id="opt7_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<textarea class="col-12" rows="3" id="location_note[]" name="location_note[]"
                                                  placeholder="Parking and building info.">{{ isset($locationDetail->location_note[$index]) ? $locationDetail->location_note[$index] : null }}</textarea>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row  form-group">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="row">
                                        <h6 style="display: block;">Are there any long walks at any of the locations specified above?</h6>
                                        <p style="display: block;">
                                            Take a stop watch and walk from your items to where our vehicle would be parked.

                                            If it takes over 30 seconds, this is considered a long walk.

                                            This can greatly affect the estimated time so please do not skip this question.
                                        </p>
                                        <div class="col-md-12 parking-info">
                                            <div class="row">
                                                @php
                                                    $objectIndex = "walk_".$index
                                                @endphp
                                                <div class="col-12">
                                                    <label for="walk1_{{ $index }}" class="radio">
                                                        <input type="radio" name="walk_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'Yes') ? 'checked' : null : null }}
                                                               value="Yes" checked id="walk1_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>Yes
                                                    </label>
                                                </div>
                                                <div class="col-12">
                                                    <label for="walk2_{{ $index }}" class="radio">
                                                        <input type="radio" name="walk_{{ $index }}"
                                                               {{ isset($locationDetail->$objectIndex) ?
                                                               ($locationDetail->$objectIndex == 'No') ? 'checked' : null : null }}
                                                               value="No" id="walk2_{{ $index }}" class="hidden"/>
                                                        <span class="label"></span>No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<textarea class="col-12" rows="3" id="location_note[]" name="location_note[]"
                                                  placeholder="Parking and building info.">{{ isset($locationDetail->location_note[$index]) ? $locationDetail->location_note[$index] : null }}</textarea>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row  form-group">
                                <div class="col-1"></div>
                                <div class="col-10">
                                    <div class="row">
                                        <label for="">Add Your Detailed Address Here</label>
                                        <textarea class="col-12" rows="3" id="detail_address[]" name="detail_address[]"
                                                  placeholder="Detailed Address Here">{{ isset($locationDetail->detail_address[$index]) ? $locationDetail->detail_address[$index] : null }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                </td>
        @endforeach
		</tr>
		</table>
        <!--LOCATION DETAILS BOX ENDS-->
            <!--SAVE AND BACK BUTTONS-->
            <div class="container">
                <div class="row">
                    <section class="col-md-12 text-right">
                        
                            <a href="javascript:;" class="btn btn-danger back">Back</a>
                            <a href="javascript:;" onclick="$('#formLocation').submit()" class="btn btn-danger back">Save &
                                Continue</a>
                        
                    </section>
                </div>
            </div>
            <!--SAVE AND BACK BUTTONS-->
        </form>
        <script>
			function setServiceType(name) {
				$("#serviceType").val(name);
			}

			function show(me, div) {
				$(me).attr('checked', true);
			}

			function showHideChild(me, index) {
				let val = $(me).val().toLowerCase();
				$("#stairs_" + index).hide();
				$("#elevator_" + index).hide();

				if (val == 'stairs') {
					$("#stairs_" + index).show();
				}

				if (val == 'elevator') {
					$("#elevator_" + index).show();
				}

				if (val == 'both') {
					$("#stairs_" + index).show();
					$("#elevator_" + index).show();
				}
			}

			function checkLimit(me) {
				let val = $(me).val().toString();
				console.log(val);
				if (val.length > 4) {
					val = val.substring(0, val.length - 1);
				}
				$(me).val(parseInt(val));
			}
        </script>
    @else
        <script>
			window.onload = function () {
				alert("Please Select Location First!");
				window.location.href = "/map";
			}
        </script>
    @endif


@endsection

@section('scripts')
    <script>
		$(function () {
			$("#showInputField").on('click', (e) => {
            	e.preventDefault();
				$("#storageHub").parent().remove();
				let html = `<label for="storageHub" class="storageHubLabel">Enter Hub</label>
                            <input type="text" id="storageHub" name="storageHub" class='form-control' placeholder="Enter Your Hub Address">`;
				$("#choose").html(html);
				$("#showInputField").remove();
			})
		})
    </script>
@endsection