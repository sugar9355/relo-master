@extends('admin.layout.base')

@section('title', 'Add Worker ')

@section('content')

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

<!--<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>-->
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
						
<div class="card">
<div class="card-header bg-dark header-elements-sm-inline">
<h6 class="card-title">Time Charges</h6>
<div class="header-elements">
<div class="d-flex justify-content-between">

<div class="list-icons ml-3">
	
</div>
</div>
</div>
</div>
<form action="{{ route('admin.timecharges.store') }}" method="post" enctype="multipart/form-data" class="w-100">
{{ csrf_field() }}

<div class="card-body">

<div class="row">
	<div class="col-md-6">
		<h5>Add Time Range in AM<h5>
		
		<div class="col-md-8">
		<div id="time-range">

			<p> Time Range: 
			<span id="start_span_time_am">
				6:00 AM
			</span> - 
			<span id="end_span_time_am">
				6:00 AM
			</span></p>
			<div class="sliders_step">
			
				<div id="time_am" class="slider-range"></div>
				
			</div>
		</div>
		</div>
		
		<input type="number" name="value_am" class="form-control col-md-2" value="" placeholder="$">
		<input type="hidden" id="digit_start_time_am" name="digit_start_time_am" class="form-control" value="" placeholder="">
		<input type="hidden" id="digit_end_time_am" name="digit_end_time_am" class="form-control" value="" placeholder="">
		<input type="hidden" id="start_time_am" name="start_time_am" class="form-control" value="" placeholder="">
		<input type="hidden" id="end_time_am" name="end_time_am" class="form-control" value="" placeholder="">
	</div>
	<div class="col-md-6">
	
		<h5>Add Time Range in PM<h5>
		<div class="col-md-8">
		<div id="time-range">

			<p> Time Range: 
			<span id="start_span_time_pm">
				6:00 AM
			</span> - 
			<span id="end_span_time_pm">
				6:00 AM
			</span></p>
			<div class="sliders_step">
			
				<div id="time_pm" class="slider-range"></div>
				
			</div>
		</div>
		</div>
		<input type="number" name="value_pm" class="form-control col-md-2" value="" placeholder="$">
		<input type="hidden" id="digit_start_time_pm" name="digit_start_time_pm" class="form-control" value="" placeholder="">
		<input type="hidden" id="digit_end_time_pm" name="digit_end_time_pm" class="form-control" value="" placeholder="">
		<input type="hidden" id="start_time_pm" name="start_time_pm" class="form-control" value="" placeholder="">
		<input type="hidden" id="end_time_pm" name="end_time_pm" class="form-control" value="" placeholder="">
	</div>
</div>

</div>

<div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center">

<div class="mt-2 mt-sm-0">
<button type="submit" name="btn_submit" value="true" class="btn bg-indigo-400"><i class="icon-checkmark3 mr-2"></i> Save</button>
<button type="button" class="btn btn-light ml-1"><i class="icon-cross2 mr-2"></i> Close</button>
</div>
</div>

</div>
</form>
<!-- /switchery and card controls -->

@endsection

@section("scripts")
<script src="{{asset('assets_admin/js/main/time_charges.js')}}"></script>
@endsection
