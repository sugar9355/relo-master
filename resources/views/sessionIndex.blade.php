@extends('user.layout.app')

@section('content')
    <div>
        <div class="heading">
            <h1>Type Of Services</h1>
        </div>
    </div>
    <!--ENDS HEADING-->
    <!--STARTS SLIDER-->
    <div class="container">
        <div class="row">
            <div class="my-owl-one owl-carousel owl-theme">

                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/Layer1.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3> Small Move</h3>
                                <p> <span>An Easy Way<br> To Move 1 or 2 Item.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/Layer2.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3>Store Pickup & Delivery</h3>
                                <p> <span>Get Your Purchase Home.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/small-move-blog.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3>No Truck, Labour Only</h3>
                                <p> <span>No Truck but a tun of muscle.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/Layer1.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3> Small Move</h3>
                                <p> <span>An Easy Way<br> To Move 1 or 2 Item.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/Layer2.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3>Store Pickup & Delivery</h3>
                                <p> <span>Get Your Purchase Home.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item box">
                    <div class="ca-item">
                        <div class="ca-item-main">
                            <img src="{{ asset('asset/img/small-move-blog.png') }}" alt="Avatar" style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="boxex">
                                <h3>No Truck, Labour Only</h3>
                                <p> <span>No Truck but a tun of muscle.</span> </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--END SLIDERS-->
    <!--HEADING-->
    <div>
        <div class="heading">
            <h1>Add Location</h1>
        </div>
    </div>

    <!--SEARCH BAR STARTS-->
    <form action="location/store" id="formLocation" method="post">
        {{ csrf_field() }}
        <div class="col-md-12 form-row container justify-content-center">
            <div class="col-4">
                <input type="text" class="form-control firstlocation" id="start" name="s_address" value="{{ $locationDetail->s_address }}" placeholder="First Location" />
                <input type="hidden" id="s_lat" name="s_lat" value="{{ $locationDetail->s_lat }}">
                <input type="hidden" id="s_lng" name="s_lng" value="{{ $locationDetail->s_lng }}">
            </div>
            <div class="">
                <i class="btn border iconcolor fa fa-exchange arrows"></i>
            </div>
            <div class="col-4">
                <input type="text" class="form-control firstlocation" id="end" name="d_address" value="{{ $locationDetail->d_address }}" placeholder="Second Location" />
                <input type="hidden" id="d_lat" name="d_lat" value="{{ $locationDetail->d_lat }}">
                <input type="hidden" id="d_lng" name="d_lng" value="{{ $locationDetail->d_lng }}">
            </div>
            <div class="">
                <i class="btn border iconcolor fa fa-calendar arrows calender"></i>
            </div>
            <div class="">
                <i class="btn border iconcolor fa fa-search arrows"></i>
            </div>
        </div>
        <!--END SEARCH BAR -->

        <!--ADD LOCATION DETAILS STARTS -->
        <div class="form">
            <div class="col-12 text-center">
                <a href="/shop?location=no"><u> I don't know my location yet</u></a>
            </div>
        </div>
        <div class="">
            <div class="col-12 text-center text">
                <p>We won't share your exact location until your small haul movers' scheduled with a helper</p>
            </div>
        </div>
        <div>
            <div class="heading">
                <h1>Location Details</h1>
            </div>
        </div>
        <!--ADD LOCATION ENDS-->
        <!--LOCATION DETAILS BOX STARTS-->
        <input type="hidden" id="distance" name="distance">
        <div class="container">
            <div class="row">
                <section class="border section col-md-10 offset-1">
                    <div class="form-row  form-group">
                        <div class="col-12 text-center pickup-details">
                            <h4>Pickup Details</h4>
                        </div>
                    </div>

                    <div class="form-row text-center justify-content-center form-group">
                        <h6 class="h6">
                            <label class="form-label">Unit and Apartment Number: &nbsp;</label>
                        </h6>
                        <div class="col-1">
                            <select class="form-control wap-form-edit" name="s_floor">
                                @for($i = 0; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ ($locationDetail->s_floor == $i) ? 'selected': null }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <div class="row">
                                <input type="checkbox" {{ isset($locationDetail->start_location_question1) ? 'checked': null }} name="start_location_question1" value="check" id="start_location_question1">
                                <label for="start_location_question1">Helper(s) needs to use stairs</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <b>A flight of stairs six or more steps separating a floor of a building. or from one outside grade to another, </b>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <div class="row">
                                <input type="checkbox" name="start_location_question2" {{ isset($locationDetail->start_location_question2) ? 'checked': null }} value="check" id="start_location_question2">
                                <label for="start_location_question2">Helper(s) can use elevator</label>
                            </div>
                            <div class="row">
                                <input type="checkbox" name="start_location_question3" {{ isset($locationDetail->start_location_question3) ? 'checked': null }} value="check" id="start_location_question3">
                                <label for="start_location_question3">Ride with Helper to next stop</label>
                            </div>
                            <div class="row">
                                <input type="checkbox" name="start_location_question4" {{ isset($locationDetail->start_location_question4) ? 'checked': null }} value="check" id="start_location_question4">
                                <label for="start_location_question4">Has Hardwood floors</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <h6>In the unlikely case of change we won't be able to process a claim on hardwood floors unless they are indicated here.</h6>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <textarea class="col-12" rows="3" id="start_detail_address" name="start_detail_address" placeholder="Add Your Detailed Address Here">{{ $locationDetail->start_detail_address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <textarea class="col-12" rows="3" id="start_location_note" name="start_location_note" placeholder="Parking and building info.">{{ $locationDetail->start_location_note }}</textarea>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="row">
                <section class="border section col-md-10 offset-md-1">

                    <div class="form-row  form-group">
                        <div class="col-12 text-center pickup-details">
                            <h4>Drop Off Details</h4>
                        </div>
                    </div>

                    <div class="form-row text-center justify-content-center form-group">
                        <h6>Unit and Apartment Number: &nbsp;</h6>
                        <div class="col-1">
                            <select class="form-control wap-form-edit" name="d_floor">
                                @for($i = 0; $i <= 20; $i++)
                                    <option value="{{ $i }}" {{ ($locationDetail->d_floor == $i) ? 'selected': null }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <div class="row">
                                <input type="checkbox" name="end_location_question1" {{ isset($locationDetail->end_location_question1) ? 'checked': null }} value="check" id="end_location_question1">
                                <label for="end_location_question1">Helper(s) needs to use stairs</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <b>A flight of stairs six or more steps separating a floor of a building. or from one outside grade to another,</b>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-8">
                            <div class="row">
                                <input type="checkbox" name="end_location_question2" {{ isset($locationDetail->end_location_question2) ? 'checked': null }} value="check" id="end_location_question2">
                                <label for="end_location_question2">Helper(s) can use elevator</label>
                            </div>
                            <div class="row">
                                <input type="checkbox" name="end_location_question3" {{ isset($locationDetail->end_location_question3) ? 'checked': null }} value="check" id="end_location_question3">
                                <label for="end_location_question3">Ride with Helper to next stop</label>
                            </div>
                            <div class="row">
                                <input type="checkbox" name="end_location_question4" {{ isset($locationDetail->end_location_question4) ? 'checked': null }} value="check" id="end_location_question4">
                                <label for="end_location_question4">Has Hardwood floors</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <h6>In the unlikely case of change we won't be able to process a claim on hardwood floors unless they are indicated here.</h6>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <textarea class="col-12" rows="3" id="end_detail_address" name="end_detail_address" placeholder="Add Your Detailed Address Here">{{ $locationDetail->end_detail_address }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-row  form-group">
                        <div class="col-1"></div>
                        <div class="col-10">
                            <div class="row">
                                <textarea class="col-12" rows="3" id="end_location_note" name="end_location_note" placeholder="Parking and building info.">{{ $locationDetail->end_location_note }}</textarea>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--LOCATION DETAILS BOX ENDS-->
        <!--SAVE AND BACK BUTTONS-->
        <div class="container">
            <div class="row justify-content-end end-buttons">
                <a href="javascript:;"  class="col-md-1 btn btn-danger back">Back</a>
                <a href="javascript:;" onclick="$('#formLocation').submit()" class="col-md-2 btn btn-danger back continue"> Save And Continue</a>
            </div>
        </div>
        <!--SAVE AND BACK BUTTONS-->
    </form>

@endsection

