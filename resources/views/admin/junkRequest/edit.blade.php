@extends('admin.layout.base')

@section('title', 'Request details ')

@section('styles')
    <style type="text/css">
        .panel-group .panel {
            border-radius: 0;
            box-shadow: none;
            border-color: #EEEEEE;
        }

        .panel-default > .panel-heading {
            padding: 0;
            border-radius: 0;
            color: #212121;
            background-color: #FAFAFA;
            border-color: #EEEEEE;
        }

        .panel-title {
            font-size: 14px;
        }

        .panel-title > a {
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .more-less {
            float: right;
            color: #212121;
        }

        .panel-default > .panel-heading + .panel-collapse > .panel-body {
            border-top-color: #EEEEEE;
        }

        .fc-day-grid-event.fc-h-event.fc-event.fc-start.fc-end {
            background-color: #3a87ad !important;
            border-color: #3a87ad !important;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div >
                <h4>Request details</h4>
                <div class="row">
                    <form action="{{ route('admin.user_junk_request.update', $request->id) }}" method="post">
                        <input type="hidden" name="_method" value="PATCH">

                        {{ csrf_field() }}
                        <div class="col-md-12">
                            @if(\Illuminate\Support\Str::startsWith($request->date_type, 'F'))
                                <input type="hidden" id="prefer_date" value="{{ $request->prefer_date }}">
                                <input type="hidden" id="secondary_dates" value="{{ $request->date }}">
                            @endif
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseTwo"
                                               aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                Status
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    @if($request->status == 'Pending')
                                                        <label for="start" class="col-md-12 col-form-label">Submit
                                                            Date</label>
                                                        <div class="col-md-12">
                                                            {{ $request->created_at }}
                                                        </div>
                                                    @else
                                                        <label for="start" class="col-md-12 col-form-label">Booking
                                                            Date</label>
                                                        <div class="col-md-12">
                                                            {{ $request->booking_date }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="type" class="col-md-12 col-form-label">Deposit</label>
                                                    <div class="col-md-12">
                                                        {{ $request->deposit }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">


                                                <div class="form-group">
                                                    <label for="end" class="col-md-12 col-form-label">Status</label>
                                                    <div class="col-md-12">
                                                        {{ $request->status }}
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="floor" class="col-md-12 col-form-label">Quote</label>
                                                    <div class="col-md-12">
                                                        ${{ $request->quotation }}
                                                        <br>
                                                        Mileage: {{ round($request->distance / 1.609) }} mi
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseOne"
                                               aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                Job Detail
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="name"
                                                           class="col-md-12 col-form-label">@lang('admin.name')</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->user->first_name . ' ' . $request->user->last_name }}"
                                                               name="name" id="name" placeholder="Name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="move_type" class="col-md-12 col-form-label">Move
                                                        Type</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" id="move_type" type="text"
                                                               value="Small Move" required
                                                               placeholder="Move Type">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="email"
                                                           class="col-md-12 col-form-label">@lang('admin.email')</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->user->email }}"
                                                               name="email"
                                                               id="email" placeholder="Name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="start" class="col-md-12 col-form-label">Start</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->s_address }}"
                                                               name="start"
                                                               id="start" placeholder="Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <label for="floor" class="col-md-12 col-form-label">Start Floor</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->locations->first()->floor }} Floor"
                                                               name="floor" id="floor" placeholder="Name">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="end" class="col-md-12 col-form-label">End</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->d_address }} Floor"
                                                               name="end" id="end" placeholder="Name">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="floor" class="col-md-12 col-form-label">End Floor</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ $request->locations->last()->floor }} Floor"
                                                               name="floor" id="floor" placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12 col-form-label">Inventory</label>
                                                    <div class="col-md-12">
                                                        <a target="_blank" class="btn btn-block btn-info"
                                                           href="{{ route('admin.user_junk_request.show', $request->id) }}">View
                                                            Inventory</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                               href="#collapseThree"
                                               aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                Estimate
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
                                         aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        <label for="min"
                                                               class="col-md-12 col-form-label">Min</label>
                                                        <input class="form-control" type="text"
                                                               name="min" value="{{ $request->min }}"
                                                               id="min" placeholder="Quotation">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="max"
                                                               class="col-md-12 col-form-label">Max</label>
                                                        <input class="form-control" type="text"
                                                               name="max" value="{{ $request->max }}"
                                                               id="max" placeholder="Quotation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="mileage"
                                                           class="col-md-12 col-form-label">Mileage</label>
                                                    <div class="col-md-12">
                                                        <input class="form-control" type="text"
                                                               value="{{ round($request->distance / 1.609) }}" name="mileage"
                                                               id="mileage"
                                                               readonly
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="col-md-6">
                                                        @if($request->date_type == "FF")
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label for="mySelect">Select Date</label>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <select name="booking_date" class="form-control" onchange="changeTime(this)"
                                                                            id="mySelect">
                                                                        <optgroup label="Preferred Date">
                                                                            <option value="{{ $request->prefer_date }}"
                                                                                    data-time="{{ $request->prefer_time }}">{{ $request->prefer_date }}</option>
                                                                        </optgroup>
                                                                        <optgroup label="Secondary Date">
                                                                            @foreach(explode(',', $request->date) as $index => $date)
                                                                                <option value="{{ $date }}"
                                                                                        data-time='{{ json_encode(json_decode($request->time)[$index]) }}'>{{ $date }}</option>
                                                                            @endforeach
                                                                        </optgroup>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @if(\Illuminate\Support\Str::startsWith($request->date_type, 'F'))
                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <label for="select2">Select Date</label>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <select name="booking_date" class="form-control" id="select2">
                                                                            <optgroup label="Preferred Date">
                                                                                <option value="{{ $request->prefer_date }}"
                                                                                        data-time="{{ $request->prefer_time }}">{{ $request->prefer_date }}</option>
                                                                            </optgroup>
                                                                            <optgroup label="Secondary Date">
                                                                                @foreach(explode(',', $request->date) as $index => $date)
                                                                                    <option value="{{ $date }}">{{ $date }}</option>
                                                                                @endforeach
                                                                            </optgroup>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <label for="date"
                                                                       class="col-md-12 col-form-label">Date</label>
                                                                <input class="form-control" type="text"
                                                                       name="booking_date" value="{{ $request->date }}"
                                                                       id="date" readonly>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        @if($request->date_type == "FF")
                                                            <label for="time"
                                                                   class="col-md-12 col-form-label">Time</label>
                                                            <select name="time" class="mySelect form-control" id="time">
                                                                @foreach(json_decode($request->time) as $myTime)
                                                                    <option value="{{ $myTime[0] }}">{{ $myTime[0] }}</option>
                                                                @endforeach
                                                            </select>
                                                        @else
                                                            @if(\Illuminate\Support\Str::endsWith($request->date_type, 'F'))
                                                                <label for="time"
                                                                       class="col-md-12 col-form-label">Time</label>
                                                                <select name="time" class="mySelect form-control" id="time">
                                                                    @foreach(json_decode($request->time) as $myTime)
                                                                        <option value="{{ $myTime[0] }}">{{ $myTime[0] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            @else
                                                                <label for="date"
                                                                       class="col-md-12 col-form-label">Time</label>
                                                                <input class="form-control" type="text"
                                                                       name="time" value="{{ $request->time }}"
                                                                       id="date" readonly>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if($request->status != 'Pending')
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFour">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                   href="#collapseFour"
                                                   aria-expanded="true" aria-controls="collapseOne">
                                                    <i class="more-less glyphicon glyphicon-plus"></i>
                                                    Schedule
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel"
                                             aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="select2"
                                                               class="col-md-12 col-form-label">Zone Type</label>
                                                        <input type="hidden" id="select2Val"
                                                               value="{{ $request->zonetype }}">
                                                        <div class="col-md-12">
                                                            <select name="zonetype[]" id="select1"
                                                                    class="form-control select2" value="" multiple>
                                                                @foreach($zoneTypes as $index => $zoneType)
                                                                    <option value="{{ $zoneType->zip_code }}"> {{ $zoneType->zip_code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="select2"
                                                               class="col-md-12 col-form-label">Vehicle Schedule</label>
                                                        <div class="col-md-12">
                                                            <select name="vehicle_schedule" id="select2"
                                                                    class="form-control select2">
                                                                @foreach($vehicleSchedules as $vehicleSchedule)
                                                                    <option value="{{ $vehicleSchedule->name }}" {{ ($vehicleSchedule->name == $request->vehicle_schedule) ? 'selected' : null }}> {{ $vehicleSchedule->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="select3"
                                                               class="col-md-12 col-form-label">Vehicle Type</label>
                                                        <div class="col-md-12">
                                                            <select name="vehicle_type" id="select3"
                                                                    class="form-control select2">
                                                                @foreach($vehicleTypes as $vehicleType)
                                                                    <option value="{{ $vehicleType->name }}" {{ ($vehicleType->name == $request->vehicle_type) ? 'selected' : null }}> {{ $vehicleType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">

                            <button class="btn btn-info" type="submit">{{ ($request->status == 'ASSIGNED') ? 'Complete' : 'Submit' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div id="calender">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
		function changeTime(me, id = null) {
			if (id === null) {
				id = "time";
			}
			let val = $(me).find(":selected").data("time");
			let html = "";
			val.forEach(time => {
				html += `<option value="${time}">${time}</option>`;
			});
			$("#" + id).html(html);
		}

		$(function () {
            @if(\Illuminate\Support\Str::startsWith($request->date_type, 'F'))
                let preferDate = $("#prefer_date").val();
                let secondaryDates = $("#secondary_dates").val().split(',');
                $('#select2').select2({
                    width: 'auto',
                    dropdownAutoWidth: true,
                });
                $('#calender').fullCalendar({
                    dayRender: function (date, cell) {
                        if (preferDate != null) {
                            if (preferDate === date.format("YYYY-MM-DD")) {
                                cell.css("background-color", "red");
                            }
                            if (secondaryDates.indexOf(date.format("YYYY-MM-DD")) > -1) {
                                cell.css("background-color", "blue");
                            }
                            // console.log(date.format("YYYY-MM-DD"));
                        }
                    },
                    eventSources: [
                        {
                            url: '{{ route('admin.getStorageEventsCount') }}', // use the `url` property
                            color: 'yellow',    // an option!
                            textColor: 'black'  // an option!
                        }
                    ],
                    eventRender: function (eventObj, $el) {
                        let title = $el.find('.fc-title');
                        title.html(title.text());
                    },
                });
            @endif
		})
    </script>
@endsection
