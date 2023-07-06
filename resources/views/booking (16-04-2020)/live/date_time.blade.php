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
    height: 10px;
    background: #D7D7D7;
    border: 1px solid #BABABA;
    /* box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset; */
    clear: both;
    margin: 8px 0;
    -webkit-border-radius: 6px;
    -moz-border-radius: 6px;
    -ms-border-radius: 6px;
    -o-border-radius: 6px;
    border-radius: 6px;
    background: rgba(0,144,166,1);
    background: -moz-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(0,144,166,1)), color-stop(100%, rgba(12,215,237,1)));
    background: -webkit-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -o-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -ms-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: linear-gradient(135deg, rgb(0, 143, 165) 0%, rgba(12,215,237,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0090a6', endColorstr='#0cd7ed', GradientType=1 );
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
    /* box-shadow: 0 1px 0 #AAD6F6 inset; */
    -moz-border-radius: 6px;
    -webkit-border-radius: 6px;
    -khtml-border-radius: 6px;
    border-radius: 6px;
    background: #81B8F3;
    background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
    background-size: 100%;
    background: rgba(0,144,166,1);
    background: -moz-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(0,144,166,1)), color-stop(100%, rgba(12,215,237,1)));
    background: -webkit-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -o-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: -ms-linear-gradient(-45deg, rgba(0,144,166,1) 0%, rgba(12,215,237,1) 100%);
    background: linear-gradient(135deg, rgb(0, 92, 107) 0%, rgba(12,215,237,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0090a6', endColorstr='#0cd7ed', GradientType=1 );
    background-image: -webkit-linear-gradient(top, rgba(0, 92, 107, 1), #03ddff);
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
    background-image: -webkit-linear-gradient(top, #008fa6, #00dcff);
    background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
    background-image: linear-gradient(top, #C7CED6, #F9FBFA);
    width: 22px;
    height: 22px;
    -webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    -moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
    /* box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset; */
    -webkit-transition: box-shadow .3s;
    -moz-transition: box-shadow .3s;
    -o-transition: box-shadow .3s;
    transition: box-shadow .3s;
    border: 1.5px solid #fff !important;
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
    /* content:""; */
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
.card.rounded-lg {
    border-radius: 1rem!important;
}
td{
	background: rgba(255,255,255,1);
background: -moz-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1)));
background: -webkit-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -o-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 );
}
td.bg-dark{
	background: rgba(104,104,104,1);
background: -moz-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -webkit-gradient(left top, right bottom, color-stop(0%, rgba(104,104,104,1)), color-stop(100%, rgba(52,58,64,1)));
background: -webkit-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -o-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
background: linear-gradient(135deg, rgba(104,104,104,1) 0%, rgba(52,58,64,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#686868', endColorstr='#343a40', GradientType=1 );
Copy text
}
.peak
{
	color: white;
	padding: 1px;
	border-radius: 100px;
	font-size:12p3	
	
	padding-top:5px;
	background-color: #ff283c;
	background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
}
.badge-danger{
	background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
}
.high
{
	color: #ffffff;
   background: rgba(220,53,69,1);
background: -moz-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -webkit-gradient(left top, right top, color-stop(0%, rgba(220,53,69,1)), color-stop(100%, rgba(255,59,79,1)));
background: -webkit-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -o-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: -ms-linear-gradient(left, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
background: linear-gradient(to right, rgba(220,53,69,1) 0%, rgba(255,59,79,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#dc3545', endColorstr='#ff3b4f', GradientType=1 );
 
}

.circle
{
	color: #ffffff;
    background-color: var(--dark);
 
}

.moderate
{
	color: #ffffff;
    background: rgba(237,178,0,1);
    background: -moz-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(237,178,0,1)), color-stop(100%, rgba(232,175,88,1)));
    background: -webkit-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -o-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: -ms-linear-gradient(left, rgba(237,178,0,1) 0%, rgba(232,175,88,1) 100%);
    background: linear-gradient(to right, rgb(242, 184, 5) 0%, #ffc107 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#edb200', endColorstr='#e8af58', GradientType=1 );
 
}

.low
{
	color: #ffffff;
    background: rgba(150,176,3,1);
    background: -moz-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -webkit-gradient(left top, right top, color-stop(0%, rgba(150,176,3,1)), color-stop(100%, rgba(40,167,69,1)));
    background: -webkit-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -o-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: -ms-linear-gradient(left, rgba(150,176,3,1) 0%, rgba(40,167,69,1) 100%);
    background: linear-gradient(to right, rgb(150, 176, 0) 0%, rgba(40,167,69,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#96b003', endColorstr='#28a745', GradientType=1 );
 
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
					
					
                    <div id="month_{{$month}}" class="card shadow rounded-lg w-100" style="@if($month == date('m')) @else display:none; @endif">
					
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
									<td id="td_{{$date}}" onclick="select_date('{{$date}}');" class=" @if(in_array($date,$b_date)) bg-dark text-white @endif {{$day[1]}}">@if($day[0] > 0){{$day[0]}}@endif</td>
								@endforeach
								</tr>

								@endforeach
							
						</table>
						<div class="row">

							<div class="col-md-4 p-2 text-center">
								<span class="badge badge-danger p-2 hvr-shadow">High Demand</span> 
							</div>
							<div class="col-md-4 p-2 text-center">
								<span class="badge badge-warning p-2 hvr-shadow">Medrate Demand</span> 
							</div>
							<div class="col-md-4 p-2 text-center" >
								<span class="badge bg-success text-white p-2 hvr-shadow">Low Demand</span> 
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

