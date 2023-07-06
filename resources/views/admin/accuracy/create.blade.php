@extends('admin.layout.base')

@section('title', 'Add Accuracy ')

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
<h6 class="card-title">Accuracy</h6>
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
	<div class="col-md-12">
		<h5>Not Accurate </h5>
		<div class="row">
		<div class="col-md-3">
			<input type="text" id="min[1]" name="min[1]" class="form-control" value="" placeholder="">
		</div>
		<div class="col-md-3">
			<input type="text" id="max[1]" name="max[1]" class="form-control" value="" placeholder="">	
		</div>
		</div>
	</div>
	<div class="col-md-12">
		<h5>Somewhat Accurate </h5>
		<div class="row">
		<div class="col-md-3">
			<input type="text" id="min[2]" name="min[2]" class="form-control" value="" placeholder="">
		</div>
		<div class="col-md-3">
			<input type="text" id="max[2]" name="max[2]" class="form-control" value="" placeholder="">
		</div>
		</div>
	</div>
	<div class="col-md-12">
		<h5>Accurate </h5>
		<div class="row">
		<div class="col-md-3">
			<input type="text" id="min[3]" name="min[3]" class="form-control" value="" placeholder="">
		</div>
		<div class="col-md-3">
			<input type="text" id="max[3]" name="max[3]" class="form-control" value="" placeholder="">
		</div>
		</div>
	</div>
	<div class="col-md-12">
		<h5> Very Accurate</h5>
		<div class="row">
		<div class="col-md-3">
			<input type="text" id="min[4]" name="min[4]" class="form-control" value="" placeholder="">
		</div>
		<div class="col-md-3">
			<input type="text" id="max[4]" name="max[4]" class="form-control" value="" placeholder="">
		</div>
		</div>
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
<script src="{{asset('assets_admin/js/main/accuracy.js')}}"></script>
@endsection
