{{-- <style>
    .time-factors .form-control {
        width: 70px;
    }
    .time-factors .form-control.btn {
        width: 80px;
    }
</style> --}}
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @for ($i = 1; $i <= 4; $i++)
    <li class="nav-item">
        <a class="nav-link {{($i == 1) ? 'active' : null}}" id="pills-worker_{{$i}}-tab" data-toggle="pill"
            href="#pills-worker_{{$i}}" role="tab" aria-controls="pills-worker_{{$i}}"
            aria-selected="{{($i == 1) ? 'true' : 'false'}}">{{$i}} {{($i == 1) ? 'Worker' : 'Workers'}}</a>
    </li>
    @endfor
</ul>

<div class="tab-content" id="pills-tabContent">
    @for ($j = 1; $j <= 4; $j++)
    <div class="tab-pane fade {{($j == 1) ? 'show active' : null}}" id="pills-worker_{{$j}}" role="tabpanel" aria-labelledby="pills-worker_{{$j}}-tab">

        <div class="row">
            <div class="col-2">
                <div class="mb-3 form-check form-check-switch form-check-switch-left">
                    <label class="form-check-label d-flex align-items-center">
                        <input name="check_num_workers[{{$j}}]" data-num_worker="{{$j}}" id="check_num_workers_{{$j}}" type="checkbox" value="1" data-on-color="primary" data-off-color="danger" data-on-text="Enable" data-off-text="Disable" class="form-check-input-switch" @if (isset($flights_min[$j]))checked @endif>
                    </label>
                </div>
            </div>
            @if ($j == 2)
            <div class="col-2">
                <div class="form-group col-6">
                    <button class="form-control btn btn-secondary" type="button" id="sh_show_btn">Shuffle</button>
                    <input type="hidden" value="0" id="sh_show">
                </div>
            </div>
            @endif
            @if ($j != 1)
            <div class="col-2">
                <div class="form-group">
                    <button class="form-control btn btn-info multiply" type="button" data-num_worker="{{$j}}">Multiply by</button>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <input class="form-control" type="number" value="0" step="0.01" id="by_{{$j}}">
                </div>
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col-2">
                <div class="nav flex-column nav-pills text-center" id="v-pills-tab-{{$j}}" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-flights-tab" data-toggle="pill" href="#v-pills-flights-{{$j}}" role="tab" aria-controls="v-pills-flights" aria-selected="true">Flights</a>
                    <a class="nav-link" id="v-pills-passenger-tab" data-toggle="pill" href="#v-pills-passenger-{{$j}}" role="tab" aria-controls="v-pills-passenger" aria-selected="false">Passenger</a>
                    <a class="nav-link" id="v-pills-freight-tab" data-toggle="pill" href="#v-pills-freight-{{$j}}" role="tab" aria-controls="v-pills-freight" aria-selected="false">Freight</a>
                    <a class="nav-link" id="v-pills-rs_freight-tab" data-toggle="pill" href="#v-pills-rs_freight-{{$j}}" role="tab" aria-controls="v-pills-rs_freight" aria-selected="false">Reserved Freight</a>
                    <a class="nav-link" id="v-pills-groundfloor-tab" data-toggle="pill" href="#v-pills-groundfloor-{{$j}}" role="tab" aria-controls="v-pills-groundfloor" aria-selected="false">Ground Floor</a>
                    <a class="nav-link" id="v-pills-bulkhead-tab" data-toggle="pill" href="#v-pills-bulkhead-{{$j}}" role="tab" aria-controls="v-pills-bulkhead" aria-selected="false">Bulkhead</a>
                    <a class="nav-link" id="v-pills-en_steps-tab" data-toggle="pill" href="#v-pills-en_steps-{{$j}}" role="tab" aria-controls="v-pills-en_steps" aria-selected="false">Entrance Steps</a>
                </div>
            </div>
            <div class="col-10 time-factors">
                <div class="tab-content" id="v-pills-tabContent-{{$j}}">
                    <div class="tab-pane fade show active" id="v-pills-flights-{{$j}}" role="tabpanel" aria-labelledby="v-pills-flights-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row" id="flights-box-{{$j}}">
                            @for ($i = 0; $i < 7; $i++)
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-info text-center">
                                        @if ($k == 0)
                                        <label>Flights</label>
                                        <input class="form-control text-center text-info" type="text" value="{{$i}}" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Min Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_min[$j][$i][$k]) ? $flights_min[$j][$i][$k] : 0}}" name="flights_min[{{$j}}][{{$i}}][{{$k}}]" id="flights_min_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_med[$j][$i][$k]) ? $flights_med[$j][$i][$k] : 0}}" name="flights_med[{{$j}}][{{$i}}][{{$k}}]" id="flights_med_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Max Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_max[$j][$i][$k]) ? $flights_max[$j][$i][$k] : 0}}" name="flights_max[{{$j}}][{{$i}}][{{$k}}]" id="flights_max_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_flights[$i][$k]) ? $sh_flights[$i][$k] : 0}}" name="sh_flights[{{$i}}][{{$k}}]" id="sh_flights_{{$i}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endfor
                            @endfor
                            @for ($k =0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-info text-center">
                                        @if ($k == 0)
                                        <label>Flights</label>
                                        <input class="form-control text-center text-info" type="text" value="7+" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Min Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_min[$j][7][$k]) ? $flights_min[$j][7][$k] : 0}}" name="flights_min[{{$j}}][{{7}}][{{$k}}]" id="flights_min_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_med[$j][7][$k]) ? $flights_med[$j][7][$k] : 0}}" name="flights_med[{{$j}}][{{7}}][{{$k}}]" id="flights_med_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-2 small-move">
                                        <label>Max Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($flights_max[$j][7][$k]) ? $flights_max[$j][7][$k] : 0}}" name="flights_max[{{$j}}][{{7}}][{{$k}}]" id="flights_max_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_flights[7][$k]) ? $sh_flights[7][$k] : 0}}" name="sh_flights[{{7}}][{{$k}}]" id="sh_flights_{{7}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                    {{-- @if ($j == 1 && $k == 1)
                                    <div class="col-4 form-group btn-box">
                                        <button class="form-control btn btn-info add-flight" type="button"
                                            data-num_worker="{{$j}}" value="{{7}}">Add</button>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-passenger-{{$j}}" role="tabpanel" aria-labelledby="v-pills-passenger-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row" id="passenger-box-{{$j}}">
                            @for ($i = 0; $i < 7; $i++)
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-info text-center">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="{{$i}}" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($passenger_time[$j][$i][$k]) ? $passenger_time[$j][$i][$k] : 0}}" name="passenger_time[{{$j}}][{{$i}}][{{$k}}]" id="passenger_time_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($passenger_delay[$j][$i][$k]) ? $passenger_delay[$j][$i][$k] : 0}}" name="passenger_delay[{{$j}}][{{$i}}][{{$k}}]" id="passenger_delay_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_passenger[$i][$k]) ? $sh_passenger[$i][$k] : 0}}" name="sh_passenger[{{$i}}][{{$k}}]" id="sh_passenger_{{$i}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endfor
                            @endfor
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-center text-info">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="7+" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($passenger_time[$j][7][$k]) ? $passenger_time[$j][7][$k] : 0}}" name="passenger_time[{{$j}}][{{7}}][{{$k}}]" id="passenger_time_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($passenger_delay[$j][7][$k]) ? $passenger_delay[$j][7][$k] : 0}}" name="passenger_delay[{{$j}}][{{7}}][{{$k}}]" id="passenger_delay_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_passenger[7][$k]) ? $sh_passenger[7][$k] : 0}}" name="sh_passenger[{{7}}][{{$k}}]" id="sh_passenger_{{7}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                    {{-- @if ($j == 1 && $k == 1)
                                    <div class="col-3 form-group btn-box">
                                        <button class="form-control btn btn-info add-elevator" type="button" value="{{7}}" data-type="passenger" data-num_worker="{{$j}}">Add</button>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-freight-{{$j}}" role="tabpanel" aria-labelledby="v-pills-freight-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row" id="freight-box-{{$j}}">
                            @for ($i = 0; $i < 7; $i++)
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-center text-info">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="{{$i}}" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($freight_time[$j][$i][$k]) ? $freight_time[$j][$i][$k] : 0}}" name="freight_time[{{$j}}][{{$i}}][{{$k}}]" id="freight_time_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($freight_delay[$j][$i][$k]) ? $freight_delay[$j][$i][$k] : 0}}" name="freight_delay[{{$j}}][{{$i}}][{{$k}}]" id="freight_delay_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_freight[$i][$k]) ? $sh_freight[$i][$k] : 0}}" name="sh_freight[{{$i}}][{{$k}}]" id="sh_freight_{{$i}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endfor
                            @endfor
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-center text-info">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="7+" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($freight_time[$j][7][$k]) ? $freight_time[$j][7][$k] : 0}}" name="freight_time[{{$j}}][{{7}}][{{$k}}]" id="freight_time_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($freight_delay[$j][7][$k]) ? $freight_delay[$j][7][$k] : 0}}" name="freight_delay[{{$j}}][{{7}}][{{$k}}]" id="freight_delay_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_freight[7][$k]) ? $sh_freight[7][$k] : 0}}" name="sh_freight[{{7}}][{{$k}}]" id="sh_freight_{{7}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                    {{-- @if ($j == 1 && $k == 1)
                                    <div class="col-3 form-group btn-box">
                                        <button class="form-control btn btn-info add-elevator" type="button" value="{{7}}" data-type="freight" data-num_worker="{{$j}}">Add</button>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-rs_freight-{{$j}}" role="tabpanel" aria-labelledby="v-pills-rs_freight-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row" id="rs_freight-box-{{$j}}">
                            @for ($i = 0; $i < 7; $i++)
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-center text-info">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="{{$i}}" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($rs_freight_time[$j][$i][$k]) ? $rs_freight_time[$j][$i][$k] : 0}}" name="rs_freight_time[{{$j}}][{{$i}}][{{$k}}]" id="rs_freight_time_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($rs_freight_delay[$j][$i][$k]) ? $rs_freight_delay[$j][$i][$k] : 0}}" name="rs_freight_delay[{{$j}}][{{$i}}][{{$k}}]" id="rs_freight_delay_{{$j}}_{{$i}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_rs_freight[$i][$k]) ? $sh_rs_freight[$i][$k] : 0}}" name="sh_rs_freight[{{$i}}][{{$k}}]" id="sh_rs_freight_{{$i}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endfor
                            @endfor
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-2 text-center text-info">
                                        @if ($k == 0)
                                        <label>Floor</label>
                                        <input class="form-control text-center text-info" type="text" value="7+" disabled />
                                        @endif
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Required Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($rs_freight_time[$j][7][$k]) ? $rs_freight_time[$j][7][$k] : 0}}" name="rs_freight_time[{{$j}}][{{7}}][{{$k}}]" id="rs_freight_time_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    <div class="form-group col-3 small-move">
                                        <label>Additional Delay</label>
                                        <input class="form-control text-right" type="text" value="{{isset($rs_freight_delay[$j][7][$k]) ? $rs_freight_delay[$j][7][$k] : 0}}" name="rs_freight_delay[{{$j}}][{{7}}][{{$k}}]" id="rs_freight_delay_{{$j}}_{{7}}_{{$k}}"readonly />
                                    </div>
                                    @if ($j == 2)
                                    <div class="form-group col-3 sh-move">
                                    </div>
                                    <div class="form-group col-3 sh-move">
                                        <label>Multiplier</label>
                                        <input class="form-control text-right" type="text" value="{{isset($sh_rs_freight[7][$k]) ? $sh_rs_freight[7][$k] : 0}}" name="sh_rs_freight[{{7}}][{{$k}}]" id="sh_rs_freight_{{7}}_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    @endif
                                    {{-- @if ($j == 1 && $k == 1)
                                    <div class="col-3 form-group btn-box">
                                        <button class="form-control btn btn-info add-elevator" type="button" value="{{7}}" data-type="rs_freight" data-num_worker="{{$j}}">Add</button>
                                    </div>
                                    @endif --}}
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-groundfloor-{{$j}}" role="tapanel" aria-labelledby="v-pills-groundfloor-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (no steps)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_min[$j]['no_steps'][$k]) ? $groundfloor_min[$j]['no_steps'][$k] : 0}}" name="groundfloor_min[{{$j}}][no_steps][{{$k}}]" id="groundfloor_min_{{$j}}_no_steps_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_med[$j]['no_steps'][$k]) ? $groundfloor_med[$j]['no_steps'][$k] : 0}}" name="groundfloor_med[{{$j}}][no_steps][{{$k}}]" id="groundfloor_med_{{$j}}_no_steps_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_max[$j]['no_steps'][$k]) ? $groundfloor_max[$j]['no_steps'][$k] : 0}}" name="groundfloor_max[{{$j}}][no_steps][{{$k}}]" id="groundfloor_max_{{$j}}_no_steps_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (1 to 3)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_min[$j]['1to3'][$k]) ? $groundfloor_min[$j]['1to3'][$k] : 0}}" name="groundfloor_min[{{$j}}][1to3][{{$k}}]" id="groundfloor_min_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_med[$j]['1to3'][$k]) ? $groundfloor_med[$j]['1to3'][$k] : 0}}" name="groundfloor_med[{{$j}}][1to3][{{$k}}]" id="groundfloor_med_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_max[$j]['1to3'][$k]) ? $groundfloor_max[$j]['1to3'][$k] : 0}}" name="groundfloor_max[{{$j}}][1to3][{{$k}}]" id="groundfloor_max_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (4 to 5)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_min[$j]['4to5'][$k]) ? $groundfloor_min[$j]['4to5'][$k] : 0}}" name="groundfloor_min[{{$j}}][4to5][{{$k}}]" id="groundfloor_min_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_med[$j]['4to5'][$k]) ? $groundfloor_med[$j]['4to5'][$k] : 0}}" name="groundfloor_med[{{$j}}][4to5][{{$k}}]" id="groundfloor_med_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_max[$j]['4to5'][$k]) ? $groundfloor_max[$j]['4to5'][$k] : 0}}" name="groundfloor_max[{{$j}}][4to5][{{$k}}]" id="groundfloor_max_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (8 to 12)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_min[$j]['8to12'][$k]) ? $groundfloor_min[$j]['8to12'][$k] : 0}}" name="groundfloor_min[{{$j}}][8to12][{{$k}}]" id="groundfloor_min_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_med[$j]['8to12'][$k]) ? $groundfloor_med[$j]['8to12'][$k] : 0}}" name="groundfloor_med[{{$j}}][8to12][{{$k}}]" id="groundfloor_med_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($groundfloor_max[$j]['8to12'][$k]) ? $groundfloor_max[$j]['8to12'][$k] : 0}}" name="groundfloor_max[{{$j}}][8to12][{{$k}}]" id="groundfloor_max_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-bulkhead-{{$j}}" role="tapanel" aria-labelledby="v-pills-bulkhead-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (1 to 3)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_min[$j]['1to3'][$k]) ? $bulkhead_min[$j]['1to3'][$k] : 0}}" name="bulkhead_min[{{$j}}][1to3][{{$k}}]" id="bulkhead_min_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_med[$j]['1to3'][$k]) ? $bulkhead_med[$j]['1to3'][$k] : 0}}" name="bulkhead_med[{{$j}}][1to3][{{$k}}]" id="bulkhead_med_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_max[$j]['1to3'][$k]) ? $bulkhead_max[$j]['1to3'][$k] : 0}}" name="bulkhead_max[{{$j}}][1to3][{{$k}}]" id="bulkhead_max_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (4 to 5)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_min[$j]['4to5'][$k]) ? $bulkhead_min[$j]['4to5'][$k] : 0}}" name="bulkhead_min[{{$j}}][4to5][{{$k}}]" id="bulkhead_min_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_med[$j]['4to5'][$k]) ? $bulkhead_med[$j]['4to5'][$k] : 0}}" name="bulkhead_med[{{$j}}][4to5][{{$k}}]" id="bulkhead_med_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_max[$j]['4to5'][$k]) ? $bulkhead_max[$j]['4to5'][$k] : 0}}" name="bulkhead_max[{{$j}}][4to5][{{$k}}]" id="bulkhead_max_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (8 to 12)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_min[$j]['8to12'][$k]) ? $bulkhead_min[$j]['8to12'][$k] : 0}}" name="bulkhead_min[{{$j}}][8to12][{{$k}}]" id="bulkhead_min_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_med[$j]['8to12'][$k]) ? $bulkhead_med[$j]['8to12'][$k] : 0}}" name="bulkhead_med[{{$j}}][8to12][{{$k}}]" id="bulkhead_med_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($bulkhead_max[$j]['8to12'][$k]) ? $bulkhead_max[$j]['8to12'][$k] : 0}}" name="bulkhead_max[{{$j}}][8to12][{{$k}}]" id="bulkhead_max_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-en_steps-{{$j}}" role="tapanel" aria-labelledby="v-pills-en_steps-tab">
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-info text-center">PickUp Time</h5>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-5">
                                <h5 class="text-info text-center">DropOff Time</h5>
                            </div>
                            <div class="col-1"></div>
                        </div>
                        <div class="row">
                            @for ($k = 0; $k < 2; $k++)
                            <div class="col-6">
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (1 to 3)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_min[$j]['1to3'][$k]) ? $en_steps_min[$j]['1to3'][$k] : 0}}" name="en_steps_min[{{$j}}][1to3][{{$k}}]" id="en_steps_min_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_med[$j]['1to3'][$k]) ? $en_steps_med[$j]['1to3'][$k] : 0}}" name="en_steps_med[{{$j}}][1to3][{{$k}}]" id="en_steps_med_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_max[$j]['1to3'][$k]) ? $en_steps_max[$j]['1to3'][$k] : 0}}" name="en_steps_max[{{$j}}][1to3][{{$k}}]" id="en_steps_max_{{$j}}_1to3_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (4 to 5)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_min[$j]['4to5'][$k]) ? $en_steps_min[$j]['4to5'][$k] : 0}}" name="en_steps_min[{{$j}}][4to5][{{$k}}]" id="en_steps_min_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_med[$j]['4to5'][$k]) ? $en_steps_med[$j]['4to5'][$k] : 0}}" name="en_steps_med[{{$j}}][4to5][{{$k}}]" id="en_steps_med_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_max[$j]['4to5'][$k]) ? $en_steps_max[$j]['4to5'][$k] : 0}}" name="en_steps_max[{{$j}}][4to5][{{$k}}]" id="en_steps_max_{{$j}}_4to5_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label>Min Time (8 to 12)</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_min[$j]['8to12'][$k]) ? $en_steps_min[$j]['8to12'][$k] : 0}}" name="en_steps_min[{{$j}}][8to12][{{$k}}]" id="en_steps_min_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Med Time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_med[$j]['8to12'][$k]) ? $en_steps_med[$j]['8to12'][$k] : 0}}" name="en_steps_med[{{$j}}][8to12][{{$k}}]" id="en_steps_med_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                    <div class="form-group col-3">
                                        <label>Max time</label>
                                        <input class="form-control text-right" type="text" value="{{isset($en_steps_max[$j]['8to12'][$k]) ? $en_steps_max[$j]['8to12'][$k] : 0}}" name="en_steps_max[{{$j}}][8to12][{{$k}}]" id="en_steps_max_{{$j}}_8to12_{{$k}}"@if (!isset($flights_min[$j]))readonly @endif />
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row time-factors">
            <!-- Dis-assembly Part -->
            <div class="col-6 small-move">
                <div class="card" id="ranking_item_{{$j}}">

                    <div class="card-header bg-light text-dark header-elements-inline">
                        <h6 class="card-title">Dis-assembly Required? </h6>
                        <div class="header-elements" id="disassembly_content">
                            <div class="list-icons">
                                <div class="form-check form-check-switch form-check-switch-left">
                                    <label class="form-check-label d-flex align-items-center">
                                        @if ($j == 1)
                                        <input name="disassembly" id="disassembly" type="checkbox" data-action="collapse" data-on-color="success" data-off-color="danger" data-on-text="Enable" data-off-text="Disable" class="form-check-input-switch" {{(empty($R) ? null : 'checked')}}>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body @if ($j != 1)disassembly-body @endif" style="{{(empty($R) ? 'display: none' : null)}}">
                        <div class="form-group row">
                            <table class="col-12">
                                @if(isset($ranking) && !empty($ranking))
                                @foreach($ranking as $key => $val)
                                <tr>
                                    <th class="text-left">{{$val->alphabet}} - {{$val->ranking_name}}</th>
                                    <td><input class="form-control" type="number" name="R_{{$val->alphabet}}[{{$j}}]" id="R_{{$val->alphabet}}_{{$j}}" placeholder="" value="{{isset($R[$val->alphabet][$j]) ? $R[$val->alphabet][$j] : 0}}" step="0.01"></td>
                                </tr>
                                @endforeach
                                @endif
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Stair Type Part -->
            <div class="col-6">
                <div class="card" id="stair_time_{{$j}}">

                    <div class="card-header bg-light text-dark header-elements-inline">
                        <h6 class="card-title">Stair Time Required to Move item</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <table class="col-12">
                                <tr>
                                    <td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Stairs Type Windy?</label></td>
                                    <td><input class="form-control " type="number" name="stair_time_windy[{{$j}}]" min="0" value="{{isset($stair_time_windy[$j]) ? $stair_time_windy[$j] : 1}}" id="stair_time_windy_{{$j}}" placeholder="Time" step="0.01"> </td>
                                </tr>
                                <tr>
                                    <td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Stairs Type Narrow?</label></td>
                                    <td><input class="form-control " type="number" name="stair_time_narrow[{{$j}}]" min="0" value="{{isset($stair_time_narrow[$j]) ? $stair_time_narrow[$j] : 1}}" id="stair_time_narrow_{{$j}}" placeholder="Time" step="0.01"> </td>
                                </tr>
                                <tr>
                                    <td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Stairs Type Wide?</label></td>
                                    <td><input class="form-control " type="number" name="stair_time_wide[{{$j}}]" min="0" value="{{isset($stair_time_wide[$j]) ? $stair_time_wide[$j] : 1}}" id="stair_time_wide_{{$j}}" placeholder="Time" step="0.01"></td>
                                </tr>
                                <tr>
                                    <td width="70%" class="p-1"><label for="" class="col-form-label">Time Required for Stairs Type Spiral?</label></td>
                                    <td><input class="form-control " type="number" name="stair_time_spiral[{{$j}}]" min="0" value="{{isset($stair_time_spiral[$j]) ? $stair_time_spiral[$j] : 1}}" id="stair_time_spiral_{{$j}}" placeholder="Time" step="0.01">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    @endfor
</div>
