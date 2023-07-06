@extends('admin.layout.base')

@section('title', 'Dashboard ')

@section('styles')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<style>
    
    .Timeline {

        display: flex;

        align-items: center;

        height: 200px;

        justify-content: center;

    }



    .event1,

    .event2,

    .event3 {

        position: relative;

    }



    .event1Bubble {

        position: absolute;

        background-color: rgba(158, 158, 158, 0.1);

        width: 165px;

        height: 60px;

        top: -70px;

        left: -15px;

        border-radius: 5px;

        box-shadow: inset 0 0 5px rgba(158, 158, 158, 0.64)

    }



    .event2Bubble {

        position: absolute;

        background-color: rgba(158, 158, 158, 0.1);

        width: 165px;

        height: 60px;

        left: -105px;

        top: 33px;

        border-radius: 5px;

        box-shadow: inset 0 0 5px rgba(158, 158, 158, 0.64)

    }



    .event1Bubble:after,

    .event1Bubble:before,

    .event2Bubble:after,

    .event2Bubble:before {

        content: "";

        position: absolute;

        width: 0;

        height: 0;

        border-style: solid;

        border-color: transparent;

        border-bottom: 0;

    }



    .event1Bubble:before {

        bottom: -10px;

        left: 13px;

        border-top-color: rgba(222, 222, 222, 0.66);

        border-width: 12px;

    }



    .event1Bubble:after {

        bottom: -8px;

        left: 13px;

        border-top-color: #F6F6F6;

        border-width: 12px;

    }



    .event2Bubble:before {

        bottom: 59px;

        left: 103px;

        border-top-color: rgba(222, 222, 222, 0.66);

        border-width: 12px;

        -webkit-transform: rotate(180deg);

        -moz-transform: rotate(180deg);

        -o-transform: rotate(180deg);

        -ms-transform: rotate(180deg);

        transform: rotate(180deg);

    }



    .event2Bubble:after {

        bottom: 57px;

        left: 103px;

        border-top-color: #F6F6F6;

        border-width: 12px;

        -webkit-transform: rotate(180deg);

        -moz-transform: rotate(180deg);

        -o-transform: rotate(180deg);

        -ms-transform: rotate(180deg);

        transform: rotate(180deg);

    }



    .eventTime {

        display: flex;

    }



    .DayDigit {

        font-size: 27px;

        font-family: "Arial Black", Gadget, sans-serif;

        margin-left: 10px;

        color: #4C4A4A;

    }



    .Day {

        font-size: 11px;

        margin-left: 5px;

        font-weight: bold;

        margin-top: 10px;

        font-family: Arial, Helvetica, sans-serif;

        color: #4C4A4A;

    }



    .MonthYear {

        font-weight: 600;

        line-height: 10px;

        color: #9E9E9E;

        font-size: 9px;

    }



    .eventTitle {

        font-family: "Arial Black", Gadget, sans-serif;

        color: #a71930;

        font-size: 11px;

        text-transform: uppercase;

        display: flex;

        flex: 1;

        align-items: center;

        margin-left: 12px;

        margin-top: -2px;

    }



    .time {

        position: absolute;

        font-family: Arial, Helvetica, sans-serif;

        width: 50px;

        font-size: 8px;

        margin-top: -3px;

        margin-left: -5px;

        color: #9E9E9E;

    }



    .eventAuthor {

        position: absolute;

        font-family: Arial, Helvetica, sans-serif;

        color: #9E9E9E;

        font-size: 8px;

        width: 100px;

        top: -8px;

        left: 63px;

    }



    .event2Author {

        position: absolute;

        font-family: Arial, Helvetica, sans-serif;

        color: #9E9E9E;

        font-size: 8px;

        width: 100px;

        top: 96px;

        left: -32px;

    }



    .time2 {

        position: absolute;

        font-family: Arial, Helvetica, sans-serif;

        width: 50px;

        font-size: 8px;

        margin-top: -31px;

        margin-left: -5px;

        color: #9E9E9E;

    }



    .now {

        background-color: #004165;

        color: white;

        border-radius: 7px;

        margin: 5px;

        padding: 4px;

        font-size: 10px;

        font-family: Arial, Helvetica, sans-serif;

        border: 2px solid white;

        font-weight: bold;

        box-shadow: 0 0 0 2px #004165

    }



    .futureGray {

        filter: grayscale(1);

        -webkit-filter: grayscale(1);



    }



    .futureOpacity {

        -webkit-filter: opacity(.3);

        filter: opacity(.3);



    }

    /*chat csss*/
    img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
  background: #ebebeb none repeat scroll 0 0;
  border-radius: 3px;
  color: #646464;
  font-size: 14px;
  margin: 0;
  padding: 5px 10px 5px 12px;
  width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 30px 15px 0 25px;
  width: 100%;
}

 .sent_msg p {
  background: #05728f none repeat scroll 0 0;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 48px;
  width: 100%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}

</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- card header -->
            <div class="card-header header-elements-inline">
                <h4 class="card-title">
                    Booking Detail Information
                </h4>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                    </div>
                </div>
            </div>
            <!-- card body -->
            <div class="card-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-capitalize" id="pills-service_type-tab" data-toggle="pill"
                            href="#pills-service_type" role="tab" aria-controls="pills-service_type"
                            aria-selected="true">service type</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" id="pills-items-tab" data-toggle="pill" href="#pills-items"
                            role="tab" aria-controls="pills-items" aria-selected="false">inventory items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" id="pills-pick_drop-tab" data-toggle="pill"
                            href="#pills-pick_drop" role="tab" aria-controls="pills-pick_drop" aria-selected="true">pick
                            & drop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" id="pills-workers-tab" data-toggle="pill"
                            href="#pills-workers" role="tab" aria-controls="pills-workers" aria-selected="true">workers
                            assigned</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" id="pills-vehicle-tab" data-toggle="pill"
                            href="#pills-vehicle" role="tab" aria-controls="pills-vehicle" aria-selected="true">vehicle
                            assigned</a>
                    </li>
                     <li class="nav-item sms_tab">

                        <a class="nav-link text-capitalize" id="pills-sms-tab" data-toggle="pill"

                            href="#pills-sms" role="tab" aria-controls="pills-sms" aria-selected="true">SMS</a>

                    </li>
                    <li class="nav-item status_tab">

<a class="nav-link text-capitalize" id="pills-status-tab" data-toggle="pill"

    href="#pills-status" role="tab" aria-controls="pills-status" aria-selected="true">Change Status</a>

</li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-service_type" role="tabpanel"
                        aria-labelledby="pills-service_type-tab">
                        @if(isset($service_type))
                        <div class="row">
                            <div class="alert alert-success col-md-2 ml-4" role="alert">
                                <h4 class="alert-heading">Service</h4>
                                <hr>
                                <h6 class="mb-0">{{$service_type->name}}</h6>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="alert alert-info col-md-2" role="alert">
                                <h4 class="alert-heading">Difficulty Level</h4>
                                <hr>
                                <h6 class="mb-0">{{$service_type->dlevel}}</h6>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="alert alert-warning col-md-2" role="alert">
                                <h4 class="alert-heading">Badges</h4>
                                <hr>
                                <h6 class="mb-0">Coming soon</h6>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="alert alert-secondary col-md-2" role="alert">
                                <h4 class="alert-heading">Status</h4>
                                <hr>
                                <h6 class="mb-0">{{$mobi_times->status}}</h6>
                            </div>
                        </div>
                        @if ($service_type->name == 'Shuffle')
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="p-2">Time Contraints:&nbsp;&nbsp;&nbsp;<span class="text-danger">{{$times_shuffle->start_time}}</span>&nbsp;~&nbsp;<span class="text-danger">{{$times_shuffle->end_time}}</span></h6>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label"><h6>Booking Prices</h6></label>
                                    <div class="input-group">
                                        <input type="number" id="total_price" class="form-control col-md-2" value="{{$charges->total_charges}}" step="0.01" readonly />
                                        <div class="input-group-append" @if ($charges->status == 1)style="display: none" @endif>
                                            <div class="input-group-text">
                                                <input type="checkbox" id="edit_allow">&nbsp;Edit
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="s-b-container" style="display: none">
                                    <select class="form-control col-md-2" id="update_type">
                                        <option selected disabled>select</option>
                                        <option value="custom">custom</option>
                                        <option value="10">10% +</option>
                                        <option value="20">20% +</option>
                                        <option value="30">30% +</option>
                                    </select>
                                </div>
                                <form action="{{route('admin.price_update', $booking_id)}}" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="form-group row" id="u-p-container" style="display: none">
                                        <label class="col-form-label col-md-4"><h6>Updated Booking Price</h6></label>
                                        <div class="input-group">
                                            <input type="number" id="updated_total_price" name="updated_total_price" class="form-control col-md-2" step="0.01" />
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>

                    <div class="tab-pane fade table-responsive" id="pills-items" role="tabpanel"
                        aria-labelledby="pills-items-tab">
                        <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: flex-end">
                            <a href="{{route('admin.booking_items', [$booking_id, $date, $date_type])}}" class="btn btn-warning">Edit Items</a>
                        </div>
                        <table class="table">
                            <thead class="thead-light">
                                <tr class="text-center text-uppercase">
                                    <th></th>
                                    <th>name</th>
                                    <th class="text-right"><i class="icon icon-watch2"></i> dis-assembly</th>
                                    <th class="text-right"><i class="icon icon-watch2"></i> loading time</th>
                                    <th class="text-right"><i class="icon icon-watch2"></i> unloading time</th>
                                    <th class="text-right">weight</th>
                                    <th class="text-right">volume</th>
                                    <th class="text-right">quantity</th>
                                </tr>
                            </thead>
                            @if (isset($loading_times))
                            @foreach ($selected_items as $item)
                            <tr class="text-center">
                                <td class="text-center">
                                    <img src="{{isset($item->file_path) ? $item->file_path : '/no_item.jpg'}}" alt="item image" style="height: 40px; width: auto">
                                </td>
                                <td class="text-primary text-capitalize">
                                    {{$item->item_name}}
                                </td>
                                <td class="text-right text-capitalize">
                                    {{isset($dis_assembly_times[$item->item_name]) ? number_format($dis_assembly_times[$item->item_name], 2, '.', ' ') : 0.00}}
                                    mins</td>
                                <td class="text-right text-capitalize">
                                    {{isset($loading_times[$item->item_name]) ? number_format($loading_times[$item->item_name], 2, '.', ' ') : 0.00}}
                                    mins</td>
                                <td class="text-right text-capitalize">
                                    {{isset($unloading_times[$item->item_name]) ? number_format($unloading_times[$item->item_name], 2, '.', ' ') : 0.00}}
                                    mins</td>
                                <td class="text-right text-capitalize">{{$item->weight}}
                                    pounds</td>
                                <td class="text-right text-capitalize">{{$item->volume}}
                                    cm3</td>
                                <td class="text-right text-capitalize">
                                    {{$item->quantity}}</td>
                            </tr>
                            @endforeach
                            <tr class="bg-info text-white">
                                <td colspan="5" class="text-right text-capitalize">total:</td>
                                <td class="text-right text-capitalize">{{$items['total_weight']}} pounds</td>
                                <td class="text-right text-capitalize">{{$items['total_volume']}} cm3</td>
                                <td></td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-pick_drop" role="tabpanel"
                        aria-labelledby="pills-pick_drop-tab">
                        {{-- <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: flex-end">
                            <a href="{{route('admin.booking_locations', $booking_id)}}" class="btn btn-warning">Edit Locations</a>
                        </div> --}}

                        <div class="Timeline">
                            @foreach($booking_location as $k => $loc)
                            @if($k == 0)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event1">
                                    <div class="event1Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($mobi_times->time_from_hub, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">hub to a time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                    {{-- <div class="time">9 : 27 AM</div> --}}
                                </div>
                                @php
                                    $pick_up_time = 0;
                                    foreach($selected_items as $item) {
                                        if($item->pick_up_loc_id == $loc->booking_loc_id) {
                                            $pick_up_time += $item->pick_up_time;
                                        }
                                    }
                                @endphp
                                @if($pick_up_time != 0)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event2">
                                    <div class="event2Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($item->pick_up_time, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">pickup time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @endif
                            @else
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event1">
                                    <div class="event1Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($times[$k], 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">Travel Time {{$k}}</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @php
                                    $pick_up_time = 0;
                                    $drop_off_time = 0;
                                    foreach($selected_items as $item) {
                                        if($item->pick_up_loc_id == $loc->booking_loc_id) {
                                            $pick_up_time += $item->pick_up_time;
                                        } elseif ($item->drop_off_loc_id == $loc->booking_loc_id) {
                                            $drop_off_time += $item->drop_off_time;
                                        }
                                    }
                                @endphp
                                @if($pick_up_time != 0)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event2">
                                    <div class="event2Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($pick_up_time, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">pickup time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @elseif($drop_off_time != 0)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event2">
                                    <div class="event2Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($drop_off_time, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">dropoff time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @endif
                                {{-- @foreach($selected_items as $item)
                                @if($item->pick_up_loc_id == $loc->booking_loc_id)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event2">
                                    <div class="event2Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($item->pick_up_time * 60, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">pickup time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @elseif($item->drop_off_loc_id == $loc->booking_loc_id)
                                <svg height="5" width="160">
                                    <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                    Sorry, your browser does not support inline SVG.
                                </svg>
                                <div class="event2">
                                    <div class="event2Bubble">
                                        <div class="eventTime">
                                            <div class="DayDigit">{{number_format($item->drop_off_time * 60, 1, '.', '')}}</div>
                                            <div class="Day">
                                                mins
                                                <div class="MonthYear">{{$service_type->booking_date}}</div>
                                            </div>
                                        </div>
                                        <div class="eventTitle">dropoff time</div>
                                    </div>
                                    <svg height="20" width="20">
                                        <circle cx="10" cy="11" r="5" fill="#004165" />
                                    </svg>
                                </div>
                                @endif
                                @endforeach --}}
                            @endif
                            @endforeach


                            <svg height="5" width="160">
                                <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                Sorry, your browser does not support inline SVG.
                            </svg>
                            <div class="event1">
                                <div class="event1Bubble">
                                    <div class="eventTime">
                                        <div class="DayDigit">{{number_format($mobi_times->time_to_hub, 1, '.', '')}}</div>
                                        <div class="Day">
                                            mins
                                            <div class="MonthYear">{{$service_type->booking_date}}</div>
                                        </div>
                                    </div>
                                    <div class="eventTitle">b to hub time</div>
                                </div>
                                <svg height="20" width="20">
                                    <circle cx="10" cy="11" r="5" fill="#004165" />
                                </svg>
                            </div>
                            <svg height="5" width="160">
                                <line x1="0" y1="0" x2="160" y2="0" style="stroke:#004165;stroke-width:5" />
                                Sorry, your browser does not support inline SVG.
                            </svg>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-4">
                            @foreach($booking_location as $k => $loc)
                                <div class="form-group mb-3">
                                    @if($k == 0)
                                    <label for="">Pick Up Location</label>
                                    @elseif($k == count($booking_location) - 1)
                                    <label for="">Drop Off Location</label>
                                    @else
                                    <label for="">Additional Location {{$k}}</label>
                                    @endif
                                    <div class="input-group">
                                        <input type="text" value="{{$loc->location}}" class="form-control" id="address_{{$k}}">
                                        <div class="input-group-append">
                                            @if($k == 0)
                                            <button class="btn btn-info show-info" value="{{$k}}"><i class="icon icon-check"></i></button>
                                            @else
                                            <button class="btn btn-warning show-info" value="{{$k}}"><i class="icon icon-eye"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div class="col-sm-1 col-md-1 col-lg-1"></div>
                            <div class="col-sm-5 col-md-7 col-lg-7">
                            @foreach($booking_location as $k => $loc)
                            <div class="row location_info_detail" id="location_info_detail_{{$k}}" style="@if(!$k == 0)display: none @endif">
                            @if($loc->stair_kind == 'stairs')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead">Bulkhead</option>
                                            <option value="groundfloor">Ground Floor</option>
                                            <option value="entrance">Entrance Steps</option>
                                            <option value="stairs" selected>Stairs</option>
                                            <option value="elevator">Elevator</option>
                                            <option value="both">Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">What kind of stairs are they?</label>
                                        <select name="" id="stair_type_{{$k}}" class="form-control">
                                            <option value="wide" @if($loc->stair_type == 'wide')selected @endif>Wide</option>
                                            <option value="windy" @if($loc->stair_type == 'windy')selected @endif>Windy</option>
                                            <option value="narrow" @if($loc->stair_type == 'narrow')selected @endif>Narrow</option>
                                            <option value="spiral" @if($loc->stair_type == 'spiral')selected @endif>Spiral</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How many flights are there?</label>
                                        <select name="" id="flights_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->flights == 1)selected @endif>1</option>
                                            <option value="2" @if($loc->flights == 2)selected @endif>2</option>
                                            <option value="3" @if($loc->flights == 3)selected @endif>3</option>
                                            <option value="4" @if($loc->flights == 4)selected @endif>4</option>
                                            <option value="5" @if($loc->flights == 5)selected @endif>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @elseif($loc->stair_kind == 'elevator')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead">Bulkhead</option>
                                            <option value="groundfloor">Ground Floor</option>
                                            <option value="entrance">Entrance Steps</option>
                                            <option value="stairs">Stairs</option>
                                            <option value="elevator" selected>Elevator</option>
                                            <option value="both">Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">What kind of elevator are they?</label>
                                        <select name="" id="elevator_type_{{$k}}" class="form-control">
                                            <option value="passenger" @if($loc->evelator_type == 'passenger')selected @endif>Passenger</option>
                                            <option value="freight" @if($loc->evelator_type == 'freight')selected @endif>Freight</option>
                                            <option value="reserved_freight" @if($loc->evelator_type == 'reserved_freight')selected @endif>Reserved Freight</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Which floor are you on?</label>
                                        <select name="" id="floor_num_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->floor_num == 1)selected @endif>1</option>
                                            <option value="2" @if($loc->floor_num == 2)selected @endif>2</option>
                                            <option value="3" @if($loc->floor_num == 3)selected @endif>3</option>
                                            <option value="4" @if($loc->floor_num == 4)selected @endif>4</option>
                                            <option value="5" @if($loc->floor_num == 5)selected @endif>5</option>
                                            <option value="6" @if($loc->floor_num == 6)selected @endif>6</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @elseif($loc->stair_kind == 'bulkhead')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead" selected>Bulkhead</option>
                                            <option value="groundfloor">Ground Floor</option>
                                            <option value="entrance">Entrance Steps</option>
                                            <option value="stairs">Stairs</option>
                                            <option value="elevator">Elevator</option>
                                            <option value="both">Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How many steps are there?</label>
                                        <select name="" id="step_{{$k}}" class="form-control">
                                            <option value="1to3" @if($loc->step_num == '1to3')selected @endif>1 To 3</option>
                                            <option value="4to5" @if($loc->step_num == '4to5')selected @endif>4 To 5</option>
                                            <option value="8to12" @if($loc->step_num == '8to12')selected @endif>8 To 12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @elseif($loc->stair_kind == 'groundfloor')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead">Bulkhead</option>
                                            <option value="groundfloor" selected>Ground Floor</option>
                                            <option value="entrance">Entrance Steps</option>
                                            <option value="stairs">Stairs</option>
                                            <option value="elevator">Elevator</option>
                                            <option value="both">Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How many steps are there?</label>
                                        <select name="" id="step_{{$k}}" class="form-control">
                                            <option value="1to3" @if($loc->step_num == '1to3')selected @endif>1 To 3</option>
                                            <option value="4to5" @if($loc->step_num == '4to5')selected @endif>4 To 5</option>
                                            <option value="8to12" @if($loc->step_num == '8to12')selected @endif>8 To 12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @elseif($loc->stair_kind == 'entrance')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead">Bulkhead</option>
                                            <option value="groundfloor">Ground Floor</option>
                                            <option value="entrance" selected>Entrance Steps</option>
                                            <option value="stairs">Stairs</option>
                                            <option value="elevator">Elevator</option>
                                            <option value="both">Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How many steps are there?</label>
                                        <select name="" id="step_{{$k}}" class="form-control">
                                            <option value="1to3" @if($loc->step_num == '1to3')selected @endif>1 To 3</option>
                                            <option value="4to5" @if($loc->step_num == '4to5')selected @endif>4 To 5</option>
                                            <option value="8to12" @if($loc->step_num == '8to12')selected @endif>8 To 12</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @elseif($loc->stair_kind == 'both')
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How are they moving?</label>
                                        <select name="" id="move_type_{{$k}}" class="form-control">
                                            <option value="bulkhead">Bulkhead</option>
                                            <option value="groundfloor">Ground Floor</option>
                                            <option value="entrance">Entrance Steps</option>
                                            <option value="stairs">Stairs</option>
                                            <option value="elevator">Elevator</option>
                                            <option value="both" selected>Both(Elevator & Flights)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">What kind of stairs are they?</label>
                                        <select name="" id="stair_type_{{$k}}" class="form-control">
                                            <option value="wide" @if($loc->stair_type == 'wide')selected @endif>Wide</option>
                                            <option value="windy" @if($loc->stair_type == 'windy')selected @endif>Windy</option>
                                            <option value="narrow" @if($loc->stair_type == 'narrow')selected @endif>Narrow</option>
                                            <option value="spiral" @if($loc->stair_type == 'spiral')selected @endif>Spiral</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">How many flights are there?</label>
                                        <select name="" id="flights_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->flights == 1)selected @endif>1</option>
                                            <option value="2" @if($loc->flights == 2)selected @endif>2</option>
                                            <option value="3" @if($loc->flights == 3)selected @endif>3</option>
                                            <option value="4" @if($loc->flights == 4)selected @endif>4</option>
                                            <option value="5" @if($loc->flights == 5)selected @endif>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">What kind of elevator are they?</label>
                                        <select name="" id="elevator_type_{{$k}}" class="form-control">
                                            <option value="passenger" @if($loc->evelator_type == 'passenger')selected @endif>Passenger</option>
                                            <option value="freight" @if($loc->evelator_type == 'freight')selected @endif>Freight</option>
                                            <option value="reserved_freight" @if($loc->evelator_type == 'reserved_freight')selected @endif>Reserved Freight</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Which floor are you on?</label>
                                        <select name="" id="floor_num_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->floor_num == 1)selected @endif>1</option>
                                            <option value="2" @if($loc->floor_num == 2)selected @endif>2</option>
                                            <option value="3" @if($loc->floor_num == 3)selected @endif>3</option>
                                            <option value="4" @if($loc->floor_num == 4)selected @endif>4</option>
                                            <option value="5" @if($loc->floor_num == 5)selected @endif>5</option>
                                            <option value="6" @if($loc->floor_num == 6)selected @endif>6</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Parking & Building Information</label>
                                        <select name="" id="parking_{{$k}}" class="form-control">
                                            <option value="1" @if($loc->parking == 1)selected @endif>Loading dock will be reserved</option>
                                            <option value="2" @if($loc->parking == 2)selected @endif>Parking permit will be pulled</option>
                                            <option value="3" @if($loc->parking == 3)selected @endif>Metered parking available</option>
                                            <option value="4" @if($loc->parking == 4)selected @endif>Commercial parking available</option>
                                            <option value="5" @if($loc->parking == 5)selected @endif>Easy street parking available</option>
                                            <option value="6" @if($loc->parking == 6)selected @endif>Home driveway available</option>
                                            <option value="7" @if($loc->parking == 7)selected @endif>Other</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            </div>
                            @endforeach
                            </div>
                        </div>
                        <hr>
                        <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: flex-end">
                            <a href="{{route('admin.booking_locations', $booking_id)}}" class="btn btn-warning">Update Locations</a>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-workers" role="tabpanel" aria-labelledby="pills-workers-tab">
                        <table class="table">
                            <thead class="thead-light">
                                <tr class="text-center text-uppercase">
                                    <th>name</th>
                                    <th class="text-center">level</th>
                                    <th class="text-center">designation</th>
                                    <th class="text-center">stars</th>
                                    <th class="text-center">badges</th>
                                    <th class="text-center">message</th>
                                </tr>
                            </thead>
                            @isset($assigned_workers)
                            @foreach ($assigned_workers as $w)
                            <tr class="text-center">
                                <td class="text-primary text-capitalize">
                                    {{$w['name']}}
                                </td>
                                <td class="text-primary text-capitalize">
                                    level - {{$w['level']}}
                                </td>
                                <td class="text-primary text-capitalize">
                                    {{$w['designation']}}
                                </td>
                                <td class="text-primary text-capitalize">
                                    {{-- {{$w->stars}} --}}
                                </td>
                                <td class="text-primary text-capitalize">
                                    {{$w['badges']}}
                                </td>
                                <td class="text-primary text-capitalize">
                                    {{-- {{$w->message}} --}}
                                </td>
                            </tr>
                            @endforeach
                            @endisset
                        </table>
                    </div>

                    <div class="tab-pane fade" id="pills-vehicle" role="tabpanel" aria-labelledby="pills-vehicle-tab">
                        <table class="table">
                            <thead class="thead-light">
                                <tr class="text-center text-uppercase">
                                    <th>name</th>
                                    <th class="text-center">type</th>
                                    <th class="text-center">color</th>
                                    <th class="text-center">volumetric capacity</th>
                                </tr>
                            </thead>
                            @isset($assigned_truck)
                            <tr class="text-center">
                                <td class="text-capitalize">
                                    {{$assigned_truck['name']}}
                                </td>
                                <td class="text-capitalize">
                                    {{$assigned_truck['type']}}
                                </td>
                                <td class="text-capitalize" style="color: {{$assigned_truck['color']}}">
                                    <i class="icon-truck icon-2x"></i>
                                </td>
                                <td class="text-capitalize">
                                    {{$assigned_truck['volume']}}
                                </td>
                            </tr>
                            @endisset
                        </table>
                    </div>
                     <div class="tab-pane fade" id="pills-sms" role="tabpanel" aria-labelledby="pills-sms-tab">
                        <div class="card-body">
                           <div class="container">
<div class="messaging">
      <div class="inbox_msg">
        
        <div class="mesgs">
          <div class="msg_history">
            
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    </div>
                    </div>

       </div>
       <div class="tab-pane fade" id="pills-status" role="tabpanel" aria-labelledby="pills-status-tab">
        <div class="card-body">
                           <div class="container">
                               <div class="row">
                                 <div class="form-group">
                                   
                <label for="email">Change Status:</label>
       <select class="form-control" name="status" id="status">
           <option value="">Select</option>
           <option value="Pending" >Pending</option>
           <option value="Confirmed" >Confirmed</option>
           <option value="Complete">Complete</option>

       </select>
  </div>
                               </div>

                           </div>
                       </div>
       </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="/admin/booking_status">
        {{csrf_field()}}
      <div class="modal-body">
        <h3>
       Are you sure to change status of booking</h3>
      </div>
       <input type="hidden" name="booking_id" id="" value="{{ Request::segment(3) }}"> 
       <input type="hidden" name="bookingstatus" id="bookingstatus" value="{{ Request::segment(3) }}">
       <div class="container"> 
       <div class="row">
         <div class="col-md-6">
            <div class="form-group">
                <input type="hidden" name="tomail" value="{{$personal_detials->email}}">
            <label for="">From Mail</label>
             <input class="form-control" required name="frommail" />
        </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
            <label for="">Mail Subject</label>
             <input class="form-control" required name="mailsubject" />
        </div>
          </div>
         <div class="col-md-12">
            <div class="form-group">
            <label for="">Mail Message</label>
             <textarea required name="mailtemplate" id="mailtemplate">Dear, {{$personal_detials->first_name}}</textarea>
        </div>
          </div>
</div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="submit" class="btn btn-primary ">Yes</button>
      </div>
  </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places" type="text/javascript" ></script>
<script>
    $(document).ready(function() {
        $('#edit_allow').change(function() {
            if ($(this).prop('checked') == true) {
                $('#s-b-container').fadeIn()
            } else {
                $('#s-b-container').fadeOut()
            }
        })

        $('#update_type').change(function() {
            switch ($(this).val()) {
                case 'custom':
                    $('#updated_total_price').val(0)
                    $('#u-p-container').show()
                    break;
                case '10':
                    $('#updated_total_price').val((parseFloat($('#total_price').val()) + parseFloat($('#total_price').val()) / 10).toFixed(2))
                    $('#u-p-container').show()
                    break;
                case '20':
                    $('#updated_total_price').val((parseFloat($('#total_price').val()) + parseFloat($('#total_price').val()) / 5).toFixed(2))
                    $('#u-p-container').show()
                    break;
                case '30':
                    $('#updated_total_price').val((parseFloat($('#total_price').val()) + parseFloat($('#total_price').val()) * 3 / 10).toFixed(2))
                    $('#u-p-container').show()
                    break;
            }
        })
    })
</script>
<script>
CKEDITOR.replace( 'mailtemplate' );
 var sentNexturl = null;
  var recievedMsgesnexturl = null;
    function formatDate(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'pm' : 'am';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime+ " |  "+ date.getDate() + "-" + (date.getMonth()+1) + "-" +  date.getFullYear();

}


  var messages_value  = [];
    jQuery(document).ready(function() {

     var phonesnumbers = "{{$personal_detials->phone_number}}";

  //sent mesages
               var sent = {
  "url": "https://api.twilio.com/2010-04-01/Accounts/AC23ed296c1d0c93698f68cd55cc252798/Messages.json?PageSize=20&To="+phonesnumbers+"&From={{env('TWILIO_NUMBER')}}",
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

   var recievedMsges = {
  "url": "https://api.twilio.com/2010-04-01/Accounts/AC23ed296c1d0c93698f68cd55cc252798/Messages.json?PageSize=20&To={{env('TWILIO_NUMBER')}}&From="+phonesnumbers,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
  $.ajax(recievedMsges).done(function (recievedMsgList) {
    var allmessages = sentMessage.concat(recievedMsgList.messages);
    // console.log(allmessages);

  recievedMsgesnexturl = recievedMsgList.next_page_uri;
    allmessages.sort((a, b) => (new Date(a.date_created).valueOf()  > new Date(b.date_created).valueOf() ) ? 1 : -1)
    // console.log(allmessages);
     $.each(allmessages,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            messages_value +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
messages_value += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
     $('.msg_history').html('');
  $('.msg_history').html(messages_value);
  $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
});
});


$('.msg_send_btn').click(function(event){
    if($('.write_msg').val()!=''){
       $.ajax({
           type: "POST",
           url: "/admin/send_messages",
           data: {'message':$('.write_msg').val(),'booking_id':'{{Request::segment(3) }}','phone_number':phonesnumbers,'full_name':'{{$personal_detials->first_name}} {{$personal_detials->last_name}}'},
            // beforeSend: function(xhr){xhr.setRequestHeader('X-Test-Header', 'test-value');},
            headers:{
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
           success: function(data)
           {
            if(data.status==200){
                var time = new Date();
                var time_formats = formatDate(time);
                var new_message = '<div class="outgoing_msg"><div class="sent_msg"><p>'+data.message+'</p><span class="time_date">'+time_formats+'</span> </div></div>';
                 $('.msg_history').append(new_message);
                $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
                $('.write_msg').val('');
            }
           }
         });  
    }
   
})

$('.msg_history').scroll(function(event){
    if($(this).scrollTop()==0){
      
  chatAppendNew(sentNexturl,recievedMsgesnexturl);
    }
    

  })


        $(".show-info").click(function(event) {

            var index = $(this).val();

            $('.location_info_detail').hide();

            $('#location_info_detail_' + index).show();

            $('.show-info').empty();

            $('.show-info').removeClass('btn-info');

            $('.show-info').addClass('btn-warning');

            $('.show-info').append('<i class="icon icon-eye"></i>');



            $(this).empty();

            $(this).removeClass('btn-warning');

            $(this).addClass('btn-info');

            $(this).append('<i class="icon icon-check"></i>');

        })

    })



    var loc_count = {{count($booking_location)}};

    var address = [];

    for (var i = 0; i < loc_count; i++) {

        address[i] = new google.maps.places.Autocomplete(document.getElementById('address_' + i));

    }

    function chatAppendNew(sentUrl,RecivedUrl){
  if(sentUrl!=null && RecivedUrl!=null){
//sent mesages
               var sent = {
  "url": "https://api.twilio.com"+sentUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

   var recievedMsges = {
  "url": "https://api.twilio.com"+RecivedUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};

$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
  $.ajax(recievedMsges).done(function (recievedMsgList) {
    var allmessages = sentMessage.concat(recievedMsgList.messages);
    recievedMsgesnexturl = recievedMsgList.next_page_uri;

    allmessages.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
    // console.log(allmessages);
     $.each(allmessages,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            messages_value +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
messages_value += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(messages_value);
});
});
  }
  else if(sentUrl!=null && RecivedUrl==null){
                var sent = {
  "url": "https://api.twilio.com"+sentUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};
$.ajax(sent).done(function (response) {
    var sentMessage = response.messages;
    sentNexturl = response.next_page_uri;
    recievedMsgesnexturl = null;
      sentMessage.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
      var new_messages = '';
    // console.log(allmessages);
     $.each(sentMessage,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            new_messages +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
new_messages += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(new_messages);

  })


  }
  else if(sentUrl==null && RecivedUrl!=null) {
     var recievedMsges = {
  "url": "https://api.twilio.com"+RecivedUrl,
  "method": "GET",
  "timeout": 0,
  "headers": {
    "Authorization": "Basic {{env('TWILIO_AUTH')}}"
  },
};
$.ajax(recievedMsges).done(function (response) {
    var sentMessage = response.messages;
    recievedMsgesnexturl = response.next_page_uri;
   sentNexturl = null;

   sentMessage.sort((a, b) => (new Date(a.date_created).valueOf() > new Date(b.date_created).valueOf()) ? 1 : -1)
      var new_messages = '';
    // console.log(allmessages);
     $.each(sentMessage,function(index,value){
    var d = new Date(value.date_created);
var time_formats = formatDate(d);

    if(value.direction==='inbound'){
            new_messages +='<div class="incoming_msg"><div class="received_msg"><div class="received_withd_msg"><p>'+value.body+'</p><span class="time_date"> '+time_formats+'</span></div></div></div>'
    }
    else{
new_messages += '<div class="outgoing_msg"><div class="sent_msg"><p>'+value.body+'</p><span class="time_date">'+time_formats+'</span> </div></div>'
    }
  })
  $('.msg_history').prepend(new_messages);
  })
  }
}
$('#status').change(function(e){
    var Status = '';
    if($(this).val()!=''){
        $('#exampleModal').modal('show');
        Status = $(this).val();
        $('#bookingstatus').val(Status);
    }
})

</script>
@endsection