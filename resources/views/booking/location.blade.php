@extends('user.layout.app')
@section('styles')
<link rel="stylesheet" href="{{asset('asset/css/style-location.css')}}">
<style>
    .nav.nav-tabs .list-group-item {
        color: #333;
        display: flex;
    }

    .nav.nav-tabs .list-group-item.active {
        background-color: var(--dark);
        color: #fff;
    }

    .nav.nav-tabs .list-group-item i {
        padding: 0.4rem .8rem 0.4rem 0rem;
        height: 100%;
    }

    .nav.nav-tabs .list-group-item:first-of-type .fa-map-marker-alt:before {
        content: "\f124";
    }

    .col-md-4 .card i {
        position: absolute;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        background-color: #333;
        text-align: center;
        padding-top: 7px;
        color: #fff;
        top: -20px;
        right: 35%;
        border: 5px solid #fff;
        box-shadow: 0px 4px 6px #eee;
    }

    .shadow {
        box-shadow: 0 .2rem .5rem rgba(0, 0, 0, .15) !important;
    }



    form .row .col-md-6:visible:nth-of-type(even) {
        float: right;
    }

    form .row .col-md-6:visible:nth-of-type(odd) {
        float: left;
        margin-right: 16.666667%;
    }

    form .row .col-md-6:nth-of-type(odd):visible .card:after {
        content: "\f0a4";
        position: absolute;
        right: -36%;
        font-family: 'Font Awesome 5 Free';
        font-weight: 400;
        top: 40%;
        color: #555;
        font-size: 2em;
    }

    form .row .col-md-6 .card.border-success:after {
        color: var(--success);
    }


    .card.border-warning {
        border-color: transparent !important:
    }
</style>
@endsection

@section('content')
<div class="container my-5">
    <h4 class="text-center text-uppercase">LOCATION DETAILS</h4>
    <hr>

    <div class="row">
        <div class="col-md-12">
            <form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    {{ csrf_field() }}
                    @php $step_count = count($booking_location) - 1; @endphp

                    <input type="hidden" id="step_count" value="{{$step_count}}">
                    @php
                    $array = $booking_location->toArray();
                    $out = array_splice($array, 1, 1);
                    $length = count($array);
                    $booking_location = array_replace($array, array($length => $out[0]));
                    @endphp

                    <nav style="width:100%" class="mb-3">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @for ($i = 0; $i <= $step_count; $i++)
                            <a class="nav-item nav-link  boxes col @if($i==0) active @endif" id="loc_step_{{$i}}"
                                data-toggle="tab" data-index="{{$i}}" href="#location_{{$i}}" role="tab" aria-controls="nav-loc_step_{{$i}}"
                                aria-selected="@if($i==0) true @else flase @endif">
                                <div class="mt-4"><img
                                        src="@if($i == 0){{asset('asset/img/location-imgs/pick.png')}} @else{{asset('asset/img/location-imgs/drop.png')}} @endif"
                                        class="center-block" alt=""></div>
                                <div class="nav-tab-set">{{ $booking_location[$i]->location }}</div>
                                <div class="nav-tab-set">{{ $booking_location[$i]->zip_code }}</div>
                            </a>
                            @if($i != $step_count)
                            <div class="col bod" style="padding: 10px">
                                <div class="loader">
                                    <img class="img-fluid loader" src="{{asset('asset/img/location-imgs/wave.png')}}">
                                </div>
                            </div>
                            @endif
                            @endfor
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent" style="width:100%">
                        @for ($i = 0; $i <= $step_count; $i++)
                        <input type="hidden" name="booking_location_pk[{{$i}}]" class="form-control" value="{{ $booking_location[$i]->booking_loc_id or '' }}" required>
                        <div class="tab-pane fade @if($i == 0)show active @endif" id="location_{{$i}}" role="tabpanel"
                            aria-labelledby="nav-loc_step_{{$i}}">
                            <div class="card">

                                <div class="row">
                                    {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                        <nav class="swapper-other lv4 mt-5 mb-5" id="flight_img_{{$i}}" style="display: none;">
                                            <img class="img-fluid change-img" src="{{asset('asset/img/location-imgs/flight_0.png')}}">
                                        </nav>

                                        <nav class="swapper-other lv4 mt-5 mb-5" id="elevator_img_{{$i}}" style="display: none;">
                                            <img class="img-fluid change-img" src="{{asset('asset/img/location-imgs/ele.png')}}">
                                        </nav>
                                    </div>
 --}}
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <p class="card-text ml-4 mr-4 border p-3 mt-3 @if(isset($booking_location[$i]->floor))border-success @endif" id="floor_q_{{$i}}">
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_floor_{{$i}}')"></i>
                                            Unit Number <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="floor_value_{{$i}}">
                                                {{$booking_location[$i]->floor or ''}}
                                            </span>
                                        </p>
                                        <div class="card-body lv1" id="div_floor_{{$i}}" @if(isset($booking_location[$i]->floor))style="display: none" @endif>
                                            <div class="card card-body col-12  mt-1 border-color">
                                                <div class="row roww ">
                                                    <div class="float-left col-2">
                                                        <img src="{{asset('asset/img/location-imgs/1.png')}}" class="img-icc " alt="">
                                                    </div>
                                                    <div class="col-2 float-left mt-4">
                                                        <input id="floor_{{$i}}" name="floor[{{$i}}]" value="{{ $booking_location[$i]->floor or '' }}" type="text" class="form-control txt" placeholder="Number" aria-describedby="basic-addon2"></div>
                                                    <button style="background-color: #FFC81C; height: 40px; margin-top: 20px;" type="button"
                                                        class="btn  closee2" onclick="open_box({{$i}}, 'floor')">OK</button>
                                                </div>
                                            </div>
                                        </div>

                                        <p class="card-text ml-4 mr-4 building_type_q_{{$i}} border p-3 @if(isset($booking_location[$i]->building_type))border-success @endif" @if(empty($booking_location[$i]->building_type))style="display: none"@endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_building_type_{{$i}}')"></i>
                                            Where are we going to move you from? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="building_type_value_{{$i}}">
                                                @if(isset($booking_location[$i]->building_type))
                                                @switch($booking_location[$i]->building_type)
                                                    @case('apartment')
                                                        <img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;
                                                        @break
                                                    @case('house')
                                                        <img src="{{asset('asset/img/location-imgs/2.png')}}" />&nbsp;&nbsp;
                                                        @break
                                                    @case('storage')
                                                        <img src="{{asset('asset/img/location-imgs/3.png')}}" />&nbsp;&nbsp;
                                                        @break
                                                    @case('office')
                                                        <img src="{{asset('asset/img/location-imgs/4.png')}}" />&nbsp;&nbsp;
                                                        @break
                                                @endswitch
                                                {{$booking_location[$i]->building_type}}
                                                @endif
                                            </span>
                                        </p>
                                        <div class="card-body lv2" id="div_building_type_{{$i}}" style="display: none">
                                            <nav>
                                                <div class="nav nav-tabs " id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes col-3 @if($booking_location[$i]->building_type == 'apartment') active @endif building-type" id="nav-bulk-tab"
                                                        data-toggle="tab" role="tab" data-value="apartment" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Apartment/Condo</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-3 @if($booking_location[$i]->building_type == 'house') active @endif building-type" id="nav-ground-tab"
                                                        data-toggle="tab" role="tab" data-value="house" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/2.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Town House</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-3 @if($booking_location[$i]->building_type == 'storage') active @endif building-type" id="nav-home-tab"
                                                        data-toggle="tab" role="tab" data-value="storage" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/3.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Storage</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-3 @if($booking_location[$i]->building_type == 'office') active @endif building-type" id="nav-home-tab"
                                                        data-toggle="tab" role="tab" data-value="office" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/4.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Office</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="building_type_{{$i}}" name="building_type[{{$i}}]" value="{{$booking_location[$i]->building_type or ''}}">
                                        </div>
                                        <p class="card-text ml-4 mr-4 stair_kind_q_{{$i}} border p-3 @if(isset($booking_location[$i]->stair_kind))border-success @endif" @if(empty($booking_location[$i]->stair_kind)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_stair_kind_{{$i}}')"></i>
                                            How will the movers be moving the furniture? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="stair_kind_value_{{$i}}">
                                                @isset($booking_location[$i]->stair_kind)
                                                    @switch($booking_location[$i]->stair_kind)
                                                        @case('bulkhead')
                                                            <img src="{{asset('asset/img/location-imgs/bulk.png')}}" />&nbsp;&nbsp;Bulkhead
                                                            @break
                                                        @case('groundfloor')
                                                            <img src="{{asset('asset/img/location-imgs/ground.png')}}" />&nbsp;&nbsp;Ground Floor
                                                            @break
                                                        @case('entrance')
                                                            <img src="{{asset('asset/img/location-imgs/entrance.png')}}" />&nbsp;&nbsp;Entrance Steps
                                                            @break
                                                        @case('stairs')
                                                            <img src="{{asset('asset/img/location-imgs/flight.png')}}" />&nbsp;&nbsp;Flights
                                                            @break
                                                        @case('elevator')
                                                            <img src="{{asset('asset/img/location-imgs/elevator.png')}}" />&nbsp;&nbsp;Elevator
                                                            @break
                                                        @case('both')
                                                            <img src="{{asset('asset/img/location-imgs/ground.png')}}" />&nbsp;&nbsp;Stairs & Elevator
                                                            @break
                                                    @endswitch
                                                @endisset
                                            </span>
                                        </p>
                                        <div class="card-body lv3" id="div_stair_kind_{{$i}}" style="display:none;">
                                            <nav>
                                                <div class="nav nav-tabs " id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'bulkhead') active @endif moving-type" id="nav-bulk-tab"
                                                        data-toggle="tab" href="#div_step_num_{{$i}}" role="tab" aria-controls="nav-bulk" data-value="bulkhead" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/bulk.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Bulkhead</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'groundfloor') active @endif moving-type" id="nav-ground-tab"
                                                        data-toggle="tab" href="#div_step_num_{{$i}}" role="tab" aria-controls="nav-home" data-value="groundfloor" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/ground.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Ground Floor</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'entrance') active @endif moving-type" id="nav-home-tab"
                                                        data-toggle="tab" href="#div_step_num_{{$i}}" role="tab" aria-controls="nav-home" data-value="entrance" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/entrance.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Entrance Steps</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'stairs') active @endif moving-type" id="nav-home-tab"
                                                        data-toggle="tab" href="#flight" role="tab" aria-controls="nav-home" data-value="stairs" data-index="{{$i}}"
                                                        aria-selected="true">
                                                      
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Flights</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'elevator') active @endif moving-type" id="nav-home-tab"
                                                        data-toggle="tab" href="#elevator" role="tab" aria-controls="nav-home" data-value="elevator" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/elevator.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Elevator</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 @if($booking_location[$i]->stair_kind == 'both') active @endif moving-type" id="nav-home-tab"
                                                        data-toggle="tab" href="#s-and-e" role="tab" aria-controls="nav-home" data-value="both" data-index="{{$i}}"
                                                        aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Stairs and Elevator</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="stair_kind_{{$i}}" name="stair_kind[{{$i}}]" value="{{$booking_location[$i]->stair_kind or ''}}">
                                        </div>

                                        <p class="card-text ml-4 mr-4 lv4 border p-3 @if(isset($booking_location[$i]->step_num))border-success @endif" id="step_num_q_{{$i}}" @if(empty($booking_location[$i]->step_num)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_step_num_{{$i}}')"></i>
                                            How many steps are there? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center text-capitalize ml-4" id="step_num_value_{{$i}}">
                                                {{$booking_location[$i]->step_num or ''}}
                                            </span>
                                        </p>
                                        <div class="card-body lv4" id="div_step_num_{{$i}}" style="display:none;">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes-bulk col-3 step_num_clickable groundfloor_option @if($booking_location[$i]->step_num == 'no_steps')active @endif"
                                                        id="groundfloor_option_{{$i}}" href="#steps0" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="no_steps" aria-controls="nav-home" aria-selected="true">
                                                        <div class="nav-tab-set">No Steps</div>
                                                    </a></a>
                                                    <a class="nav-item nav-link  boxes-bulk col-3 step_num_clickable @if($booking_location[$i]->step_num == '1to3')active @endif" id="nav-home-tab"
                                                        href="#steps1" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="1to3"
                                                        aria-controls="nav-home" aria-selected="true">
                                                        <div class="nav-tab-set">1 to 3</div>
                                                    </a></a>
                                                    <a class="nav-item nav-link boxes-bulk col-3 step_num_clickable @if($booking_location[$i]->step_num == '4to5')active @endif" id="nav-profile-tab"
                                                        href="#steps2" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="4to5"
                                                        aria-controls="nav-profile" aria-selected="false">
                                                        <div class="nav-tab-set">4 to 5</div>
                                                    </a></a>
                                                    <a class="nav-item nav-link boxes-bulk col-3 step_num_clickable" id="nav-contact-tab @if($booking_location[$i]->step_num == '8to12')active @endif"
                                                        href="#steps3" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="8to12"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                        <div class="nav-tab-set">8 to 12</div>
                                                    </a></a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="step_num_{{$i}}" name="step_num[{{$i}}]" value="{{$booking_location[$i]->step_num}}">
                                        </div>

                                        <p class="card-text ml-4 mr-4 lv4 border p-3 @if(isset($booking_location[$i]->stair_type))border-success @endif" id="stair_type_q_{{$i}}" @if(empty($booking_location[$i]->stair_type)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_stair_type_{{$i}}')"></i>
                                            How will the movers be moving the furniture? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="stair_type_value_{{$i}}">
                                                @isset($booking_location[$i]->stair_type)
                                                    @switch($booking_location[$i]->stair_type)
                                                        @case('wide')
                                                            <img src="{{asset('asset/img/location-imgs/wide.png')}}" />&nbsp;&nbsp;Wide
                                                            @break
                                                        @case('spiral')
                                                            <img src="{{asset('asset/img/location-imgs/spiral.png')}}" />&nbsp;&nbsp;Spiral
                                                            @break
                                                        @case('windy')
                                                            <img src="{{asset('asset/img/location-imgs/windy.png')}}" />&nbsp;&nbsp;Windy
                                                            @break
                                                        @case('narrow')
                                                            <img src="{{asset('asset/img/location-imgs/narrow.png')}}" />&nbsp;&nbsp;Narrow
                                                            @break
                                                    @endswitch
                                                @endisset
                                            </span>
                                        </p>
                                        <div class="card-body lv4" id="div_stair_type_{{$i}}" style="display:none;">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes col-2 stair_type_clickable @if($booking_location[$i]->stair_type == 'wide')active @endif" id="nav-home-tab"
                                                        data-toggle="tab" href="#wide" role="tab" data-index="{{$i}}" data-value="wide"
                                                        aria-controls="nav-home" aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/wide.png')}}" class="center-block" alt="">
                                                        </div>
                                                        <div class="nav-tab-set">Wide</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes col-2 stair_type_clickable @if($booking_location[$i]->stair_type == 'spiral')active @endif" id="nav-profile-tab"
                                                        data-toggle="tab" href="#spiral" role="tab" data-index="{{$i}}" data-value="spiral"
                                                        aria-controls="nav-profile" aria-selected="false">
                                                        <div><img src="{{asset('asset/img/location-imgs/spiral.png')}}" class="center-block" alt="">
                                                        </div>
                                                        <div class="nav-tab-set">Spiral</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 stair_type_clickable @if($booking_location[$i]->stair_type == 'windy')active @endif" id="nav-contact-tab "
                                                        data-toggle="tab" href="#windy" role="tab" data-index="{{$i}}" data-value="windy"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                        <div><img src="{{asset('asset/img/location-imgs/windy.png')}}" class="center-block" alt="">
                                                        </div>
                                                        <div class="nav-tab-set">Windy</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 stair_type_clickable @if($booking_location[$i]->stair_type == 'narrow')active @endif" id="nav-contact-tab"
                                                        data-toggle="tab" href="#narrow" role="tab" data-index="{{$i}}" data-value="narrow"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                        <div><img src="{{asset('asset/img/location-imgs/narrow.png')}}" class="center-block" alt="">
                                                        </div>
                                                        <div class="nav-tab-set">Narrow</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="stair_type_{{$i}}" name="stair_type[{{$i}}]" value="{{$booking_location[$i]->stair_type}}">
                                        </div>

                                        <p class="card-text ml-4 mr-4 border p-3 @isset($booking_location[$i]->flights)border-success @endisset" id="flights_q_{{$i}}" @if(empty($booking_location[$i]->flights)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_flights_{{$i}}')"></i>
                                            How many stairs are there? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="flights_value_{{$i}}">
                                                {{$booking_location[$i]->flights or ''}}
                                            </span>
                                        </p>
                                        <div class="card-body lv4-2" id="div_flights_{{$i}}" style="display:none;">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes-bulk flights_clickable @if($booking_location[$i]->flights == 1)active @endif"
                                                        id="nav-home-tab" data-toggle="tab" href="#wide-1" data-index="{{$i}}" data-value="1"
                                                        role="tab" aria-controls="nav-home"
                                                        aria-selected="true" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">1X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 2)active @endif"
                                                        id="nav-profile-tab" data-toggle="tab" data-index="{{$i}}" data-value="2"
                                                        href="#wide-2" role="tab"
                                                        aria-controls="nav-profile" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">2X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 3)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" data-index="{{$i}}" data-value="3"
                                                        href="#wide-3" role="tab"
                                                        aria-controls="nav-contact" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">3X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 4)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" data-index="{{$i}}" data-value="4"
                                                        href="#wide-4" role="tab"
                                                        aria-controls="nav-contact" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">4X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 5)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" data-index="{{$i}}" data-value="5"
                                                        href="#wide-5" role="tab"
                                                        aria-controls="nav-contact" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">5X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 6)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" data-index="{{$i}}" data-value="6"
                                                        href="#wide-6" role="tab"
                                                        aria-controls="nav-contact" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">6X</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk flights_clickable @if($booking_location[$i]->flights == 7)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" data-index="{{$i}}" data-value="7"
                                                        href="#wide-7" role="tab"
                                                        aria-controls="nav-contact" aria-selected="false" style="flex: 1">
                                                         <div><img src="{{asset('asset/img/location-imgs/flight.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">7X+</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="flights_{{$i}}" name="flights[{{$i}}]" value="{{$booking_location[$i]->flights}}">
                                        </div>
        
                                        <p class="card-text ml-4 mr-4 border p-3 @isset($booking_location[$i]->evelator_type)border-success @endisset" id="evelator_type_q_{{$i}}" @if(empty($booking_location[$i]->evelator_type)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_evelator_type_{{$i}}')"></i>
                                            What kind of evelator are they? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="evelator_type_value_{{$i}}">
                                                @isset($booking_location[$i]->evelator_type)
                                                    @switch($booking_location[$i]->evelator_type)
                                                        @case('passenger')
                                                            <img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Passenger
                                                            @break
                                                        @case('freight')
                                                            <img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Freight
                                                            @break
                                                        @case('reserved_freight')
                                                            <img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Reserved Freight
                                                            @break
                                                    @endswitch
                                                @endisset
                                            </span>
                                        </p>
                                        <div class="card-body lv4" id="div_evelator_type_{{$i}}" style="display:none;">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link  boxes col-2 evelator_type_clickable @if($booking_location[$i]->evelator_type == 'passenger')active @endif" id="nav-home-tab"
                                                        data-toggle="tab" href="#passenger" role="tab" data-index="{{$i}}" data-value="passenger"
                                                        aria-controls="nav-home" aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Passenger</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 evelator_type_clickable @if($booking_location[$i]->evelator_type == 'freight')active @endif" id="nav-home-tab"
                                                        data-toggle="tab" href="#freight" role="tab" data-index="{{$i}}" data-value="freight"
                                                        aria-controls="nav-home" aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Freight</div>
                                                    </a>
                                                    <a class="nav-item nav-link  boxes col-2 evelator_type_clickable @if($booking_location[$i]->evelator_type == 'reserved_freight')active @endif" id="nav-home-tab"
                                                        data-toggle="tab" href="#reserved" role="tab" data-index="{{$i}}" data-value="reserved_freight"
                                                        aria-controls="nav-home" aria-selected="true">
                                                        <div><img src="{{asset('asset/img/location-imgs/1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Reserved Freight</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="evelator_type_{{$i}}" name="evelator_type[{{$i}}]" value="{{$booking_location[$i]->evelator_type}}">
                                        </div>
        
                                        <p class="card-text ml-4 mr-4 border p-3 @isset($booking_location[$i]->floor_num)border-success @endisset" id="floor_num_q_{{$i}}" @if(empty($booking_location[$i]->floor_num)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_floor_num_{{$i}}')"></i>
                                            Which floor are you on? <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="floor_num_value_{{$i}}">
                                                {{$booking_location[$i]->floor_num or ''}}
                                            </span>
                                        </p>
                                        <div class="card-body lv4-1" id="div_floor_num_{{$i}}" style="display:none;">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 1)active @endif"
                                                        id="nav-home-tab" data-toggle="tab" href="#floor-1" data-index="{{$i}}" data-value="1"
                                                        role="tab" aria-controls="nav-home"
                                                        aria-selected="true" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f1.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">1</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 2)active @endif"
                                                        id="nav-profile-tab" data-toggle="tab" href="#floor-2" data-index="{{$i}}" data-value="2"
                                                        role="tab" aria-controls="nav-profile"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f2.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">2</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 3)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" href="#floor-3" data-index="{{$i}}" data-value="3"
                                                        role="tab" aria-controls="nav-contact"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f3.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">3</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 4)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" href="#floor-4" data-index="{{$i}}" data-value="4"
                                                        role="tab" aria-controls="nav-contact"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f4.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">4</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 5)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" href="#floor-5" data-index="{{$i}}" data-value="5"
                                                        role="tab" aria-controls="nav-contact"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f5.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">5</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 6)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" href="#floor-6" data-index="{{$i}}" data-value="6"
                                                        role="tab" aria-controls="nav-contact"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f6.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">6</div>
                                                    </a>
                                                    <a class="nav-item nav-link boxes-bulk floor_num_clickable @if($booking_location[$i]->floor_num == 7)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" href="#floor-7" data-index="{{$i}}" data-value="7"
                                                        role="tab" aria-controls="nav-contact"
                                                        aria-selected="false" style="flex: 1">
                                                        <div><img src="{{asset('asset/img/location-imgs/f7.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">7+</div>
                                                    </a>
                                                </div>
                                            </nav>
                                            <input type="hidden" id="floor_num_{{$i}}" name="floor_num[{{$i}}]" value="{{$booking_location[$i]->floor_num}}">
                                        </div>
        
                                        <p class="card-text ml-4 mr-4 border p-3 @isset($booking_location[$i]->parking)border-success @endisset" id="parking_q_{{$i}}" @if(empty($booking_location[$i]->parking)) style="display:none;" @endif>
                                            <i style="float:right; " class="far fa-edit mt-1" aria-hidden="true" onclick="show_div('div_parking_{{$i}}')"></i>
                                            Parking and building info <i class="fa fa-arrow-right icn"></i>
                                            <span class="font-weight-bold text-success text-center ml-4" id="parking_value_{{$i}}">
                                                @isset($booking_location[$i]->parking)
                                                    @switch($booking_location[$i]->parking)
                                                        @case(1)
                                                            Loading dock will be reserved
                                                            @break
                                                        @case(2)
                                                            Parking permit will be pulled
                                                            @break
                                                        @case(3)
                                                            Metered parking available
                                                            @break
                                                        @case(4)
                                                            Commercial parking available
                                                            @break
                                                        @case(5)
                                                            Easy street parking available
                                                            @break
                                                        @case(6)
                                                            Home drive way available
                                                            @break
                                                    @endswitch
                                                @endisset
                                            </span>
                                        </p>
                                        <div class="card-body lv5" id="div_parking_{{$i}}" style="display:none;">
                                            <nav class=" mt-3">
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="boxes-bulk1 nav-item nav-link col-2 parking_clickable @if($booking_location[$i]->parking == 1)active @endif"
                                                        id="nav-home-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="1"
                                                        aria-controls="nav-home" aria-selected="true">
                                                         <div><img src="{{asset('asset/img/location-imgs/dock.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Loading dock will be reserved
                                                        </div>
                                                    </a>
                                                    <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable @if($booking_location[$i]->parking == 2)active @endif"
                                                        id="nav-profile-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="2"
                                                        aria-controls="nav-profile" aria-selected="false">
                                                         <div><img src="{{asset('asset/img/location-imgs/permit.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Parking permit will be pulled
                                                        </div>
                                                    </a>
                                                    <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable @if($booking_location[$i]->parking == 3)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="3"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                         <div><img src="{{asset('asset/img/location-imgs/comm.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Metered parking available</div>
                                                    </a>
                                                    <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable @if($booking_location[$i]->parking == 4)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="4"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                         <div><img src="{{asset('asset/img/location-imgs/pa.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Commercial parking available
                                                        </div>
                                                    </a>
                                                    <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable @if($booking_location[$i]->parking == 5)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="5"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                         <div><img src="{{asset('asset/img/location-imgs/street.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Easy street parking available
                                                        </div>
                                                    </a>
                                                    <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable @if($booking_location[$i]->parking == 6)active @endif"
                                                        id="nav-contact-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="6"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                         <div><img src="{{asset('asset/img/location-imgs/home.png')}}" class="center-block" alt=""></div>
                                                        <div class="nav-tab-set">Home driveway available</div>
                                                    </a>
                                                    {{-- <a class="boxes-bulk1 nav-item nav-link   col-2 parking_clickable"
                                                        id="nav-contact-tab" data-toggle="tab" role="tab" data-index="{{$i}}" data-value="7"
                                                        aria-controls="nav-contact" aria-selected="false">
                                                        <div class="nav-tab-set">Other</div>
                                                    </a> --}} </div>
                                            </nav>
                                            <input type="hidden" id="parking_{{$i}}" name="parking[{{$i}}]" value="{{$booking_location[$i]->parking}}">
                                        </div>
        
                                        <div id="div_walk_{{$i}}" class="lv6 m-3" @if(empty($booking_location[$i]->walk)) style="display:none;" @endif>
                                            <div class="card card-body shadow animated fadeIn delay-0-8s mt-2">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <p><strong>Are there any long walks at any of the locations specified above?</strong><br>
                                                        Take a stop watch and walk from your items to where our vehicle would be parked. If it takes over 30 seconds, this is considered a long walk. This can greatly affect the estimated time so please do not skip this question.</p>
                                                    </div>
                                                    <div class="col-md-3 animated fadeIn delay-0-9s py-3 border-left">
                                                        <div class="bg-warning border rounded px-3 my-3 py-2 shadow-sm mx-auto w-100">
                                                            <div class="custom-control custom-radio  custom-control-inline">
                                                                <input type="radio" id="yes{{$i}}" name="walk[{{$i}}]" class="custom-control-input" value="1" @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 1) checked @endif class="form-control" required>
                                                                <label class="custom-control-label" for="yes{{$i}}" onclick="open_box('{{$i}}','walk')">Yes</label>
                                                            </div>
                                                        </div>
                                                        <div class="bg-warning text-dark rounded px-3 my-3 py-2 shadow-sm mx-auto w-100">
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input type="radio" id="no{{$i}}" name="walk[{{$i}}]" class="custom-control-input" value="2"  @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 2) checked @endif @if(!isset($booking_location[$i]->walk)) checked @endif class="form-control" required>
                                                                <label class="custom-control-label" for="no{{$i}}" onclick="open_box('{{$i}}','walk')" >No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div id="div_walk_time_{{$i}}" class="lv7 m-3" @if(isset($booking_location[$i]->walk) && $booking_location[$i]->walk == 1) @else style="display:none;" @endif >
                                            <div class="card card-body shadow animated fadeIn delay-0.5s mt-3">
                                                <p><strong>Is the walk from your door to where the truck will be parked longer than 30 seconds ?</strong></p>
                                                <div class="form-row">
                                                    <div class="form-group animated fadeIn col-md-3">
                                                        <label for="">Minutes:</label>
                                                        <select id="walk_min_{{$i}}" name="walk_min[{{$i}}]" class="form-control">
                                                        @for($j=1;$j<=10;$j++)
                                                            <option value="{{$j}}" @if(isset($booking_location[$i]->walk_min) && $booking_location[$i]->walk_min == $j) selected @endif>{{$j}}</option>
                                                        @endfor
                                                        </select>
                                                    </div>
                                                    <div class="form-group animated fadeIn col-md-3">
                                                        <label for="">Seconds:</label>
                                                        <select id="walk_sec_{{$i}}" name="walk_sec[{{$i}}]" class="form-control">
                                                        @for($k=1;$k<=60;$k++)
                                                            <option value="{{$k}}" @if(isset($booking_location[$i]->walk_min) && $booking_location[$i]->walk_sec == $k) selected @endif>{{$k}}</option>
                                                        @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div id="div_comments_{{$i}}" class="lv7 m-3" @if(empty($booking_location[$i]->comments)) style="display:none;" @endif>
                                            <div class="form-group animated fadeIn delay-1s">
                                                <label class="col-form-label">Please give exact details about the location</label>
                                                <textarea name="comments[{{$i}}]" class="form-control animated fadeIn col-form-label">{{ $booking_location[$i]->comments or '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endfor
                        @for ($i = 0; $i <= $step_count; $i++)
                        @if ($i == $step_count)
                        <div class="m-3 submit" style="display: none">
                            <hr>
                            <button id="btn_submit" name="btn_submit" type="submit" value="4" class="btn btn-warning m-auto hvr-icon-wobble-horizontal animated slideInRight">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
                        </div>
                        @else
                        <div class="m-3" id="btn_{{$i}}" style="@if($i != 0)display: none @endif">
                            <hr>
                            <button type="button" class="btn btn-warning m-auto hvr-icon-wobble-horizontal animated slideInRight" onclick="loc_step({{$i}})">Next <i class="fas fa-chevron-right hvr-icon"></i></button>
                        </div>
                        @endif
                        @endfor
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
<script>
    var steps = parseInt('{{$step_count}}');
    function loc_step(index) {
        var i = parseInt(index);
        $('#location_' + i).removeClass('show active');
        $('#location_' + (i + 1)).addClass('show active');

        $('#loc_step_' + i).removeClass('active');
        $('#loc_step_' + (i + 1)).addClass('active');
        $('#btn_' + i).hide();
        if (i == steps - 1) {
            $('.submit').fadeIn();
        }
    }

    function initZipcodes(lat, lng, j) {
        let geocoder = new google.maps.Geocoder();
        let latLng;
        latLng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({
            'latLng': latLng
        }, async function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    for (let i = 0; i < results[0].address_components.length; i++) {
                        let types = results[0].address_components[i].types;

                        for (let typeIdx = 0; typeIdx < types.length; typeIdx++) {
                            if (types[typeIdx] == 'postal_code') {
                                // console.log(results[0].address_components[i].long_name);
                                document.querySelector('#div_zip_code_' + j + ' input').value = results[0].address_components[i].short_name;
                            }
                        }
                    }
                } else {
                    console.log("No results found");
                }
            }
        })
    }

    function zipcode(lat, lng, i) {
        open_box(i, 'floor');
    }

    function show_div(id) {
        $('#'+id).fadeIn();
    }

    function open_box(box,step)
    {
    
        if(step == 'floor')
        {
            $("#div_zip_code_"+box).fadeIn();
            $("#div_building_type_"+box).fadeIn();
            $('.building_type_q_'+box).fadeIn();
            $('.building_type_q_'+box).removeClass('border-success shadow');
            $('#building_type_value_'+box).empty();

            $('#div_floor_'+box).hide();
            $('#floor_q_'+box).addClass('border-success shadow');
            $('#floor_value_'+box).html($('#floor_'+box).val());

            $('#div_stair_type_'+box).hide();
            $('#stair_type_q_'+box).hide();

            $('#div_step_num_'+box).hide();
            $('#step_num_q_'+box).hide();

            $('#div_evelator_type_'+box).hide();
            $('#evelator_type_q_'+box).hide();

            $('#div_flights_'+box).hide();
            $('#flights_q_'+box).hide();

            $('#div_floor_num_'+box).hide();
            $('#floor_num_q_'+box).hide();

            $('#div_parking_'+box).hide();
            $('#parking_q_'+box).hide();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step == 'building_type') {
            $("#div_stair_kind_"+box).fadeIn();
            $(".stair_kind_q_"+box).fadeIn();
            $(".stair_kind_q_"+box).removeClass('border-success shadow');
            $('#stair_kind_value_'+box).empty();

            $("#div_building_type_"+box).hide();
            $('.building_type_q_'+box).addClass('border-success shadow');
            let val = $('#building_type_'+box).val();
            let res;
            switch (val) {
                case 'apartment':
                    res = `<img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Apartment/Condo`;
                    break;
                case 'house':
                    res = `<img src="{{asset('asset/img/location-imgs/2.png')}}" />&nbsp;&nbsp;House`;
                    break;
                case 'storage':
                    res = `<img src="{{asset('asset/img/location-imgs/3.png')}}" />&nbsp;&nbsp;Storage`;
                    break;
                case 'office':
                    res = `<img src="{{asset('asset/img/location-imgs/4.png')}}" />&nbsp;&nbsp;Office`;
                    break;
            }
            $('#building_type_value_'+box).html(res);

            $('#div_stair_type_'+box).hide();
            $('#stair_type_q_'+box).hide();

            $('#div_step_num_'+box).hide();
            $('#step_num_q_'+box).hide();

            $('#div_evelator_type_'+box).hide();
            $('#evelator_type_q_'+box).hide();

            $('#div_flights_'+box).hide();
            $('#flights_q_'+box).hide();

            $('#div_floor_num_'+box).hide();
            $('#floor_num_q_'+box).hide();

            $('#div_parking_'+box).hide();
            $('#parking_q_'+box).hide();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step == 'stair_kind') {
            $("#div_stair_kind_"+box).hide();
            $(".stair_kind_q_"+box).addClass('border-success shadow');
            let val = $('#stair_kind_'+box).val();
            let ele = null;
            switch(val) {
                case 'bulkhead':
                    ele = `<img src="{{asset('asset/img/location-imgs/bulk.png')}}" />&nbsp;&nbsp;Bulkhead`;
                    break;
                case 'groundfloor':
                    ele = `<img src="{{asset('asset/img/location-imgs/ground.png')}}" />&nbsp;&nbsp;Ground Floor`;
                    break;
                case 'entrance':
                    ele = `<img src="{{asset('asset/img/location-imgs/entrance.png')}}" />&nbsp;&nbsp;Entrance Steps`;
                    break;
                case 'stairs':
                    ele = `<img src="{{asset('asset/img/location-imgs/flight.png')}}" />&nbsp;&nbsp;Flights`;
                    break;
                case 'elevator':
                    ele = `<img src="{{asset('asset/img/location-imgs/elevator.png')}}" />&nbsp;&nbsp;Elevator`;
                    break;
                case 'both':
                    ele = `<img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Stairs & Elevator`;
                    break;
            }
            $('#stair_kind_value_'+box).html(ele);

            // $('#flight_img_'+box).hide();
            // $('#elevator_img_'+box).hide();

            var res = $('#stair_kind_'+box).val();

            if (res=='bulkhead' || res=='groundfloor' || res=='entrance') {
                $('#div_stair_type_'+box).hide();
                $('#stair_type_q_'+box).hide();

                $('#div_step_num_'+box).fadeIn();
                $('#step_num_q_'+box).fadeIn();
                $('#step_num_q_'+box).removeClass('border-success shadow')
                $('#step_num_value_'+box).empty();

                $('#div_evelator_type_'+box).hide();
                $('#evelator_type_q_'+box).hide();

                $('#div_flights_'+box).hide();
                $('#flights_q_'+box).hide();

                $('#div_floor_num_'+box).hide();
                $('#floor_num_q_'+box).hide();

                $('#div_parking_'+box).hide();
                $('#parking_q_'+box).hide();

                $('#div_walk_'+box).hide();
                $('#div_walk_time_'+box).hide();
                $('#div_comments_'+box).hide();
            } else if (res=='elevator') {
                $('#div_stair_type_'+box).hide();
                $('#stair_type_q_'+box).hide();

                $('#div_step_num_'+box).hide();
                $('#step_num_q_'+box).hide();

                $('#div_evelator_type_'+box).fadeIn();
                $('#evelator_type_q_'+box).fadeIn();
                $('#evelator_type_q_'+box).removeClass('border-success shadow');
                $('#evelator_type_value_'+box).empty();

                $('#div_flights_'+box).hide();
                $('#flights_q_'+box).hide();

                $('#div_floor_num_'+box).hide();
                $('#floor_num_q_'+box).hide();

                $('#div_parking_'+box).hide();
                $('#parking_q_'+box).hide();

                $('#div_walk_'+box).hide();
                $('#div_walk_time_'+box).hide();
                $('#div_comments_'+box).hide();
            } else if (res=='stairs') {
                $('#div_stair_type_'+box).fadeIn();
                $('#stair_type_q_'+box).fadeIn();
                $('#stair_type_q_'+box).removeClass('border-success shadow');
                $('#stair_type_value_'+box).empty();

                $('#div_step_num_'+box).hide();
                $('#step_num_q_'+box).hide();

                $('#div_evelator_type_'+box).hide();
                $('#evelator_type_q_'+box).hide();

                $('#div_flights_'+box).hide();
                $('#flights_q_'+box).hide();

                $('#div_floor_num_'+box).hide();
                $('#floor_num_q_'+box).hide();

                $('#div_parking_'+box).hide();
                $('#parking_q_'+box).hide();

                $('#div_walk_'+box).hide();
                $('#div_walk_time_'+box).hide();
                $('#div_comments_'+box).hide();
            } else if (res=='both') {
                $('#div_stair_type_'+box).fadeIn();
                $('#stair_type_q_'+box).fadeIn();
                $('#stair_type_q_'+box).removeClass('border-success shadow');
                $('#stair_type_value_'+box).empty()

                $('#div_step_num_'+box).hide();
                $('#step_num_q_'+box).hide();

                $('#div_evelator_type_'+box).fadeIn();
                $('#evelator_type_q_'+box).fadeIn();
                $('#evelator_type_q_'+box).removeClass('border-success shadow');
                $('#evelator_type_value_'+box).empty();

                $('#div_flights_'+box).hide();
                $('#flights_q_'+box).hide();

                $('#div_floor_num_'+box).hide();
                $('#floor_num_q_'+box).hide();

                $('#div_parking_'+box).hide();
                $('#parking_q_'+box).hide();

                $('#div_walk_'+box).hide();
                $('#div_walk_time_'+box).hide();
                $('#div_comments_'+box).hide();
            }
        }

        if (step=="stair_type") {
            $('#div_stair_type_'+box).hide();
            $('#stair_type_q_'+box).addClass('border-success shadow');
            let val = $('#stair_type_'+box).val();
            let res;
            switch (val) {
                case 'wide':
                    res = `<img src="{{asset('asset/img/location-imgs/wide.png')}}" />&nbsp;&nbsp;Wide`
                    break
                case 'spiral':
                    res = `<img src="{{asset('asset/img/location-imgs/spiral.png')}}" />&nbsp;&nbsp;Spiral`
                    break
                case 'windy':
                    res = `<img src="{{asset('asset/img/location-imgs/windy.png')}}" />&nbsp;&nbsp;Windy`
                    break
                case 'narrow':
                    res = `<img src="{{asset('asset/img/location-imgs/narrow.png')}}" />&nbsp;&nbsp;Narrow`
                    break
            }
            $('#stair_type_value_'+box).html(res)

            $('#div_flights_'+box).fadeIn();
            $('#flights_q_'+box).fadeIn();
            $('#flights_q_'+box).removeClass('border-success shadow');
            $('#flights_value_'+box).empty()

            // $('#div_floor_num_'+box).hide();
            // $('#floor_num_q_'+box).hide();

            $('#div_parking_'+box).hide();
            $('#parking_q_'+box).hide();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step=="flights") {
            $('#div_flights_'+box).hide();
            $('#flights_q_'+box).addClass('border-success shadow');
            if ($('#flights_'+box).val() < 7)
                $('#flights_value_'+box).html($('#flights_'+box).val());
            else if ($('#flights_'+box).val() == 7)
            $('#flights_value_'+box).html('7+');

            $('#div_parking_'+box).fadeIn();
            $('#parking_q_'+box).fadeIn();
            $('#parking_q_'+box).removeClass('border-success shadow');
            $('#parking_value_'+box).empty();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step=="evelator_type") {
            $('#div_evelator_type_'+box).hide();
            $('#evelator_type_q_'+box).addClass('border-success shadow');
            let val = $('#evelator_type_'+box).val();
            let res;
            switch(val) {
                case 'passenger':
                    res = `<img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Passenger`
                    break
                case 'freight':
                    res = `<img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Freight`
                    break
                case 'reserved_freight':
                    res = `<img src="{{asset('asset/img/location-imgs/1.png')}}" />&nbsp;&nbsp;Reserved Freight`
                    break
            }
            $('#evelator_type_value_'+box).html(res);

            // $('#div_flights_'+box).hide();
            // $('#flights_q_'+box).hide();

            $('#div_floor_num_'+box).fadeIn();
            $('#floor_num_q_'+box).fadeIn();
            $('#floor_num_q_'+box).removeClass('border-success shadow');
            $('#floor_num_value_'+box).empty();

            $('#div_parking_'+box).hide();
            $('#parking_q_'+box).hide();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step=='floor_num') {
            $('#div_floor_num_'+box).hide();
            $('#floor_num_q_'+box).addClass('border-success shadow');
            if ($('#floor_num_'+box).val() < 7)
                $('#floor_num_value_'+box).html($('#floor_num_'+box).val())
            else if ($('#floor_num_'+box).val() == 7)
                $('#floor_num_value_'+box).html('7+')

            $('#div_parking_'+box).fadeIn();
            $('#parking_q_'+box).fadeIn();
            $('#parking_q_'+box).removeClass('border-success shadow');
            $('#parking_value_'+box).empty()

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step=='step_num') {
            $('#div_step_num_'+box).hide();
            $('#step_num_q_'+box).addClass('border-success shadow');
            $('#step_num_value_'+box).html($('#step_num_'+box).val());

            $('#div_parking_'+box).fadeIn();
            $('#parking_q_'+box).fadeIn();
            $('#parking_q_'+box).removeClass('border-success shadow');
            $('#parking_value_'+box).empty();

            $('#div_walk_'+box).hide();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if (step=="parking") {
            $('#div_parking_'+box).hide();
            $('#parking_q_'+box).addClass('border-success shadow');
            let val = $('#parking_'+box).val()
            switch (val) {
                case '1':
                    $('#parking_value_'+box).html('Loading dock will be reserved')
                    break
                case '2':
                    $('#parking_value_'+box).html('Parking permit will be pulled')
                    break
                case '3':
                    $('#parking_value_'+box).html('Metered parking available')
                    break
                case '4':
                    $('#parking_value_'+box).html('Commercial parking available')
                    break
                case '5':
                    $('#parking_value_'+box).html('Easy street parking available')
                    break
                case '6':
                    $('#parking_value_'+box).html('Home drive way available')
                    break
            }

            $('#div_walk_'+box).show();
            $('#div_walk_time_'+box).hide();
            $('#div_comments_'+box).hide();
        }

        if(step == 'walk') {
            console.log($('#yes'+box).is(':checked'));
            if($('#yes'+box).is(':checked'))
            {
                $("#div_walk_time_"+box).hide();
                $("#div_walk_time_"+box).prop("required", false);
            }
            else
            {
                $("#div_walk_time_"+box).fadeIn();
                $("#div_walk_time_"+box).prop("required", true);
            }
            $("#div_comments_"+box).fadeIn();
        }
    }

    function next_step(box)
    {
        var step = $("#next_"+box).val();
        
        $("#back_"+box).val(step);
        
        //$("div[id*='div_"+box+"']").hide();
        
        var step = parseInt(step) + 1;
        
        $("#next_"+box).val(step);
        
        $("#div_"+box+'_'+step).fadeIn("slow");
        $("#div_"+box+'_'+step).fadeIn(1000);
        
    }
    
    function back_step(box)
    {
        var step = $("#back_"+box).val();
        
        $("#next_"+box).val(step);
        
        //$("div[id*='div_"+box+"']").hide();
        
        $("#div_"+box+'_'+step).fadeIn("slow");
        $("#div_"+box+'_'+step).fadeIn(1000);    
        
        var step = parseInt(step) - 1;
        
        if(step > 0 && step < 9)
        {
            $("#back_"+box).val(step);    
        }
        
    }

    jQuery(document).ready(function() {
        $('.groundfloor_option').hide();
        $('a[id^="loc_step_"]').on('click', function() {
            var step_count = $('#step_count').val();
            if ($(this).attr('id') == 'loc_step_' + step_count) {
                $('div[id^="btn_"]').hide();
                $('div.submit').fadeIn();
            } else {
                $('div[id^="btn_"]').hide();
                $('div.submit').hide();
                $('#btn_' + $(this).data('index')).fadeIn();
            }
        })

        $('.building-type').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#building_type_' + index).val(value);
            open_box(index, 'building_type');
        })

        $('.moving-type').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');
            if (value == 'groundfloor') {
                $('#groundfloor_option_'+index).show();
            } else {
                $('#groundfloor_option_'+index).hide();
            }

            $('#stair_kind_' + index).val(value);
            open_box(index, 'stair_kind');
        })

        $('.step_num_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#step_num_' + index).val(value);
            open_box(index, 'step_num');
        })

        $('.stair_type_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#stair_type_' + index).val(value);
            // $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_0.png")}}');
            // $('#flight_img_'+index).fadeIn();
            open_box(index, 'stair_type');
        })

        $('.flights_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#flights_' + index).val(value);
            // if (value == 1)
            //     $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_1.png")}}');
            // else if (value == 2)
            //     $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_2.png")}}');
            // else if (value == 3)
            //     $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_3.png")}}');
            // else if (value == 4)
            //     $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_4.png")}}');
            // else if (value == 5)
            //     $('#flight_img_'+index+' img').prop('src', '{{asset("asset/img/location-imgs/flight_5.png")}}');
            open_box(index, 'flights');
        })

        $('.ex_stair_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#ex_stair_' + index).val(parseInt(value));
            open_box(index, 'ex_stair');
        })

        $('.evelator_type_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#evelator_type_' + index).val(value);
            // $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele.png')}}");
            // $('#elevator_img_'+index).fadeIn();
            open_box(index, 'evelator_type');
        })

        $('.stair_floor_num_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#stair_floor_num_' + index).val(value);
            open_box(index, 'stair_floor_num');
        })

        $('.floor_num_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#floor_num_' + index).val(value);
            // if (value == 1)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele1.png')}}");
            // else if (value == 2)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele2.png')}}");
            // else if (value == 3)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele3.png')}}");
            // else if (value == 4)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele4.png')}}");
            // else if (value == 5)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele5.png')}}");
            // else if (value == 6)
            //     $('#elevator_img_'+index+' img').prop('src', "{{asset('asset/img/location-imgs/ele6.png')}}");
            open_box(index, 'floor_num');
        })

        $('.parking_clickable').on('click', function() {
            var index = $(this).data('index');
            var value = $(this).data('value');

            $('#parking_' + index).val(value);
            open_box(index, 'parking');
        })
    })
</script>
@endsection