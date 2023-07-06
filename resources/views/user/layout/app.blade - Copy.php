<!DOCTYPE html>
<html lang="en">
<head>
    <title>Location Details</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="{{ asset('asset/font-awesome/css/all.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/hover-min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/animate.css') }}">    
    <link rel="stylesheet" href="{{ asset('main/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('air-datepicker/dist/css/datepicker.min.css') }}">

    @yield("styles")
</head>
<body>
<!--START HEADER-->

<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand clip-right-chevron" href="/">
        <img src="{{ asset('asset/img/Capture.png') }}" alt="Logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
	  
        <ul class="navbar-nav @if($booking->step == 5) text-white @endif">
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('payment') }}">Payment</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Past</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Creadits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
          </li>          
        </ul>

        @if(!Auth::user())
            <a class="btn btn-warning mx-md-2 clip-polygon-right login" href="/login">Sign In</a>
            <a class="btn btn-light mx-md-2 clip-polygon-right signup" href="/register">Sign Up</a>
          @else
          <div class="dropdown ml-lg-3">
            <a class="btn btn-warning dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Hi, {{ auth()->user()->first_name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" class="/trips" href="/dashboard">Overview</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">{{ csrf_field() }}</form>        
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout</a>
            </div>
          </div>
          @endif
      </div>
    </nav>
  </header>

@if(isset($page) && $page == 'dashboard')
	
@else
<div class="container-fluid">
    <div class="row text-center header-breadcumb">
        <div class="breadcrumb w-100 d-md-flex">
				
			@if(isset($booking->booking_id))
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 1) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/1" style="text-decoration: none;">Services</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 2) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/2" style="text-decoration: none;">Map</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 3) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/3" style="text-decoration: none;">Date & Time</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 4) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/4" style="text-decoration: none;">Location</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 5) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/5" style="text-decoration: none;">Shop</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 6) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/6" style="text-decoration: none;">Insurance</a>
				<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 7) breadcrumb__step--active @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/7" style="text-decoration: none;">Cart</a>
			@else
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Services</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Map</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Date & Time</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Location</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Shop</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Insurance</a>
				<a class="breadcrumb__step  col"  style="text-decoration: none;">Cart</a>
			@endif
				
            
        </div>
    </div></div>
@endif	
<section class="content">
    @yield('content')
</section>
<script>
    /*var $ = function (selector) {
        return document.querySelector(selector);
    };
    var $$ = function (selector) {
        return document.querySelectorAll(selector);
    };
    var breadcrumb = $('.breadcrumb');
    var breadcrumbSteps = $$('.breadcrumb__step');
    [].forEach.call(breadcrumbSteps, function (item, index, array) {
        item.onclick = function () {
            for (var i = 0, l = array.length; i < l; i++) {if (window.CP.shouldStopExecution(0)) break;
                if (index >= i) {
                    array[i].classList.add('breadcrumb__step--active');
                } else
                {
                    array[i].classList.remove('breadcrumb__step--active');
                }
            }window.CP.exitedLoop(0);
        };
    });*/

</script>

<link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets_admin/css/colors.min.css')}}" rel="stylesheet" type="text/css">

<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/ui/prism.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<!--script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="{{asset('asset/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@if(Request::segment(1) != "" && Request::segment(1) != "shop" && Request::segment(1) != "insurance" && Request::segment(1) != "date" && Request::segment(1) != "drop_date")
    <script src="{{ asset('materialize/js/materialize.min.js') }}"></script>
@endif
<script src="{{ asset('air-datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/1.0.1/trianglify.min.js"></script>


@yield("scripts")
</body>
</html>
