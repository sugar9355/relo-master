<!DOCTYPE html>
<html lang="en">
<head>
    <title>Location Details</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('meta')
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
	<link rel="stylesheet" href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}"  type="text/css">
    @yield("styles")
	
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
	
</head>
<style>
  .drop_men{
    min-width: 7rem;

  }
   .nav_a{
    color:white!important;
    text-align: center
  }
  .navbar-collapse{
    background: #343A40;
  }
</style>
<body>
<!--START HEADER-->

<header>


    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
      <a class="navbar-brand" href="#"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse justify-content-end col-lg-10 text-center" id="navbarSupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link nav_a" href="{{ route('payment') }}">Payment</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav_a" href="#">Past</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav_a" href="#">Creadits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav_a" href="#">FAQ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav_a" href="#">Contact Us</a>
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
          <div class="dropdown-menu drop_men" aria-labelledby="navbarDropdownMenuLink">
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
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 1) breadcrumb__step--active @elseif($booking->step > 1) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/1" style="text-decoration: none;">Services</a>
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 2) breadcrumb__step--active @elseif($booking->step > 2) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/2" style="text-decoration: none;">Map</a>
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 4) breadcrumb__step--active @elseif($booking->step > 4) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/4" style="text-decoration: none;">Location</a>
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 5) breadcrumb__step--active @elseif($booking->step > 5) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/5" style="text-decoration: none;">Inventory</a>
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 6) breadcrumb__step--active @elseif($booking->step > 6) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/6" style="text-decoration: none;">Preview</a>
	<a class="breadcrumb__step @if(isset($booking->step) && $booking->step == 7) breadcrumb__step--active @elseif($booking->step > 7) bg-warning @endif col" href="/booking/{{ ($booking->booking_id) ?: null }}/7" style="text-decoration: none;">Summary</a>
@else
	<a class="breadcrumb__step  col"  style="text-decoration: none;">Services</a>
	<a class="breadcrumb__step  col"  style="text-decoration: none;">Map</a>
	<a class="breadcrumb__step  col"  style="text-decoration: none;">Location</a>
	<a class="breadcrumb__step  col"  style="text-decoration: none;">Inventory</a>
  <a class="breadcrumb__step  col"  style="text-decoration: none;">Preview</a>
  <a class="breadcrumb__step  col"  style="text-decoration: none;">Summary</a>
@endif
				
        </div>
    </div></div>
@endif	
<section class="content">
    @yield('content')
</section>

<script src="https://maps.googleapis.com/maps/api/js?key={{ Setting::get('map_key') }}&libraries=places" type="text/javascript" ></script>

@yield("scripts")

<script type="text/javascript" src="{{asset('main/vendor/moment/moment.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trianglify/1.0.1/trianglify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
$(function() {
  var items = $(".inventory-item-mob");
  var numItems = items.length;
  var perPage = 5;

  items.slice(perPage).hide();

  $('#inventory-item-mob-container').pagination({
      items: numItems,
      itemsOnPage: perPage,
      prevText: "&laquo;",
      nextText: "&raquo;",
      onPageClick: function (pageNumber) {
          var showFrom = perPage * (pageNumber - 1);
          var showTo = showFrom + perPage;
          items.hide().slice(showFrom, showTo).show();
      }
  });
});
</script>

<!-- 
<script src="{{ asset('air-datepicker/dist/js/datepicker.min.js') }}"></script>
<script src="{{ asset('air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>
-->



</body>
</html>
