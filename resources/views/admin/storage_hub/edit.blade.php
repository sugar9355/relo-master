@extends('admin.layout.base')

@section('title', 'Add Storage Hub ')

@section('styles')
    <style>

        .tg-list {
            text-align: center;
            display: flex;
            align-items: center;
        }

        .tg-list-item {
            margin: 0 2em;
        }

        .tgl {
            display: none;
        }

        .tgl, .tgl:after, .tgl:before, .tgl *, .tgl *:after, .tgl *:before, .tgl + .tgl-btn {
            box-sizing: border-box;
        }

        .tgl::-moz-selection, .tgl:after::-moz-selection, .tgl:before::-moz-selection, .tgl *::-moz-selection, .tgl *:after::-moz-selection, .tgl *:before::-moz-selection, .tgl + .tgl-btn::-moz-selection {
            background: none;
        }

        .tgl::selection, .tgl:after::selection, .tgl:before::selection, .tgl *::selection, .tgl *:after::selection, .tgl *:before::selection, .tgl + .tgl-btn::selection {
            background: none;
        }

        .tgl + .tgl-btn {
            outline: 0;
            display: block;
            width: 4em;
            height: 2em;
            position: relative;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .tgl + .tgl-btn:after, .tgl + .tgl-btn:before {
            position: relative;
            display: block;
            content: "";
            width: 50%;
            height: 100%;
        }

        .tgl + .tgl-btn:after {
            left: 0;
        }

        .tgl + .tgl-btn:before {
            display: none;
        }

        .tgl:checked + .tgl-btn:after {
            left: 50%;
        }

        .tgl-flat + .tgl-btn {
            padding: 2px;
            transition: all .2s ease;
            background: #fff;
            border: 4px solid #f2f2f2;
            border-radius: 2em;
        }

        .tgl-flat + .tgl-btn:after {
            transition: all .2s ease;
            background: #f2f2f2;
            content: "";
            border-radius: 1em;
        }

        .tgl-flat:checked + .tgl-btn {
            border: 4px solid #7FC6A6;
        }

        .tgl-flat:checked + .tgl-btn:after {
            left: 50%;
            background: #7FC6A6;
        }

        #label {
            display: inline-block;
            width: 155px !important;
        }

        .tgl-btn {
            display: inline-block !important;
            margin: 0 15px -9px !important;
        }
    </style>
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div >
                <a href="{{ route('admin.storage_hub.index') }}" class="btn btn-default pull-right"><i
                            class="fa fa-angle-left"></i> @lang('admin.back')</a>

                <h5 style="margin-bottom: 2em;">Add Storage Hub</h5>

                <form class="form-horizontal" action="{{route('admin.storage_hub.update', $storageHub->id)}}" method="POST"
                      enctype="multipart/form-data" role="form">

                    {{csrf_field()}}

                    {{method_field('PUT')}}

                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->name }}" name="name" required id="name" placeholder="Name">
                            <input type="hidden" name="lat" id="lat">
                            <input type="hidden" name="lng" id="lng">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="day" class="col-md-12 col-form-label">Per Day Price</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->day }}" name="day" required id="day" placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="week" class="col-md-12 col-form-label">Per Week Price</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->week }}" name="week" required id="week" placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="month" class="col-md-12 col-form-label">Per Month Price</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->month }}" name="month" required id="month"
                                   placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="year" class="col-md-12 col-form-label">Per Year Price</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->year }}" name="year" required id="year" placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_sq_feet" class="col-md-12 col-form-label">Total Square Feet</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->total_sq_feet }}" name="total_sq_feet" required
                                   id="total_sq_feet" placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="sq_feet" class="col-md-12 col-form-label">Pre Square Feet Price</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ $storageHub->sq_feet }}" name="sq_feet" required
                                   id="sq_feet" placeholder="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-12 col-form-label">Pricing Logic</label>
                        <div class="col-md-12 tg-list">
                            <div class="tg-list-item">
                                <h4 id="label">Square Feet Logic</h4>
                                <input class="tgl tgl-flat" name="time" onclick="changeLabel(this)" value="1"
                                       {{ ($storageHub->time) ? 'checked' : null }} id="cb4" type="checkbox"/>
                                <label class="tgl-btn" for="cb4"></label>
                            </div>
                        </div>
                    </div>

                    <div id="myRoomsList">
                        @foreach($storageHub->rooms as $index => $room)
                            <div id="room_{{ $index + 1 }}">
                                <div class="form-group">
                                    <label for="room_name" class="col-md-12 col-form-label">Room {{ $index + 1 }} Name</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="room_name[]" required
                                               id="room_name" value="{{ $room->name }}" placeholder="Enter Room Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="room_sq" class="col-md-12 col-form-label">Room {{ $index + 1 }} Square Feet</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="room_sq[]" required
                                               id="room_sq" value="{{ $room->sq_feet }}" placeholder="100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <div class="col-md-10">
                            <a href="javascript:;" onclick="addRow()" class="btn btn-primary">Add Room</a>
                            <a href="javascript:;" onclick="removeRow()" class="btn btn-danger">Remove Room</a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="zipcode" class="col-md-12 col-form-label"></label>
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary">Add Storage Hub</button>
                            <a href="{{route('admin.storage_hub.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
		function addRow() {
			let selector = $('div[id^="room"]');
			let index = selector.length;
			let row = parseInt($(selector[index - 1]).attr("id").split("_")[1]) + 1;
			let html = `
	                    <div id="room_${row}">
                            <div class="form-group">
                                <label for="room_name" class="col-md-12 col-form-label">Room ${row} Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="room_name[]" required
                                           id="room_name" placeholder="Enter Room Name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="room_sq" class="col-md-12 col-form-label">Room ${row} Square Feet</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="room_sq[]" required
                                           id="room_sq" placeholder="100">
                                </div>
                            </div>
                        </div>
	        `;

			$("#myRoomsList").append(html);
		}

		function removeRow() {
			let selector = $('div[id^="room"]');
			let index = selector.length;
			if (index === 1) {
				return;
			}
			$(selector[index - 1]).remove();
		}

		function initMap() {

			let lat = document.getElementById('lat');
			let lng = document.getElementById('lng');
			let name = document.getElementById('name');
			let address = new google.maps.places.Autocomplete(name);

			address.addListener('place_changed', () => {
				let place = address.getPlace();
				if (!place.geometry) {
					window.alert("Autocomplete's returned place contains no geometry");
					return;
				}
				let locationObject = place.geometry.location;
				lat.value = locationObject.lat();
				lng.value = locationObject.lng();
			});

		}

		function changeLabel(me) {
			let val = $(me).prop('checked');
			let label = $("#label");
			if (val) {
				label.html('Time Logic');
				return;
			}
			label.html('Square Feet Logic');
		}
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places&callback=initMap"></script>
@endsection
