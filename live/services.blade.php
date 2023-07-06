@extends('user.layout.app')

@section('styles')
    <style>
        body {
            margin: 0;
            /*font-family:lulo-clean-w01-one-bold,sans-serif;*/
            background-color: #ffc81c;
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

        /* START HEADER*/
        .topnav {
            overflow: hidden;
            background-color: #20374f;
            padding-top: 15px;
            padding-bottom: 5px;
        }

        .logo {
            float: left;
            /*margin-top: 18px;*/
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            padding: 0px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #4CAF50;
            color: white;
        }

        .topnav .icon {
            display: none;
        }

        .navbar-right {
            float: right;
            margin-top: 20px;
        }

        /*END HEADER*/
        /*.text-center{*/
        /*    margin-top: 45px;*/
        /*}*/
        /*START HEADING*/
        .heading h1 {
            letter-spacing: 7px;
            line-height: 1.5;
            text-align: center;
            color: #20374f;
            font-family: lulo-clean-w01-one-bold, sans-serif;
            font-weight: 100;
            font-size: 34px;
            margin-top: 30px;
            margin-bottom: 30px;
            font-weight: 800;
            margin-bottom: 50px;
            margin-top: 50px;
        }

        .heading p {
            text-align: center;
            color: #20374f;
            font-family: "Times New Roman";
            font-weight: 100;
            font-size: 25px;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .booking {
            text-align: center;
            color: #20374f;
            font-family: "Times New Roman";
            font-weight: 100;
            font-size: 39px;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        /*END HEADING*/

        /*STARTS SLIDER DETAILS*/
        .ca-item {
            transition: transform .2s;
            height: 300px !important;
            width: 300px !important;

        }

        .ca-item-main {
            background-color: #aa0114;
            padding: 5px;
            border-radius: 15px 15px 15px 15px;
        }

        .ca-item-main img {
            width: 100px;
            border-radius: 50%;
            margin-top: 30px;
            margin-left: 100px;
        }

        .firstlocation {
            background-color: #20374f;
            border: solid 4px #aa0114;
            color: white;
        }

        .idont {
            color: #20374f;
        }

        .box {
            text-align: center;
        }

        .ca-item h3 {

            color: #ffffff;
        }

        .ca-item p {
            color: #ffffff;
        }

        .custom {

            margin-left: 145px;
            width: 990px;
            padding: 0px;
        }

        .ca-nav {
            height: 75px;
        }

        /*ENDS SLIDER DETAILS*/

        .pickup-details h4 {
            font-family: lulo-clean-w01-one-bold, sans-serif;
            font-size: 25px;
            font-weight: 600;
        }

        .end-buttons {
            margin-right: 75px;
        }

        .arrows {
            color: #20374f;
            font-size: 25px !important;
            margin-top: 4px;
            border: none !important;
        }

        .fa {
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .item-img {
            font-family: inherit;
            font-size: 25px;
            margin-top: 11px;
            margin-left: 20px;

        }

        .boxex {
            /*border-top-right-radius: 80px 100px;*/
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            background-color: #20374f;
            color: white;
            height: 125px;
            margin-top: -112px;
            z-index: 1;
            position: relative;
            padding-left: 10px;
            text-align: left;
            padding-top: 5px;
        }

        .my-custom-active {
            -webkit-box-shadow: 0px 0px 17px -2px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 0px 17px -2px rgba(0, 0, 0, 0.75);
            box-shadow: 0px 0px 17px -2px rgba(0, 0, 0, 0.75);
            transition: transform .9s;
            transform: scale(0.9);
        }

        /*BOOKING*/

        .bedroom-field {
            border: 4px solid #aa0114;
            border-radius: 25px;
            background-color: #20374f;
            height: 59px;
            color: white;

        }

        .bedroom-field i {
            color: white;
            font-size: 25px !important;
            padding: 18px;
            height: 100%;
            border: none !important;
            border-radius: 50%;
            background-color: black;
            padding-top: 14px;
            margin-left: -16px;
        }

        .field {
            padding: 0px;
            /* padding-right: 0px; */
            width: 335px;
        }

        .total {
            border: 4px solid #bb1b1b;
            background-color: #20374f;
            border-radius: 7px;
            padding-top: 7px;
            color: white;

        }

        .total-4 {
            text-align: right;
        }

        /*Quantity BUttons*/
        button {
            margin: 4px;
            cursor: pointer;
        }

        input {
            text-align: center;
            width: 40px;
            margin: 4px;
            color: salmon;
            margin-right: -9px;
        }

        .quantity-buttons {
            margin-top: -45px;
            text-align: right;
        }

        .sub {
            margin-right: -10px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .add {
            padding-bottom: 0px;
            padding-top: 0px;
            padding-left: 3px;
            padding-right: 3px;
        }

        .index-slider {
            background-color: #20374f;
            border: solid 4px #aa0114;
        }

        .book-tab {
            margin-bottom: 20px;
        }

        .hr {
            color: gray;
        }

        .add-button {
            word-spacing: 3px;
            letter-spacing: 2px;
            background-color: #aa0114;
            border: none;
            padding-left: 25px;
            border-radius: 7px;
            padding-right: 25px;
            margin-left: -33px;
            /*margin-left: 24px;*/
        }

        .add-item {
            margin-left: 24px;
            background-color: #aa0114;
        }

        .back {
            background-color: #aa0114;
        }

        .continue {
            background-color: #aa0114;
        }

        .text {
            margin-top: 30px;
        }

        .calender {
            margin-right: 5px;
        }

        .section {
            border: solid 4px #c71515 !important;
            /*background-color:#f7f7f7;*/
            background-color: #20374f;
            color: white;
            border: 15px 15px 15px 15px;
        }

        .wap-form-edit {
            border: solid 2px #aa0114;
            background-color: #aa0114;
            color: #ffffff;
        }

        .end-buttons {
            text-align: right;
        }

        .iconic {
            margin-left: 75%;
        }

        /* The container */

        .btn span.glyphicon {
            opacity: 0;
        }

        .btn.active span.glyphicon {
            opacity: 1;
        }

        .h6 {
            margin-top: 8px;
        }

        /* MEDIA QURIES START HERE*/

        @media screen and (max-width: 780px) {
            .topnav a:not(:first-child) {
                display: none;
            }

            .topnav a.icon {
                float: right;
                display: block;
            }
        }

        @media screen and (max-width: 780px) {
            .topnav.responsive {
                position: relative;
            }

            .topnav.responsive .icon {
                position: absolute;
                right: 0;
                top: 0;
            }

            .topnav.responsive a {
                float: none;
                display: block;
                text-align: left;
            }

            .navbar-right {
                float: left;
            }

            .signup {
                display: none;
            }

            .show-arrow {
                margin-top: 50px;
            }
        }
    </style>
@endsection

@section('content')

    <!--ENDS HEADING-->
    <!--STARTS SLIDER-->

    <!--END SLIDERS-->

    <!--SEARCH BAR STARTS-->
    <form action="/" id="formLocation" method="post">
        {{ csrf_field() }}

        <div class="heading">
            <h1>SERVICE TYPE</h1>
        </div>

        <input type="hidden" name="serviceType" id="service" data-val="{{ $dataSelected }}" value="{{ $selected }}">

        <div class="container">
            <div class="row">
                @foreach($services as $service)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12" style="padding: 10px !important;">
                        <div class="ca-item-main {{ ($service->name == $selected) ? 'my-custom-active' : null }}">
                            <img class="card-img-top" src="{{ $service->image }}" alt="Avatar"
                                 style="width: 100%;border-radius: 5%;margin-top: 0px;margin-left: 0px;height: 290px;">
                            <div class="card-body boxex">
                                <h3 data-val="{{ $service->type }}">{{ $service->name }}</h3>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="footer">
            <div class="row container-fluid">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">

                    <button type="submit" class="my-2 btn-footer pull-right"
                            style="background-color: #aa0114 !important;width: 130px;height: 40px;border: none !important;color: white;">
                        Continue
                    </button>

                </div>
            </div>
        </div>

        <!--SAVE AND BACK BUTTONS-->
    </form>

    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Mode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="opt1" class="radio">
                                <input type="radio" name="mode" id="opt1" hidden class="hidden"/>
                                <span class="label"></span> I am picking up
                            </label>
                        </div>
                        <div class="col-md-12">
                            <label for="opt2" class="radio">
                                <input type="radio" name="mode" id="opt2" hidden class="hidden"/>
                                <span class="label"></span> I need to be picked up
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="handleRedirect()" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script>
        let formSubmit = false;
	    function handleRedirect() {
	    	let val = $("#opt1").prop('checked');
		    if (val){
		    	formSubmit = true;
		    	$("#formLocation").submit();
		    	return;
            }

		    window.location.href = '{{ route('login') }}'
	    }

		$(function () {

			$('.ca-item-main').on('click', function (event) {
				$(".my-custom-active").removeClass("my-custom-active");
				let me = $(event.currentTarget);
				let selector = me.find('h3');
				let val = selector.text();
				let dataVal = selector.data('val');
				let input = $("#service");
				input.val(val);
				input.data('val', dataVal);
				me.addClass("my-custom-active");
			});

			$("#formLocation").on('submit', function (evt) {
				if (!formSubmit){
					evt.preventDefault();
					let input = $("#service");
					console.log(input);
					let dataVal = input.data('val');
					if (dataVal === 'Storage') {
						$(".modal").modal();
					}else{
if (dataVal){
                      formSubmit = true;
		    	$("#formLocation").submit();
		    	return;
		   
	    //	let val = $("#opt1").prop('checked');
		 //   if (val==false){
		   // 	formSubmit = true;
		    //	$("#formLocation").submit();
		    	//return;
		    	// window.location.href = 'http://thesiriussolutions.com/Relo/map';
		   // 	return;
          //  }

		   
}else{
	
	window.location.href = '{{ route('login') }}'
	
}
           

					}  
				}
			});
		});
    </script>

@endsection
