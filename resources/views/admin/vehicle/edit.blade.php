@extends('admin.layout.base')

@section('title', 'Add Item ')

@section('content')

	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Update Vehicle</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle.update', $vehicle->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">

					<div class="form-group">
						<div class="row">
							<div class="col">
								<label for=""></label>
								<select name="type" id="type" class="form-control">
								@foreach($vehicleTypes as $vehicleType)
									<option value="{{ $vehicleType->name }}" @if ($vehicleType->name == $vehicle->type) selected @endif>{{ $vehicleType->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="overall_height" class="col-md-12 col-form-label">@lang('admin.overall_height')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->overall_height }}" name="overall_height" required id="overall_height" placeholder="Overall Height">
								</div>
							</div>
							<div class="col-md-3">
								<label for="overall_width" class="col-md-12 col-form-label">@lang('admin.overall_width')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->overall_width }}" name="overall_width" required id="overall_width" placeholder="Overall Width">
								</div>
							</div>
							<div class="col-md-3">
								<label for="wheel_base" class="col-md-12 col-form-label">@lang('admin.wheel_base')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->wheel_base }}" name="wheel_base" required id="wheel_base" placeholder="Wheelbase">
								</div>
							</div>

							<div class="col-md-3">
								<label for="gvw_rating" class="col-md-12 col-form-label">@lang('admin.gvw_rating')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->gvw_rating }}" name="gvw_rating" required id="gvw_rating" placeholder="GVW Rating">
								</div>
							</div>
						</div>	
					</div>
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="towing_capacity" class="col-md-12 col-form-label">@lang('admin.towing_capacity')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->towing_capacity }}" name="towing_capacity" required id="towing_capacity" placeholder="Towing Capacity">
								</div>
							</div>
							<div class="col-md-3">
								<label for="payload_capacity" class="col-md-12 col-form-label">@lang('admin.payload_capacity')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->payload_capacity }}" name="payload_capacity" required id="payload_capacity" placeholder="Payload Capacity">
								</div>
							</div>
							<div class="col-md-3">
								<label for="towing_capacity_maximum" class="col-md-12 col-form-label">@lang('admin.towing_capacity_maximum')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->towing_capacity_maximum }}" name="towing_capacity_maximum" required id="towing_capacity_maximum" placeholder="Towing Capacity Maximum">
								</div>
							</div>
							<div class="col-md-3">
								<label for="fuel_volume" class="col-md-12 col-form-label">@lang('admin.fuel_volume')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->fuel_volume }}" name="fuel_volume" required id="fuel_volume" placeholder="Fuel Capacity">
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="form-group">
						<div class="row">
							<div class="col-md-3">
								<label for="cargo_length" class="col-md-12 col-form-label">@lang('admin.cargo_length')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->cargo_length }}" name="cargo_length" required id="cargo_length" placeholder="Cargo Length">
								</div>
							</div>
							<div class="col-md-3">
								<label for="cargo_width" class="col-md-12 col-form-label">@lang('admin.cargo_width')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->cargo_width }}" name="cargo_width" required id="cargo_width" placeholder="Cargo Width">
								</div>
							</div>

							<div class="col-md-3">
								<label for="title_number" class="col-md-12 col-form-label">@lang('admin.title_number')</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->title_number }}" name="title_number" required id="title_number" placeholder="Title Number">
								</div>
							</div>
							
							<div class="col-md-3">
								<label for="title_number" class="col-md-12 col-form-label">Mileage per Hour</label>
								<div class="col-md-12">
									<input class="form-control" type="text" value="{{ $vehicle->mileage }}" name="mileage" required id="mileage" placeholder="Mileage">
								</div>
							</div>
							
						</div>	
					</div>
				
					<div class="form-group">
						<div class="row">
							<div class="col-md-2">
								<label for="weight" class="col-md-12 col-form-label">@lang('admin.weight')</label>
								
									<input class="form-control" type="text" value="{{ $vehicle->weight }}" name="weight" required id="weight" placeholder="Weight">
								
							</div>
							<div class="col-md-2">
								<label for="width" class="col-md-12 col-form-label">@lang('admin.width')</label>
								
									<input class="form-control" type="text" onkeyup="calcVol()" value="{{ $vehicle->width }}" name="width" required id="width" placeholder="Width">
								
							</div>
							<div class="col-md-2">
								<label for="height" class="col-md-12 col-form-label">@lang('admin.height')</label>
								
									<input class="form-control" type="text" onkeyup="calcVol()" value="{{ $vehicle->height }}" name="height" required id="height" placeholder="Height">
								
							</div>
							<div class="col-md-2">
								<label for="breadth" class="col-md-12 col-form-label">@lang('admin.breadth')</label>
								
									<input class="form-control" type="text" onkeyup="calcVol()" value="{{ $vehicle->breadth }}" name="breadth" required id="breadth" placeholder="Breadth">
								
							</div>
							<div class="col-md-3">
								<label for="volume" class="col-md-12 col-form-label">@lang('admin.volume')</label>
								<div class="col-md-10">
									<input class="form-control" type="text" readonly value="{{ $vehicle->volume }}" name="volume" required id="volume" placeholder="Volume">
								</div>
							</div>
						</div>
					</div>
					<div class="row" style="margin-bottom: 20px">
						<div class="col-md-2">
							<label for="weight" class="col-md-12 col-form-label">Multiplier</label>
							
								<input class="form-control" type="text" onkeyup="calcVol()" value="{{ $vehicle->multiplier }}" name="multiplier" required id="multiplier" placeholder="Multiplier">
							
						</div>
						<div class="col-md-2">
							<label for="width" class="col-md-12 col-form-label">Packing Volume</label>
							
								<input class="form-control" type="text" readonly value="{{ $vehicle->packing_volume }}" name="packing_volume" required id="packing_volume" placeholder="Packing Volume">
							
						</div>
					</div>
				
					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-header bg-dark text-white header-elements-inline">
									<h6 class="card-title">Threshold</h6>
									<div class="header-elements">
										<div class="list-icons">
											<input id="threshold" name="threshold" type="hidden" value="@isset($range[$vehicle->threshold]){{$range[$vehicle->threshold]}}@endisset" class="switchery" data-fouc>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="ui-slider-horizontal ui-slider-pips jui-slider-labels-custom" data-fouc></div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="row">
						@foreach ($demand_types as $demand)
						<div class="col-md-2">
							<label for="" class="col-md-12 col-form-label">{{$demand->demand_name}} Rate</label>
							<div class="col-md-10">
								<input class="form-control demand_rate" type="text" value="{{$demand->rate}}" required data-id="{{$demand->id}}">
							</div>
						</div>
						@endforeach
					</div>
					{{-- <div class="row">
						@foreach ($demand_types as $demand)
						<div class="col-md-2">
							<label for="" class="col-md-12 col-form-label">{{$demand->demand_name}} Reservation Fee</label>
							<div class="col-md-10">
								<input class="form-control demand_fee" type="text" value="{{$demand->reservation_fee}}" required data-id="{{$demand->id}}">
							</div>
						</div>
						@endforeach
					</div> --}}
					<input type="hidden" name="demand_rates" id="demand_rates" />
				
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle')</button>
							<a href="{{route('admin.vehicle.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$( document ).ready(function() {
			$("#type").on('change', function (e) {
				let color = $(this).children("option:selected").data('color');
				$("#colorShow").val(color);
				$("#colorShow").css("color", color);
			})

			var demand_rates = {
			@foreach ($demand_types as $c)
				"{{$c->id}}": { "demand_id": "{{ $c->id }}", "rate": "{{ $c->rate }}", "reservation_fee": {{ $c->reservation_fee }} }, 
			@endforeach
			};
			$('#demand_rates').val(JSON.stringify(demand_rates))
			console.log($('#demand_rates').val())

			$('.demand_rate').keyup(function() {
				var demand_id = $(this).data('id');
				demand_rates[demand_id].rate = $(this).val();
				$('#demand_rates').val(JSON.stringify(demand_rates));
			})

			$('.demand_fee').keyup(function() {
				var demand_id = $(this).data('id');
				demand_rates[demand_id].reservation_fee = $(this).val();
				$('#demand_rates').val(JSON.stringify(demand_rates));
			})
		});
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
			$('#packing_volume').val(p_vol);
		}
	</script>

@endsection
