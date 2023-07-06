@extends("user.layout.app")

@section("styles")
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.3/css/base/jquery-ui.min.css">--}}
    <link rel="stylesheet" href="{{ asset("asset/css/newDesignStyle.css") }}">
    <link rel="stylesheet" href="{{ asset("noUiSlider/nouislider.css") }}">

    <style>
        #timeList {
            height: 100%;
            margin: 0;
            align-items: center;
        }

        /*Checkboxes styles*/
        .myCheckbox { display: none; }

        .myCheckbox + .myCheckboxLabel {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 20px;
            font: 14px/20px 'Open Sans', Arial, sans-serif;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .myCheckbox + .myCheckboxLabel:last-child { margin-bottom: 0; }

        .myCheckbox + .myCheckboxLabel:before {
            content: '';
            display: block;
            width: 20px;
            height: 20px;
            border: 1px solid #000000;
            position: absolute;
            left: 0;
            top: 0;
            opacity: .6;
            -webkit-transition: all .12s, border-color .08s;
            transition: all .12s, border-color .08s;
        }

        .myCheckbox:checked + .myCheckboxLabel:before {
            width: 10px;
            top: -5px;
            left: 5px;
            border-radius: 0;
            opacity: 1;
            border-top-color: transparent;
            border-left-color: transparent;
            -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
    <style>
        img {
            margin-left: 0px !important;
        }

        #time-range p {
            font-family: "Arial", sans-serif;
            font-size: 14px;
            color: #333;
        }

        .datepicker-inline {
            width: auto !important;
        }
    </style>
    <style type="text/css">
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

        #PickedTimeRange ul li {
            margin: 10px 0;
        }
    </style>
@endsection

@section("content")
    <form action="/drop_date" method="post" id="dateForm">
        {{ csrf_field() }}
        <div class="heading">
            <h1>SELECT DROP DATE & TIME</h1>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h5>
                        When would you like to move?
                    </h5>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 offset-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div class="dropdown">
                            <select name="date_type" onchange="changeTimeDatePref(this)" id="time_date" class="form-control">
                                <option value="FS">Flexible Date And Specific Time FS</option>
                                <option value="SF">Specific Date (Flexible Time) SF</option>
                                <option value="FF">Flexible Date (Flexible Time) FF</option>
                                <option value="SS">Specific Date And Time SS</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container newBox">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 text-center">
                    <center>
                        <div id="dateRange">
                            <h4 class="text-center my-3">Preferred Date</h4>
                            <div id="preferDate"></div>
                            <h4 class="text-center my-3">Secondary Date</h4>
                            <div class="daterangepicker"></div>
                        </div>
                        <div id="specificDate">
                            <div id="datepicker"></div>
                        </div>
                    </center>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <h2>Preference</h2>
                    <div id="specificTime">
                        <div id="specificPickedTime">
                            <span class="slider-specific-time">08:00 AM </span>
                        </div>
                        <div class="sliders_step1">
                            <div id="slider-specific"></div>
                        </div>
                    </div>
                    <div id="flexTime">
                        <div id="time-range">
                            <p>
                                Time Range:
                            </p>
                            <div id="PickedTimeRange">
                                <ul class="list-unstyled">
                                    <li class="py-2">
                                        <input type="checkbox" class="myCheckbox" value="Any Time" name="time_0[]" id="box-0-1">
                                        <label for="box-0-1" class="myCheckboxLabel">Any Time</label>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" class="myCheckbox" value="Morning" name="time_0[]" id="box-0-2">
                                        <label for="box-0-2" class="myCheckboxLabel">Morning</label>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" class="myCheckbox" value="Afternoon" name="time_0[]" id="box-0-3">
                                        <label for="box-0-3" class="myCheckboxLabel">Afternoon</label>
                                    </li>
                                    <li class="py-2">
                                        <input type="checkbox" class="myCheckbox" value="Evening" name="time_0[]" id="box-0-4">
                                        <label for="box-0-4" class="myCheckboxLabel">Evening</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="date" id="date">
                    <input type="hidden" name="prefer_date" id="preferDate" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="prefer_time" id="preferTime" value="Anytime">
                    <input type="hidden" name="time" id="time" value="8:00 AM">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cont-btn">
                    <button type="submit" id="dataFormBtn" class="btn-primary">Continue</button>
                </div>
            </div>
            <div class="modal fade" id="timeListModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Items</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 px-5" id="timeList">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="submitForm()" data-dismiss="modal">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section("scripts")
    <script src="{{ asset("noUiSlider/nouislider.js") }}"></script>
    <script src="{{ asset("js/wNumb.js") }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>

@endsection
