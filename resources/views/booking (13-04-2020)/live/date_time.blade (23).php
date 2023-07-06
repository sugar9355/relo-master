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
                <div class="col-md-6">
					@if(isset($booking->primary_date))
						@php 
							
							$p_date = explode('-',$booking->primary_date);
							$p_date = Intval($p_date[1]).'-'.Intval($p_date[2]);
							$s_date = explode('-',$booking->secondary_date);
							$s_date = Intval($s_date[1]).'-'.Intval($s_date[2]);
							
							
						@endphp
					@endif
					@foreach ($calender as $month => $value) 
					@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
					
					
                    <div id="month_{{$month}}" class="card" style="@if($month == date('m')) @else display:none; @endif">
					
					<div class="card-body">
					
						<div class="row col-md-12 pb-1">
							
								<div class="col-md-10">
									<h6 id="h{{$month}}">{{date("F", mktime(0, 0, 0, $month, 10))}}</h6>
								</div>
								
								<div class="col-md-1">
								@if($month == (Intval(date('m')) + 1) || $month == (Intval(date('m')) + 2))
									<button type="button" onclick="show_month('<','{{$month}}');" class="btn bg-dark btn-sm text-white"><</button>
								@endif	
								</div>	
								<div class="col-md-1">
								@if($month == Intval(date('m')) || $month == (Intval(date('m')) + 1))
									<button type="button" onclick="show_month('>','{{$month}}');" class="btn bg-dark btn-sm text-white">></button>
								@endif
								</div>
							
						</div>
						
						<table id="{{$month}}" class="table table-bordered text-center">	
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
									@php $d = $month.'-'.$day; @endphp
									<td class="@if($p_date == $d || $s_date == $d) bg-dark text-white @endif">@if($day > 0){{$day}}@endif</td>
								@endforeach
								</tr>

								@endforeach
							
						</table>
						</div>
					</div>
					@endif
					@endforeach
				</div>
				
				<div class="col-md-6" id="div_secondary_date">
					@include('booking.slider')
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

@endsection
<script src="{{asset('assets_admin/js/main/date_time.js')}}"></script>
