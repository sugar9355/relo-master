@extends("user.layout.app")

	  <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    
    <link href="{{asset('assets_admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/components.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/colors.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/extras/hover-min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets_admin/css/extras/animate.min.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
	
		
	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/sliders/ion_rangeslider.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/ui/moment/moment_locales.min.js')}}"></script>

	
	<script src="{{asset('assets_admin/js/demo_pages/extra_sliders_ion.js')}}"></script>
<style>
#time-range p {
    font-family:"Arial", sans-serif;
    font-size:14px;
    color:#333;
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
    content:"";
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
    outline:none;
}
</style>

@section("content")


<div class="container my-5">
         <h4 class="text-center animated fadeIn delay-0-2s">SELECT DATE & TIME</h4>
        <hr>
		@if(session()->get("msg") != '') 
			
			<div class="alert alert-danger">
			  <strong>Oops!</strong> {!! session()->get("msg") !!} 
			</div>
		
			@php session()->remove("msg"); @endphp
		
		@endif
		 @if (count($errors) > 0)
         <div class = "alert alert-danger">
            <ul>
               @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
               @endforeach
            </ul>
         </div>
      @endif

		<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
		
        {{ csrf_field() }}

            <div class="row">
                <div class="col-12 m-auto text-center mb-3">
                    <div class="card card-body bg-dark mb-3 animated fadeIn delay-0-5s">                        
                    <h5>
                        When would you like to move?
                    </h5>                
                  </div>
                </div>

             
            </div>

            <div id="dateRange">
			<input id="selector" value="0" type="hidden" >
			<div class="row mt-3">
                <div class="col-md-6" id="div_primary_date">
				<div id="preferDate" style="display:none;"></div>
                    <div class="card card-body animated fadeIn delay-0-6s" >
					
                        <h6 class="text-center">Preferred Date</h6>
                        
						<table class="table table-bordered">	
							<tr class="bg-info text-white">
								<th id="1"  class="text-center">MON</th>
								<th id="2"  class="text-center">TUE</th>
								<th id="3"  class="text-center">WED</th>
								<th id="4"  class="text-center">THU</th>
								<th id="5"  class="text-center">FRI</th>
								<th id="6"  class="text-center">SAT</th>
								<th id="7"  class="text-center">SUN</th>
							</tr>

							@foreach ($calender[2] as $k =>$week) 

							<tr>
							@foreach($week as $day) 
								<td id="td_{{$day}}" onclick="select_time({{$day}});">{{ ($day ? $day : '&nbsp;') }}</td>
							@endforeach
							</tr>

							@endforeach
						</table>
							
					</div>
				</div>
				
				<div class="col-md-6" id="div_secondary_date">
					

					<div class="card card-body ">
						<div id="time-range">
							<p>Time Range: <span class="slider-time">10:00 AM</span> - <span class="slider-time2">12:00 PM</span>

							</p>
							<div class="sliders_step1">
								<div class="slider-range"></div>
							</div>
						</div>
					</div>
					<div class="card card-body ">
						<div id="time-range">
							<p>Time Range: <span class="slider-time">10:00 AM</span> - <span class="slider-time2">12:00 PM</span></p>
							<div class="sliders_step1">
								<div class="slider-range"></div>
							</div>
						</div>
					</div>
								
				</div>

            </div>
            

			
		
			<div class="col-md-12 text-center">
                    <hr>
					<a href="/booking/{{ ($booking->booking_id) ?: null }}/2" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal"><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
					<button id="dataFormBtn" name="btn_submit" type="submit" value="3" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
				</div>
			</div>
		

		
    </form>
	

</div>
@endsection


@section("scripts")

	<script>	
	
	$(".slider-range").slider({
		range: true,
		min: 0,
		max: 1440,
		step: 15,
		values: [600, 720],
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



			$('.slider-time').html(hours1 + ':' + minutes1);

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

			$('.slider-time2').html(hours2 + ':' + minutes2);
		}
	});
	

	function select_time(id)
	{
		//$('#td_'+id).addClass('bg-dark text-white');
		$('#td_'+id).toggleClass('bg-dark text-white');
		
		$('#div_secondary_date').append('<div class="card card-body "><input type="text" class="form-control ion-pips-height-helper" id="ion-grid-values" data-fouc></div><br>');

	}
	
	
    </script>

@endsection

