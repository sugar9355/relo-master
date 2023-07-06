@extends("user.layout.app")

	<!-- Core JS files -->
	<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
	
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
	<!-- <script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script> 
	<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>-->
	
	
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

.peak
{
	color: white;
	
	background-color: red;
	
	
	padding: 1px;
	border-radius: 100px;
	font-size:12px;
}

.high
{
	margin:auto;
	color: white;
    width: 29px;
    height: 26px;
    background-color: red;
    border-radius: 100px;
    text-align: center;
}

.circle
{
	margin:auto;
	color: white;
    width: 29px;
    height: 26px;
    background-color: dark;
    border-radius: 100px;
    text-align: center;
}

.moderate
{
	margin:auto;
	color: white;
    width: 29px;
    height: 26px;
    background-color: orange;
    border-radius: 100px;
    text-align: center;
}

.low
{
	margin:auto;
	color: white;
    width: 29px;
    height: 26px;
    background-color: purple;
    border-radius: 100px;
    text-align: center;
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

			
            <div id="dateRange">
			<input id="selector" value="0" type="hidden" >
			<div class="row mt-3">
                <div class="col-md-6">
					
					
					@php
						$year = date('y');
						$b_date = array(); 
					@endphp
					@if(isset($booking_dates[0]))
					
						@foreach($booking_dates as $dates)
							@php $b_date[] = date('Y-m-d',strtotime($dates->booking_date)); @endphp
						@endforeach
						
					@endif
					
					@if(isset($booking->primary_date))
						@php 	
							$p_date = 	explode('-',$booking->primary_date);
							$p_date = Intval($p_date[1]).'-'.Intval($p_date[2]);
						@endphp 
					@else
						@php	
							$p_date = ''; 
						@endphp 
					@endif
					
					@if(isset($booking->secondary_date))
						@php 	
							$s_date = explode('-',$booking->secondary_date);
							$s_date = Intval($s_date[1]).'-'.Intval($s_date[2]);
						@endphp 
					@else
						@php	
							$s_date = ''; 
						@endphp 
					@endif

					@foreach ($calender as $month => $value) 
					@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
					
					
                    <div id="month_{{$month}}" class="card" style="@if($month == date('m')) @else display:none; @endif">
					
					<div class="card-body">
					
						<div class="row col-md-12 pb-1">
							
								<div class="col-md-10">
									<h6 id="h{{date('m', mktime(0, 0, 0, $month, 10))}}">{{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
								</div>
								
								<div class="col-md-1">
								@if($month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
									<button type="button" onclick="show_month('<','{{$month}}');" class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-left hvr-icon"></i></button>
								@endif	
								</div>	
								<div class="col-md-1">
								@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1))
									<button type="button" onclick="show_month('>','{{$month}}');" class="btn bg-transparent btn-sm border"><i class="fas fa-chevron-right hvr-icon"></i></button>
								@endif
								</div>
							
						</div>
						
						<table id="{{date('m', mktime(0, 0, 0, $month, 10))}}" class="table table-bordered text-center">	
							<tr class="bg-info text-white">
								<th   class="text-center">MON</th>
								<th   class="text-center">TUE</th>
								<th   class="text-center">WED</th>
								<th   class="text-center">THU</th>
								<th   class="text-center">FRI</th>
								<th   class="text-center">SAT</th>
								<th   class="text-center">SUN</th>
							</tr>
							
								@foreach ($value as $k =>$week) 

								<tr>
								@foreach($week as $day) 
									@php 
									$date = $year.'-'.$month.'-'.$day[0];
									$date = date('Y-m-d',strtotime($date));
									@endphp
									<td id="td_{{$date}}" onclick="select_date('{{$date}}');" class=" @if(in_array($date,$b_date)) bg-dark text-white @endif"><div class="{{$day[1]}}">@if($day[0] > 0){{$day[0]}}@endif</div></td>
								@endforeach
								</tr>

								@endforeach
							
						</table>
						<div class="row">

							<div class="col-md-4 p-2 text-center">
								<span class="badge badge-danger">High Demand</span> 
							</div>
							<div class="col-md-4 p-2 text-center">
								<span class="badge badge-warning ">Medrate Demand</span> 
							</div>
							<div class="col-md-4 p-2 text-center" >
								<span style="background-color:purple;" class="badge bg-purple text-white">Low Demand</span> 
							</div>
								
						</div>
						</div>
					</div>
					@endif
					@endforeach
				</div>
				
				<div class="col-md-6" id="div_secondary_date">
					@include('booking.slider')
					<div class="col-md-12 text-center">
                    <hr>
					<a href="/booking/{{ ($booking->booking_id) ?: null }}/2" name="btn_save_step_back" type="submit" value="5" class="btn btn btn-outline-dark m-auto  hvr-icon-wobble-horizontal"><i class="fas fa-chevron-left hvr-icon"></i> Back</a>
					<button id="dataFormBtn" name="btn_submit" type="submit" value="3" class="btn btn-dark m-auto hvr-icon-wobble-horizontal">Save & Continue <i class="fas fa-chevron-right hvr-icon"></i></button>
				</div>
				</div>

            </div>
            
			
			</div>
	
    </form>
	

</div>
@endsection
	
@section("scripts")
<script>
var start = [];
var end = [];
@foreach($time_charges as $k => $time)
 start ["{{$time->int_start}}"] = "{{$time->value}}";
 end   ["{{$time->int_end}}"] = "{{$time->value}}";
@endforeach

console.log(digit);
</script>
<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script>
@endsection

