@extends('admin.layout.base')

@section('title', 'Add Vehicle ')

@section('content')

	<!-- Theme JS files -->
		<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
		<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
	<!-- /theme JS files -->

	<!-- Form inputs -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">@lang('admin.vehicle.Add_Vehicle')</h5>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                		<a class="list-icons-item" data-action="reload"></a>
		                		<a class="list-icons-item" data-action="remove"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">

						<form class="form-horizontal" action="{{route('admin.vehicle.store')}}" method="POST" enctype="multipart/form-data" role="form">
						{{csrf_field()}}
							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold"></legend>

								<div class="form-group">
						<label for="name"class="col-form-label col-lg-2">@lang('admin.nameNumber')</label>
						<div class="col-md-10">
							<input type="hidden" name="samsara_id" id="vehicleId">
							<select onchange="setValues(this)" class="form-control" name="name" id="name">
								<option value="">Select Vehicle</option>
								@foreach($samSaraVehicles as $samSaraVehicle)
									<?php $vehicleNameArray = explode('-', explode(' ', $samSaraVehicle->name)[0]) ?>
									<option value="{{ $samSaraVehicle->name }}" data-vehicleId="{{ $samSaraVehicle->id }}" data-miles="{{ $samSaraVehicle->odometerMeters / 1609.344 }}" data-ab="{{ $vehicleNameArray[0] }}" data-type="{{ $vehicleNameArray[1] }}" data-y="{{ $vehicleNameArray[2] }}" data-reg="{{ $vehicleNameArray[3] }}">{{ $samSaraVehicle->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2">
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-outline-primary btn-lg" id="createTruck"> <i class="icon-truck"></i> Create your own truck</button>
						</div>
					</div>
					<div class="form-group">
						<label for="type"class="col-form-label col-lg-2">@lang('admin.type')</label>
						<div class="col-md-10">
							<select class="form-control" name="type" id="type">
								<option value="">Select Type</option>
								@foreach($vehicleTypes as $vehicleType)
									<option value="{{ $vehicleType->name }}" data-color="{{ $vehicleType->color }}" data-ab{{ $vehicleType->abbreviation }} id="{{ $vehicleType->abbreviation }}">{{ $vehicleType->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="year"class="col-form-label col-lg-2">@lang('admin.year')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" readonly value="{{ old('year')}}" name="year" required id="year" placeholder="Year">
						</div>
					</div>
					<div class="form-group">
						<label for="reg_no"class="col-form-label col-lg-2">@lang('admin.regNo')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" readonly value="{{ old('reg_no')}}" name="reg_no" required id="reg" placeholder="Registration Number">
						</div>
					</div>
					
					<div class="form-group">
						<label for="color"class="col-form-label col-lg-2">@lang('admin.color')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" readonly value="{{ old('color')}}" name="color" required id="colorShow" placeholder="Color">
						</div>
					</div>
					<div class="form-group">
						<label for="fuel_volume"class="col-form-label col-lg-2">@lang('admin.fuel_volume')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('fuel_volume') }}" name="fuel_volume" required id="fuel_volume" placeholder="Fuel Capacity">
						</div>
					</div>
					<div class="form-group">
						<label for="fuel_type"class="col-form-label col-lg-2">@lang('admin.fuel_type')</label>
						<div class="col-md-10">
							<select class="form-control" name="fuel_type" id="fuel_type">
								<option value="">Select Fuel Type</option>
								<option value="P">Petrol</option>
								<option value="D">Diesel</option>
								<option value="G">Gasoline</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="overall_height"class="col-form-label col-lg-2">@lang('admin.overall_height')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('overall_height') }}" name="overall_height" required id="overall_height" placeholder="Overall Height">
						</div>
					</div>
					<div class="form-group">
						<label for="overall_width"class="col-form-label col-lg-2">@lang('admin.overall_width')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('overall_width') }}" name="overall_width" required id="overall_width" placeholder="Overall Width">
						</div>
					</div>
					<div class="form-group">
						<label for="wheel_base"class="col-form-label col-lg-2">@lang('admin.wheel_base')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('wheel_base') }}" name="wheel_base" required id="wheel_base" placeholder="Wheelbase">
						</div>
					</div>

					<div class="form-group">
						<label for="gvw_rating"class="col-form-label col-lg-2">@lang('admin.gvw_rating')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('gvw_rating') }}" name="gvw_rating" required id="gvw_rating" placeholder="GVW Rating">
						</div>
					</div>
					<div class="form-group">
						<label for="towing_capacity"class="col-form-label col-lg-2">@lang('admin.towing_capacity')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('towing_capacity') }}" name="towing_capacity" required id="towing_capacity" placeholder="Towing Capacity">
						</div>
					</div>
					<div class="form-group">
						<label for="payload_capacity"class="col-form-label col-lg-2">@lang('admin.payload_capacity')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('payload_capacity') }}" name="payload_capacity" required id="payload_capacity" placeholder="Payload Capacity">
						</div>
					</div>

					<div class="form-group">
						<label for="towing_capacity_maximum"class="col-form-label col-lg-2">@lang('admin.towing_capacity_maximum')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('towing_capacity_maximum') }}" name="towing_capacity_maximum" required id="towing_capacity_maximum" placeholder="Towing Capacity Maximum">
						</div>
					</div>
					<div class="form-group">
						<label for="cargo_length"class="col-form-label col-lg-2">@lang('admin.cargo_length')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('cargo_length') }}" name="cargo_length" required id="cargo_length" placeholder="Cargo Length">
						</div>
					</div>
					<div class="form-group">
						<label for="cargo_width"class="col-form-label col-lg-2">@lang('admin.cargo_width')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('cargo_width') }}" name="cargo_width" required id="cargo_width" placeholder="Cargo Width">
						</div>
					</div>

					<div class="form-group">
						<label for="title_number"class="col-form-label col-lg-2">@lang('admin.title_number')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('title_number') }}" name="title_number" required id="title_number" placeholder="Title Number">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12">
							<div class="form-inline">
								<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.weight')</label></div>
								<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.width')</label></div>
								<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.height')</label></div>
								<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.breadth')</label></div>
								<div class="col-md-2 text-center"><label for="name" class="col-md-2 col-form-label m-auto">Multiplier</label></div>
								<div class="col-md-1 text-center"><label for="name" class="col-md-2 col-form-label m-auto">@lang('admin.volume')</label></div>
								<div class="col-md-1 text-center"><label for="name" class="col-md-2 col-form-label m-auto">Packing Volume</label></div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12">
							<div class="form-inline">
								<div class="col-md-2"><input class="form-control text-center" onkeyup="calcVol()" type="text" value="{{ old('weight') }}"  name="weight" required id="weight" placeholder="Weight"></div>
								<div class="col-md-2"><input class="form-control text-center" onkeyup="calcVol()" type="text" value="{{ old('width') }}"   name="width" required id="width" placeholder="Width"></div>
								<div class="col-md-2"><input class="form-control text-center" onkeyup="calcVol()" type="text" value="{{ old('height') }}"  name="height" required id="height" placeholder="Height"></div>
								<div class="col-md-2"><input class="form-control text-center" onkeyup="calcVol()" type="text" value="{{ old('breadth') }}" name="breadth" required id="breadth" placeholder="Breadth"></div>
								<div class="col-md-2"><input class="form-control text-center" onkeyup="calcVol()" type="text" value="{{ old('multiplier') }}" name="multiplier" required id="multiplier" placeholder="multiplier"></div>
								<div class="col-md-1"><input class="form-control text-center" type="text" value="{{ old('volume') }} " name="volume" required id="volume" placeholder="Volume" readonly ></div>
								<div class="col-md-1"><input style="width: 120px;" class="form-control text-center" type="text" value="{{ old('packing_volume') }} " name="packing_volume" required id="packing_volume" placeholder="Packing Volume" readonly ></div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
					
					
						<div class="col-md-6">
							<div class="card">
								<div class="card-header bg-dark text-white header-elements-inline">
									<h6 class="card-title">Threshold</h6>
									<div class="header-elements">
										<div class="list-icons">
											<input id="threshold" name="threshold" type="hidden" value="" class="switchery" data-fouc>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div id="threshold" name="threshold" class="ui-slider-horizontal jui-slider-labels-custom" data-fouc></div>
								</div>
								
							</div>
						</div>
					
					</div>
					
					<div class="text-left">
						<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Add_Vehicle') <i class="icon-paperplane ml-2"></i></button>
						<a href="{{route('admin.vehicle.index')}}" class="btn btn-outline bg-slate-600 text-slate-600 border-slate-600">@lang('admin.cancel')</a>
					</div>
							</fieldset>
						</form>
					</div>
				</div>					
<!-- Content area -->

<div class="card-body">
		
		<fieldset class="mb-3">
			<legend class="text-uppercase font-size-sm font-weight-bold"></legend>
			

				
				</form>
		</fieldset>	
	</form>
</div>



	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />

	<script>
		$( document ).ready(function() 
		{
			
			$("#createTruck").click(function()
			{
				$("#reg").prop('readonly', false);
				$("#year").prop('readonly', false);
				$("#fuel_type").prop('readonly', false);
				
				$("#name").prop('disabled', true);
				
			});
			
			
			$("#type").on('change', function (e) {
				setColor(this)
			})
		});
		function setColor(me) {
			let color = $(me).children("option:selected").data('color');
			$("#colorShow").val(color);
			$("#colorShow").css("color", color);
		}
		function calcVol(){
			let width = parseInt($("#width").val());
			let height = parseInt($("#height").val());
			let breadth = parseInt($("#breadth").val());
			let multiplier = parseInt($("#multiplier").val());
			if (isNaN(width)) width = 0;
			if (isNaN(height)) height = 0;
			if (isNaN(breadth)) breadth = 0;
			if (isNaN(multiplier)) multiplier = 0;
			let vol = width * height * breadth;
			let p_vol = multiplier * vol;
			$("#volume").val(vol);
			$("#packing_volume").val(p_vol);
		}
		function setValues(me){
			let selector = $(me).children("option:selected");
			let year = selector.data("y");
			let reg = selector.data("reg");
			let fuelType = selector.data("type");
			let ab = selector.data("ab");
			let miles = selector.data("miles");
			let vehicleId = selector.data("vehicleid");
			let optionSelector = $("#"+ab);
			if (optionSelector.length <= 0){
				alert("Please Add Vehicle Type With This Abbreviation "+ ab);
				$(me).val("");
				return;
			}
			$("#miles").val(miles);
			$("#vehicleId").val(vehicleId);
			let colorSelect = $("#type");
			colorSelect.val(optionSelector.val());
			setColor(colorSelect);
			$("#year").val(year);
			$("#reg").val(reg);
			$("#fuel_type").val(fuelType);
		}
	</script>

@endsection
