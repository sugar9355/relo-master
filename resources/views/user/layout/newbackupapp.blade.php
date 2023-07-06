<!DOCTYPE html>
<html lang="en">
<head>
    <title>Location Details</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
</head>

<body>
<!--START HEADER-->
<div class="topnav" id="myTopnav">
    <a href="/" class="logo"><img class="img-responsive logo" src="{{ asset('asset/img/Capture.png') }}" height="70" width="120"></a>
    <div style="display: none">
        <a href="#home">Payment</a>
        <a href="#news">Past</a>
        <a href="#contact">Creadit</a>
        <a href="#about">FAQ</a>
        <a href="#about">Contact Us</a>
    </div>
    <a href="javascript:void(0);" class="icon" onclick="navbarfunction()"><i class="fa fa-bars"></i></a>
    @if(!Auth::user())
        <div class="navbar-right">
            <a href="/register" class="signup"> Sign Up</a>
            <a href="/login">Login</a>
        </div>
    @else:
    <div class="iconic">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="icons"><i class="fa fa-power-off"></i></a>
        <a href="/" class="icons"><i class="fa fa-user"></i></a>
    </div>
    @endif
</div>
<!--END HEADER-->

<div class="content">
    @yield('content')
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="{{asset('asset/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('main/vendor/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script type="text/javascript" src="{{asset('main/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('asset/js/map-autocomplete.js')}}"></script>
</body>
</html>
