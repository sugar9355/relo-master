@extends('user.layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('styles')
    <link rel="stylesheet" href="{{asset('asset/notiflix/notiflix-2.3.1.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/css/style-preview.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('switchery-master/dist/switchery.min.css')}}">
    <link rel="stylesheet" href="{{asset('calender/jquery.datetimepicker.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <style>

    @media (min-width: 1400px){
        .col-rel {
            flex: 0 0 75%;
        max-width: 75%;
    }
    }

    @media (max-width: 501px){
    .cir-con {
        font-size: 12px;
        width: 35%;
    }



    }

    .r_pad{
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .rounded-right{
        border-bottom-right-radius:20px!important;
        border-top-right-radius:20px!important; 
    }
    .rounded-left{
        border-bottom-left-radius:20px!important;
        border-top-left-radius:20px!important;
    }
    .btn{
        border-radius: 0px;
        border:1px solid white;
    }

    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
    50% {
        opacity: 0.8;
    }
    }
    .accordion .card-header:after {
        font-family: 'FontAwesome';  
        content: "\f068";
        float: right; 
    }
    .accordion .card-header.collapsed:after {
        /* symbol for "collapsed" panels */
        content: "\f067"; 
    }
    .cursor {
        cursor: pointer;
    }
    .not-allowed {
        cursor: not-allowed !important;
    }
    .hov:hover{
     
        box-shadow: 4px 4px 5px 1px rgba(0, 0, 0, 0.24);
    }
    .hov{
        background-color:#AA0114;
        color:white!important;
    }
    .shadow-date {
        position:relative;
        
        background-Color:#1C2A39; color:white
      border: 2px solid #1C2A39! ;
      color: white;
      -webkit-box-shadow: 7px 9px 14px -1px rgba(181, 181, 181, 1);
    -moz-box-shadow: 7px 9px 14px -1px rgba(181, 181, 181, 1);
   box-shadow: 4px 4px 5px 1px rgba(0, 0, 0, 0.24);
    border: 1px solid rgb(189, 189, 189, 0.3);
    background-color: #f4f4f4;
    }
    .bs-example{
        margin: 20px;
    }
    .accordion .fa{
        margin-right: 0.5rem;
      	font-size: 24px;
      	font-weight: bold;
        position: relative;
    	top: 2px;
    }
    button:hover{
        color: white!important;
    }

    .active32 {
        border-radius: 0px 0px 0px 0px;
        -moz-border-radius: 0px 0px 0px 0px;
        -webkit-border-radius: 0px 0px 0px 0px;
        background-color: none;
        transition: 0.3s;
        z-index: 1;
        -webkit-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
        -moz-box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
        box-shadow: 5px 4px 14px -1px rgb(95, 95, 95);
    }

    .drop {
        background-color: grey;
    }

    .modal-backdrop {
        background-color: grey;
    }

    [type=button]:not(:disabled),
    [type=reset]:not(:disabled),
    [type=submit]:not(:disabled),
    button:not(:disabled) {
        cursor: pointer;
    }

    li {
        font-size: 12px;

        margin: 0 auto;
    }

    #time-range p {
        font-family: "Arial", sans-serif;
        font-size: 14px;
        color: #333;
    }

    .ui-slider-horizontal {
        height: 8px;
        background: #D7D7D7;
        border: 1px solid #BABABA;
        box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
        clear: both;
        margin: 8px 0;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        -ms-border-radius: 6px;
        -o-border-radius: 6px;
        border-radius: 6px;
    }

    .ui-slider {
        position: relative;
        text-align: left;
    }

    .ui-slider-horizontal .ui-slider-range {
        top: -1px;
        height: 100%;
    }

    .ui-slider .ui-slider-range {
        position: absolute;
        z-index: 1;
        height: 8px;
        font-size: .7em;
        display: block;
        border: 1px solid #5BA8E1;
        box-shadow: 0 1px 0 #AAD6F6 inset;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        -khtml-border-radius: 6px;
        border-radius: 6px;
        background: #81B8F3;
        background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
        background-size: 100%;
        background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
        background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
        background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
        background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
        background-image: linear-gradient(top, #A0D4F5, #81B8F3);
    }

    .ui-slider .ui-slider-handle {
        border-radius: 50%;
        background: #F9FBFA;
        background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
        background-size: 100%;
        background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
        background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
        background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
        background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
        background-image: linear-gradient(top, #C7CED6, #F9FBFA);
        width: 22px;
        height: 22px;
        -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
        -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
        box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
        -webkit-transition: box-shadow .3s;
        -moz-transition: box-shadow .3s;
        -o-transition: box-shadow .3s;
        transition: box-shadow .3s;
    }

    .ui-slider .ui-slider-handle {
        position: absolute;
        z-index: 2;
        width: 22px;
        height: 22px;
        cursor: default;
        border: none;
        cursor: pointer;
    }

    .ui-slider .ui-slider-handle:after {
        content: "";
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        top: 50%;
        margin-top: -4px;
        left: 50%;
        margin-left: -4px;
        background: #30A2D2;
        -webkit-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
        -moz-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 white;
        box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
    }

    .ui-slider-horizontal .ui-slider-handle {
        top: -.5em;
        margin-left: -.6em;
    }

    .ui-slider a:focus {
        outline: none;
    }

    #panel {

        display: none;
    }

    .div-color1 {
        border: none;
    }

    </style>
    @php
    $total_charge = 0;
    foreach ($charges as $key => $charge) {
        if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items' && $key != 'curbside_fees' && $key != 'items_price')
            $total_charge += $charge;
        elseif ($key == 'curbside_fees')
            $total_charge -= $charge;
    }
    @endphp

    <style>
        td[id^="td_pickup_"]:hover, td[id^="td_dropoff_"]:hover {
            opacity: 70%;
            box-shadow: 0 10px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
@endsection

@section('content')
<section class="content mb-5" id="summary">
    @include('booking.summary.location')
    <div class="container-fluid" id="main_part">
        {{-- @include('booking.summary.calendar_price') --}}
        <div class="row">
            <div class="col-md-12 ">
                @include('booking.summary.demand_shu')
                <div class="col-4"></div>
                <div class="bar"></div>
                <div class="calendar-box row">
                    <div class="col-md-4" id="calendar-1">
                        @include('booking.summary.cal_shu_left')
                    </div>
                    <div class="col-md-4" id="calendar-2">
                        @include('booking.summary.cal_shu_right')
                    </div>
             
                {{-- @include('booking.summary.inventory') --}}
           
            <div class="col-md-4">
                <div class="price col-12 card mt-3 col-12s" id="price-part" style="@if(count($booking_dates) < 2)display:none 
 
                @endif">
                <div id="accordion" class="accordion col-12 nopad">
                    <div class="card mb-0">
                        <div style="background-color:#1C2A39; color:white" class="card-header collapsed mt-4" data-toggle="collapse" href="#collapseOne">
                            <a class="card-title">Price $<span id="total_price">{{number_format($total_charge + $insurance_data['Recommended']['you_pay'], 2)}}</span></a>
                        </div>
                        <div id="collapseOne" class="card-body collapse" data-parent="#accordion">
                            <div id="prices_box">
                                @include('booking.summary.price_shuffle')
                            </div>
                        </div>
                
                    </div>
                </div>
                
                 
                    <div>
                        {{-- <form id="final-book-form" action="/booking/{{ ($booking->booking_id) ?: null }}" method="POST" enctype="multipart/form-data" style="width: 100%">
                            {{ csrf_field() }} --}}
                            <div style="width: 100%; display: flex; align-items: center;">
                                {{-- @php
                                $total_charge = 0;
                                foreach ($charges as $key => $charge) {
                                    if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items' && $key != 'curbside_fees' && $key != 'items_price')
                                        $total_charge += $charge;
                                    elseif ($key == 'curbside_fees')
                                        $total_charge -= $charge;
                                }
                                @endphp
                                <input type="hidden" name="mobilization_charges" value="0">
                                <input type="hidden" name="crew_charges" value="0">
                                <input type="hidden" name="additional_charges" value="0">
                                <input type="hidden" name="insurance_charges" id="insurance_charges" value="{{$insurance_data['Recommended']['you_pay']}}">
                                <input type="hidden" name="total_charges" id="total_charges_val" value="{{(float)$total_charge + (float)$insurance_data['Recommended']['you_pay']}}"> --}}
                                @php 
                                if($chargess['difficulty_level']=="level-4"||$chargess['difficulty_level']=="level-5") { 
                                @endphp
                                <button  class="button icon book-now-btn btn-7a mx-auto mt-4" id="saveBookinfff"  value="7"
                                    style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" type="submit">
                                    <div id="circle" class="circle"></div> Book Now
                                </button> 
                                
                                
                                @php  
                                } else {
                                @endphp
                                    <button id="button-1" class="button icon book-now-btn btn-7a mx-auto mt-4" name="btn_submit" value="7"
                                                    style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" type="submit">
                                                    <div id="circle" class="circle"></div> Book Now
                                                </button>
                                @php  
                                }
                                @endphp
                            </div>
                        {{-- </form>  --}}
              
                        <div class="col-lg-12 col-xl-12 mx-auto justify-content-center d-flex flex-row bd-highlight mb-3">
                            <div class=" nopad  ">
                                <button  style="font-size: 12px; "  id="remindLater" class="btn r_pad  icon  btn-7a rounded-left" name="btn_submit" 
                            style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" >
                            <div id="circle" class="circle"></div> Remind me later
                        </button>
                            </div>
                            <div class=" nopad">
                                <a style="text-decoration:none" href="{{url('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <button style="font-size: 12px;"  class=" r_pad btn icon  btn-7a" name="btn_submit" 
                                    style=" outline: none; border: none; color:white; font-size: 16px; padding:5px">
                                    <div id="circle" class="circle"></div> Skip For Now
                                </button></a>
                            </div>
                            <div class=" nopad">
                                <button style="font-size: 12px;"  id="SAveBooking" class="rounded-right r_pad  btn icon  btn-7a" name="btn_submit" 
                                style=" outline: none; border: none; color:white; font-size: 16px; padding:5px" >
                                <div id="circle" class="circle"></div> Save Booking
                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="insurance_modal" tabindex="-1" role="dialog" aria-labelledby="InsuranceModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="exampleModalLabel">Insurance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('booking.summary.insurance')
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>


<div class="modal fade" id="remindLater_modal" tabindex="-1" role="dialog" aria-labelledby="remindLater_modals" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="exampleModalLabel">Remind Me Later</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row container">
                   <form style="width: 100%" method="post" action="{{url('save-remind-later')}}">
                    {{ csrf_field() }}
                   <div class="row">
                    <input type="" name="booking_id" value="{{ Request::segment(2) }}" hidden>
                    <div class="col-md-12">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                   </div>
                    <div class="row">
                    <div class="col-md-12">
                        <label>Date</label>
                        <input type="hidden" name="dateTime" id="dateREmnd" class="form-control " required>
                        <div id="demo"></div>
                    </div>
                   </div>
                   <div class="row mt-5">
                    <div class="col-md-4">
                   <button type="submit" class="btn btn-primary">Save Booking</button>
                   </div>
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="saveBookingmodel" tabindex="-1" role="dialog" aria-labelledby="saveBookingmodels" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="exampleModalLabel">Save Booking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <div class="row container">
                   <form style="width: 100%" method="post" action="{{url('saveBooking-future')}}">
                   <div class="row">
                     {{ csrf_field() }}
                     <input type="" name="booking_id" value="{{ Request::segment(2) }}" hidden>
                    <div class="col-md-12">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                   </div>
                   <div class="row mt-5">
                    <div class="col-md-4">
                   <button type="submit" class="btn btn-primary">Save Booking</button>
                   </div>
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <div class="modal fade" id="saveBookinfffmodel" tabindex="-1" role="dialog" aria-labelledby="saveBookinfffmodel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="exampleModalLabel">Save Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             <div class="row container">
                   <form style="width: 100%" method="post" action="{{url('save-user-details')}}">
                   <div class="row col-md-12">
                     {{ csrf_field() }}
                     <input type="" name="booking_id" value="{{ Request::segment(2) }}" hidden>
                    <div class="col-md-12">
                        <label>Full Name</label>
                        <input type="text" name="fullname" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label>Mobile Number</label>
                        <input type="text" name="mobileno" class="form-control" required>
                    </div>
                   </div>
                   <div class="row mt-5 col-md-12">
                    <div class="col-md-12">
                   <button type="submit" class="btn-primary">Save</button>
                   </div>
                   </div>
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="kit-selection" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false" style="background: #000000aa">
    <div class=" modal-dialog modal-full-height modal-right modal-notify modal-info drop" role="document">
        <div class="modal-content ">
            <!--Header-->
            <div class="modal-header bg-warning text-light">
                Select your Kit
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">×</span>
                </button>
            </div>

            <form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @php
                $total_charge = 0;
                foreach ($charges as $key => $charge) {
                    if ($key != 'shuffle_price' && $key != 'peak_factor' && $key != 'pickup_items' && $key != 'dropoff_items' && $key != 'curbside_fees' && $key != 'items_price')
                        $total_charge += $charge;
                    elseif ($key == 'curbside_fees')
                        $total_charge -= $charge;
                }
                @endphp
                <input type="hidden" name="mobilization_charges" value="0">
                <input type="hidden" name="crew_charges" value="0">
                <input type="hidden" name="additional_charges" value="0">
                <input type="hidden" name="insurance_charges" id="insurance_charges" value="{{$insurance_data['Recommended']['you_pay']}}">
                <input type="hidden" name="total_charges" id="total_charges_val" value="{{(float)$total_charge + (float)$insurance_data['Recommended']['you_pay']}}">
            <!--Body-->
            <div class="modal-body">
            <div class="form-group">
                <div class="col-md-12">
                <div class="checkbox">
                    <label for="checkboxes-0">
                    <input type="checkbox" name="kit[]" id="checkboxes-0" value="survival" @isset($charges['survival_kit'])checked @endisset>
                        Survival Kit: 1 blow up mattress, 1 blow up couch, </br>1 toiletries kit (${{isset($survival_kit) ? $survival_kit : 0}})
                    </label>
                    </div>
                <div class="checkbox">
                    <label for="checkboxes-1">
                    <input type="checkbox" name="kit[]" id="checkboxes-1" value="supplies" @isset($charges['supplies_kit'])checked @endisset>
                        Supplies Kit: Based on your inventory size (${{isset($supplies_kit) ? $supplies_kit : 0}})
                    </label>
                    </div>
                </div>
            </div>

            <!-- <div class="text-center">
                    <hr>
                    <p class="text-center"></p>
                    <div class="form-check mb-4 div-color1" id="survival_box" onclick="select_kit('survival')">
                        <label class="form-check-label ml-2" for="radio-179">Survival Kit: 1 blow up mattress, 1 blow up couch, </br>1 toiletries kit (${{isset($survival_kit) ? $survival_kit : 0}})</label>
                    </div>
                    <div class="form-check mb-4 div-color1" id="supplies_box" onclick="select_kit('supplies')">
                        <label class="form-check-label ml-2" for="radio-279">Supplies Kit: Based on your inventory size (${{isset($supplies_kit) ? $supplies_kit : 0}})</label>
                    </div>
                </div>
            </div> -->
            <!--Footer-->
            <div style="border-top: 1px solid #dee2e6; " class="modal-footer justify-content-center">
                    <button type="submit" name="btn_kit_check" value="1" class="btn bg-warning dvvv drop-btn">Get it now <i class="far fa-gem ml-1 text-white"></i></button>
                    <button type="submit" name="btn_kit_check" value="0" class="btn btn-outline-success dvvv drop-btn">No, thanks <i class="far fa-gem ml-1 text-white"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
<script src="{{asset('asset/booking/inventory.js')}}"></script>
<script src="{{asset('switchery-master/dist/switchery.min.js')}}"></script>

@section('scripts')
<script src="https://use.fontawesome.com/0c92cb45bb.js"></script>
<script src="{{asset('asset/notiflix/notiflix-2.3.1.min.js')}}"></script>
<script src="{{asset('asset/notiflix/notiflix-aio-2.3.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{asset('calender/jquery.datetimepicker.min.js')}}"></script>
<script>
    function open_modal(date, type) {
        $('#panel-'+type).hide()
        $('#chosen_date_'+type).val(date)
        $('#chosen_start_time_'+type).val(null)
        $('#chosen_end_time_'+type).val(null)

        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
        const dates = ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th", "10th", "11th", "12th", "13th", "14th", "15th", "16th", "17th", "18th", "19th", "20th", "21st", "22nd", "23rd", "24th", "25th", "26th", "27th", "28th", "29th", "30th", "31st"]
        const d = new Date(date)
        let mo = months[d.getMonth()]
        let da = dates[d.getDate()]
        $('#date_'+type).html(da+', '+mo)
        $('#modalPoll-'+type).modal('show')
    }

    function show_time(type) {
        $('#panel-'+type).show()
        $('#chosen_start_time_'+type).val('6:00 AM')
        $('#chosen_end_time_'+type).val('9:00 PM')
    }


    $(document).ready(function() {
         $(function() {
            $('#test1').click(function() { // when a .myDiv is clicked
                if(this.checked) {
                    $('#panel').show()
                    $('#text_flexible_0').hide()
                    $('#text_unflexible_0').show()
                }else{
                //     var date = $('#chosen_date_'+type).val()
                // update_date(date, type)
                    $('#panel').hide()
                    $('#text_flexible_0').show()
                    $('#text_unflexible_0').hide()
                }
            })
        })

        $(function() {
            $('#test2').click(function() { // when a .myDiv is clicked
                if(this.checked) {
                    $('#panel1').show()
                    $('#text_flexible_1').hide()
                    $('#text_unflexible_1').show()
                }else{
                    //     var date = $('#chosen_date_'+type).val()
                    // update_date(date, type)
                    $('#panel1').hide()
                    $('#text_flexible_1').show()
                    $('#text_unflexible_1').hide()
                }
            })
        })
    });

    function select_kit(kit_kind) {
        $('.div-color1').removeClass('active32');
        $('#'+kit_kind+'_box').addClass('active32');
        $('#kit').val(kit_kind);
    }

    function shw(type) {
        if(this.checked) {
            $('#panel').show()
     
        }else{
            var date = $('#chosen_date_'+type).val()
        update_date(date, type)

        }
        
    };

    function update_date_only(type) {
        var date = $('#chosen_date_'+type).val()
        update_date(date, type)
    }

    function update_date_time(type) {
        $('#modalPoll-'+type).modal('hide')
        var start_time = $('#chosen_start_time_'+type).val()
        var end_time = $('#chosen_end_time_'+type).val()
        var date = $('#chosen_date_'+type).val()
        if (start_time == '' || end_time == '') {
            update_date(date, type)
        } else {
            $.ajax({
                url: "/save_shuffle_date_time/" + '{{$booking->booking_id}}',
                type: 'GET',
                dataType: 'json',
                data: {
                    date: date,
                    type: type,
                    start_time: start_time,
                    end_time: end_time
                },
                success: function(data, textStatus) {
                    if (textStatus === 'success') {
                        if (data.pickup_date != '') {
                            $('.pickup_dates').removeClass('shadow-date ');
                            $('#td_pickup_' + data.pickup_date).addClass('shadow-date ');
                        }
                        if (data.dropoff_date != '') {
                            $('.dropoff_dates').removeClass('shadow-date ');
                            $('#td_dropoff_' + data.dropoff_date).addClass('shadow-date ');
                        }
                        if (data.count >= 2) {
                            var pickup_charge = 0;
                            var dropoff_charge = 0;
                            if (data.pickup_date != "") {
                                pickup_charge = parseFloat($('#td_pickup_' + data.pickup_date + ' .pickup_charge').html().replace(/,/g, ""));
                            }
                            if (data.dropoff_date != "") {
                                dropoff_charge = parseFloat($('#td_dropoff_' + data.dropoff_date + ' .dropoff_charge').html().replace(/,/g, ""));
                            }
                            console.log(pickup_charge);
                            console.log(dropoff_charge);
                            total_charge = pickup_charge + dropoff_charge + parseFloat(data.insurance_price);
                            $('#total_charge_show').html('Charges $' + total_charge);
                            $('#total_charge').val(total_charge);
                            $('#total_price').html(total_charge.toFixed(2));
                            $('#price-part').show();
                        }
                    }
                }
            });
        }
    }

    function update_date(date, type) {
        $.ajax({
            url: "/save_shuffle_date/" + '{{$booking->booking_id}}' + "/" + date + "/" + type,
            type: 'GET',
            dataType: 'json',
            data: {
                date: date,
                type: type
            },
            success: function(data, textStatus) {
                if (textStatus === 'success') {
                    if (data.pickup_date != '') {
                        $('.pickup_dates').removeClass('shadow-date ');
                        $('#td_pickup_' + data.pickup_date).addClass('shadow-date ');
                    }
                    if (data.dropoff_date != '') {
                        $('.dropoff_dates').removeClass('shadow-date ');
                        $('#td_dropoff_' + data.dropoff_date).addClass('shadow-date ');
                    }
                    if (data.count >= 2) {
                        var pickup_charge = 0;
                        var dropoff_charge = 0;
                        if (data.pickup_date != "") {
                            pickup_charge = parseFloat($('#td_pickup_' + data.pickup_date + ' .pickup_charge').html().replace(/,/g, ""));
                        }
                        if (data.dropoff_date != "") {
                            dropoff_charge = parseFloat($('#td_dropoff_' + data.dropoff_date + ' .dropoff_charge').html().replace(/,/g, ""));
                        }
                        console.log(pickup_charge);
                        console.log(dropoff_charge);
                        total_charge = pickup_charge + dropoff_charge;
                        $('#total_charge_show').html('Charges $' + total_charge);
                        $('#total_charge').val(total_charge);
                        $('#total_price').html(total_charge);
                        $('#price-part').show();
                    }
                }
            }
        });
    }

    function update_you_pay(ins_type, cal_type, item_id, ratio) {
        var val = 0;
        if (cal_type == '+') {
            val = parseInt($('#' + ins_type + '_' + item_id).val()) + 1;
            if (val > 0) {
                $('#' + ins_type + '_' + item_id).val(val);
            } else {
                $('#' + ins_type + '_' + item_id).val(0);
            }
        } else {
            val = parseInt($('#' + ins_type + '_' + item_id).val()) - 1;
            if (val > 0) {
                $('#' + ins_type + '_' + item_id).val(val);
            } else {
                $('#' + ins_type + '_' + item_id).val(0);
            }
        }
        $('#' + ins_type + '_show_' + item_id).html($('#' + ins_type + '_' + item_id).val());

        var val2 = 0
        if (cal_type == '+')
            val2 = parseFloat($('#' + ins_type + '_you_pay').val()) + 1
        else
            val2 = parseFloat($('#' + ins_type + '_you_pay').val()) - 1
        $('#' + ins_type + '_you_pay').val(val2)
        $('#' + ins_type + '_you_pay_show').html('You Pay: $' + val2);
        $('#' + ins_type + '_we_cover').val(parseFloat(val2) * ratio);
        $('#' + ins_type + '_we_cover_show').html('We Cover: $' + (val2 * ratio));
    }

    function get_insurance(ins_type) {
        $('#insurance_charges').val($('#'+ins_type+'_you_pay').val());
        $('#total_charges_val').val(parseFloat($('#total_charge').val()) + parseFloat($('#insurance_charges').val()))
        $('#ins_charge_show').html('$'+$('#'+ins_type+'_you_pay').val());
        $('#insurance_modal').modal('hide');
        $('#insurance_type').html('('+ins_type+')')
        $('#total_price').html((parseFloat($('#total_charge').val()) + parseFloat($('#insurance_charges').val())));
    }

    $('#SAveBooking').click(function(){
       $('#saveBookingmodel').modal('show'); 
    })

    $('#saveBookinfff').click(function(){
       $('#saveBookinfffmodel').modal('show'); 
    })
    $('#remindLater').click(function(){
       $('#remindLater_modal').modal('show'); 
         $('.ui-datepicker').css('z-index','9999');
         
    })

    $('#demo').datetimepicker({
        baseCls: "perfect-datetimepicker", 
        viewMode: $.fn.datetimepicker.CONSTS.VIEWMODE.YMD, // see below
        firstDayOfWeek: 0, // 0 = sunday
        date: new Date(), //initial date
        endDate: null, //end date
        startDate: null, //start date
        language: 'en', //I18N
        //date update event
        onDateChange: function(){
            $('#dateREmnd').val(this.getText('YYYY-MM-DD'));
        },
        //clear button click event
        onClear: null,
        //ok button click event
        onOk: null,
        //close button click event
        onClose: null,
        //today button click event
        onToday: null
    });

    function show_month_left(step,month)
    {
        if(step == '>')
        {
            next = parseInt(month)+1;
            $("#month_"+month+"_left").hide();
            $("#month_"+next+"_left").show();
        }
        if(step == '<')
        {
            last = parseInt(month)-1;
            $("#month_"+month+"_left").hide();
            $("#month_"+last+"_left").show();
        }
    }

    function show_month_right(step,month)
    {
        if(step == '>')
        {
            next = parseInt(month)+1;
            $("#month_"+month+"_right").hide();
            $("#month_"+next+"_right").show();
        }
        if(step == '<')
        {
            last = parseInt(month)-1;
            $("#month_"+month+"_right").hide();
            $("#month_"+last+"_right").show();
        }
    }

    $("#slider-range-0").slider({
        range: true,
        min: 360,
        max: 1260,
        step: 15,
        values: [360, 1260],
        slide: function (e, ui) {
            var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);

            if (hours1.length == 1) hours1 = '0' + hours1;
            if (minutes1.length == 1) minutes1 = '0' + minutes1;
            if (minutes1 == 0) minutes1 = '00';
            if (hours1 >= 12) {
                if (hours1 == 12) {
                    hours1 = hours1;
                    minutes1 = minutes1 + " PM";
                } else {
                    hours1 = hours1 - 12;
                    minutes1 = minutes1 + " PM";
                }
            } else {
                hours1 = hours1;
                minutes1 = minutes1 + " AM";
            }
            if (hours1 == 0) {
                hours1 = 12;
                minutes1 = minutes1;
            }



            $('.slider-time-0').html(hours1 + ':' + minutes1);
            $('#chosen_start_time_0').val(hours1 + ':' + minutes1)

            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);

            if (hours2.length == 1) hours2 = '0' + hours2;
            if (minutes2.length == 1) minutes2 = '0' + minutes2;
            if (minutes2 == 0) minutes2 = '00';
            if (hours2 >= 12) {
                if (hours2 == 12) {
                    hours2 = hours2;
                    minutes2 = minutes2 + " PM";
                } else if (hours2 == 24) {
                    hours2 = 11;
                    minutes2 = "59 PM";
                } else {
                    hours2 = hours2 - 12;
                    minutes2 = minutes2 + " PM";
                }
            } else {
                hours2 = hours2;
                minutes2 = minutes2 + " AM";
            }

            $('.slider-time2-0').html(hours2 + ':' + minutes2);
            $('#chosen_end_time_0').val(hours2 + ':' + minutes2)
        }
    });

    $("#slider-range-1").slider({
        range: true,
        min: 360,
        max: 1260,
        step: 15,
        values: [360, 1260],
        slide: function (e, ui) {
            var hours1 = Math.floor(ui.values[0] / 60);
            var minutes1 = ui.values[0] - (hours1 * 60);

            if (hours1.length == 1) hours1 = '0' + hours1;
            if (minutes1.length == 1) minutes1 = '0' + minutes1;
            if (minutes1 == 0) minutes1 = '00';
            if (hours1 >= 12) {
                if (hours1 == 12) {
                    hours1 = hours1;
                    minutes1 = minutes1 + " PM";
                } else {
                    hours1 = hours1 - 12;
                    minutes1 = minutes1 + " PM";
                }
            } else {
                hours1 = hours1;
                minutes1 = minutes1 + " AM";
            }
            if (hours1 == 0) {
                hours1 = 12;
                minutes1 = minutes1;
            }



            $('.slider-time-1').html(hours1 + ':' + minutes1);
            $('#chosen_start_time_1').val(hours1 + ':' + minutes1)

            var hours2 = Math.floor(ui.values[1] / 60);
            var minutes2 = ui.values[1] - (hours2 * 60);

            if (hours2.length == 1) hours2 = '0' + hours2;
            if (minutes2.length == 1) minutes2 = '0' + minutes2;
            if (minutes2 == 0) minutes2 = '00';
            if (hours2 >= 12) {
                if (hours2 == 12) {
                    hours2 = hours2;
                    minutes2 = minutes2 + " PM";
                } else if (hours2 == 24) {
                    hours2 = 11;
                    minutes2 = "59 PM";
                } else {
                    hours2 = hours2 - 12;
                    minutes2 = minutes2 + " PM";
                }
            } else {
                hours2 = hours2;
                minutes2 = minutes2 + " AM";
            }

            $('.slider-time2-1').html(hours2 + ':' + minutes2);
            $('#chosen_end_time_1').val(hours2 + ':' + minutes2)
        }
    });

        $('#button-1').click(function(e) {
            e.preventDefault();
            $('#kit-selection').modal('show')
        })

    // location updating functionalities
    let s_input = document.getElementById('start');
    let d_input = document.getElementById('end');

    let autocomplete_source = new google.maps.places.Autocomplete(s_input);
    let autocomplete_destination = new google.maps.places.Autocomplete(d_input);
    let geocoder = new google.maps.Geocoder();

    autocomplete_source.addListener('place_changed', function(event) {
        let place = autocomplete_source.getPlace();
        $("#lat_1").val(place.geometry.location.lat());
        $("#lng_1").val(place.geometry.location.lng());

        geocoder.geocode({
            'latLng': new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng())
        }, async function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if(results[0]) {
                    for (let i = 0; i < results[0].address_components.length; i++) {
                        let types = results[0].address_components[i].types;
                        for (let typeIdx = 0; typeIdx < types.length; typeIdx++) {
                            if (types[typeIdx] == 'postal_code') {
                                $('#zip_code_1').val(results[0].address_components[i].short_name);
                            }
                        }
                    }
                }
            }
        })
    });

    autocomplete_destination.addListener('place_changed', function(event) {
        let place = autocomplete_destination.getPlace();
        $("#lat_2").val(place.geometry.location.lat());
        $("#lng_2").val(place.geometry.location.lng());

        geocoder.geocode({
            'latLng': new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng())
        }, async function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if(results[0]) {
                    for (let i = 0; i < results[0].address_components.length; i++) {
                        let types = results[0].address_components[i].types;
                        for (let typeIdx = 0; typeIdx < types.length; typeIdx++) {
                            if (types[typeIdx] == 'postal_code') {
                                $('#zip_code_2').val(results[0].address_components[i].short_name);
                            }
                        }
                    }
                }
            }
        })
    });

    function edit_location(id) {
        $("#btn_edit_location"+id).hide();
        $("#btn_save_location"+id).show();
        $("#btn_cancel_location"+id).show();

        $("#loc_"+(id+1)).hide();
        $("#loc_"+(id+1)+"_edit").fadeIn();
    }

    function update_location(id)
    {
        Notiflix.Loading.Hourglass('Loading...');
        var postData = $("#frm_save_location").serializeArray();
        var formURL = $("#frm_save_location").attr("action");
        
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data: postData,
            success:function(data, textStatus, jqXHR) {
                // TODO:: should be done without reloading
                location.reload()
            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
        
    }

    function cancel_location(id)
    {
        $("#btn_save_location"+id).hide();
        $("#btn_cancel_location"+id).hide();
        $("#btn_edit_location"+id).show();

        $("#loc_"+(id+1)).fadeIn();
        $("#loc_"+(id+1)+"_edit").hide();
    }

    $(document).ready(function(){
        // Add down arrow icon for collapse element which is open by default
        $(".collapse.show").each(function(){
            $(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
        });
        
        // Toggle right and down arrow icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
            $(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
        }).on('hide.bs.collapse', function(){
            $(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });

    function removeItem(booking_item_id, i) {
        let booking_id = '{{$booking->booking_id}}'
        let insurance_price = parseFloat($('#ins_charge_show').html().replace('$', ''))
        Notiflix.Loading.Hourglass('Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/remove_item_preview/"+booking_id,
            type: 'POST',
            data: {booking_item_id, insurance_price},
            success: function(data) {
                let current_sto_price = parseFloat($('.sto_'+i).html())
                let current_pickup_price = parseFloat($('.pickup_price_'+i).html())
                let current_dropoff_price = parseFloat($('.dropoff_price_'+i).html())
                let current_item_price = parseFloat(current_pickup_price + current_dropoff_price)
                let current_total_price = parseFloat($('#total_price').html())
                let current_total_sto_price = parseFloat($('#total_sto_price').html())
                let current_total_pickup_price = parseFloat($('.total_pickup_price').html())
                let current_total_dropoff_price = parseFloat($('.total_dropoff_price').html())
                $('#item_row_'+i).remove()
                $('#total_price').html(parseFloat(current_total_price - current_item_price - current_sto_price).toFixed(2))
                $('#total_sto_price').html(parseFloat(current_total_sto_price - current_sto_price).toFixed(2))
                $('.total_pickup_price').html(parseFloat(current_total_pickup_price - current_pickup_price).toFixed(2))
                $('.total_dropoff_price').html(parseFloat(current_total_dropoff_price - current_dropoff_price).toFixed(2))
                Notiflix.Loading.Remove();
            }
        })
    }

    function decreaseQty(booking_item_id, i) {
        if (parseInt($('.qty_'+i).html()) != 0) {
            let booking_id = '{{$booking->booking_id}}'
            Notiflix.Loading.Hourglass('Loading...');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/update_qty_item_preview/"+booking_id,
                type: 'POST',
                data: {booking_item_id, type: '-'},
                success: function(data) {
                    let current_qty = parseInt($('.qty_'+i).html())
                    let current_sto_price = parseFloat($('.sto_'+i).html())
                    $('.qty_'+i).html(current_qty-1)
                    $('.sto_'+i).html(parseFloat(current_sto_price - (current_sto_price / current_qty)).toFixed(2))

                    let current_pickup_price = parseFloat($('.pickup_price_'+i).html())
                    let current_dropoff_price = parseFloat($('.dropoff_price_'+i).html())
                    $('.pickup_price_'+i).html(parseFloat(current_pickup_price - (current_pickup_price / current_qty)).toFixed(2))
                    $('.dropoff_price_'+i).html(parseFloat(current_dropoff_price - (current_dropoff_price / current_qty)).toFixed(2))

                    let current_total_pickup_price = parseFloat($('.total_pickup_price').html())
                    let current_total_dropoff_price = parseFloat($('.total_dropoff_price').html())
                    $('.total_pickup_price').html(parseFloat(current_total_pickup_price - (current_pickup_price / current_qty)).toFixed(2))
                    $('.total_dropoff_price').html(parseFloat(current_total_dropoff_price - (current_dropoff_price / current_qty)).toFixed(2))

                    let current_total_price = parseFloat($('#total_price').html())
                    let current_total_sto_price = parseFloat($('#total_sto_price').html())
                    $('#total_price').html(parseFloat(current_total_price - (current_sto_price / current_qty) - (current_pickup_price / current_qty) - (current_dropoff_price / current_qty)).toFixed(2))
                    $('#total_sto_price').html(parseFloat(current_total_sto_price - (current_sto_price / current_qty)).toFixed(2))
                    Notiflix.Loading.Remove();
                },
            })
        }
    }

    function increaseQty(booking_item_id, i) {
        let booking_id = '{{$booking->booking_id}}'
        Notiflix.Loading.Hourglass('Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/update_qty_item_preview/"+booking_id,
            type: 'POST',
            data: {booking_item_id, type: '+'},
            success: function() {
                let current_qty = parseInt($('.qty_'+i).html())
                let current_sto_price = parseFloat($('.sto_'+i).html())
                $('.qty_'+i).html(current_qty+1)
                $('.sto_'+i).html(parseFloat(current_sto_price + (current_sto_price / current_qty)).toFixed(2))

                let current_pickup_price = parseFloat($('.pickup_price_'+i).html())
                let current_dropoff_price = parseFloat($('.dropoff_price_'+i).html())
                $('.pickup_price_'+i).html(parseFloat(current_pickup_price + (current_pickup_price / current_qty)).toFixed(2))
                $('.dropoff_price_'+i).html(parseFloat(current_dropoff_price + (current_dropoff_price / current_qty)).toFixed(2))

                let current_total_pickup_price = parseFloat($('.total_pickup_price').html())
                let current_total_dropoff_price = parseFloat($('.total_dropoff_price').html())
                $('.total_pickup_price').html(parseFloat(current_total_pickup_price + (current_pickup_price / current_qty)).toFixed(2))
                $('.total_dropoff_price').html(parseFloat(current_total_dropoff_price + (current_dropoff_price / current_qty)).toFixed(2))

                let current_total_price = parseFloat($('#total_price').html())
                let current_total_sto_price = parseFloat($('#total_sto_price').html())
                $('#total_price').html(parseFloat(current_total_price + (current_sto_price / current_qty) + (current_pickup_price / current_qty) + (current_dropoff_price / current_qty)).toFixed(2))
                $('#total_sto_price').html(parseFloat(current_total_sto_price + (current_sto_price / current_qty)).toFixed(2))
                Notiflix.Loading.Remove();
            }
        })
    }
</script>
@endsection