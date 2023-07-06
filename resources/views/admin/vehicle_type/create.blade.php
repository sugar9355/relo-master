@extends('admin.layout.base')

@section('title', 'Add Vehicle ')

@section('content')

<div class="card">
	<div class="card-body">
		<a href="{{ route('admin.vehicleType.index') }}" class="btn btn-default pull-right"><i
				class="fa fa-angle-left"></i> @lang('admin.back')</a>

		<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Add_Vehicle_Type')</h5>

		<form class="form-horizontal" action="{{route('admin.vehicleType.store')}}" method="POST"
			enctype="multipart/form-data" role="form">
			{{csrf_field()}}
			<div class="form-group">
				<label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
				<div class="col-md-10">
					<input class="form-control" type="text" value="{{ old('name') }}" name="name" id="name"
						placeholder="Name">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-12 col-form-label">@lang('admin.abbreviation')</label>
				<div class="col-md-10">
					<input class="form-control" type="text" value="{{ old('abbreviation') }}" name="abbreviation"
						id="abbreviation" placeholder="abbreviation">
				</div>
			</div>
			<div class="form-group">
				<label for="name" class="col-md-12 col-form-label">Additional Charges</label>
				<div class="col-md-10">
					<input class="form-control" type="number" value="" name="add_charges"
						id="add_charges" placeholder="additional charges" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.width')</label>
					<div class="col-md-12">
						<input class="form-control" type="number" value="" name="width"
							id="width" placeholder="width" required>
					</div>
				</div>
				<div class="col-md-3">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.height')</label>
					<div class="col-md-12">
						<input class="form-control" type="number" value="" name="height"
							id="height" placeholder="height" required>
					</div>
				</div>
				<div class="col-md-3">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.breadth')</label>
					<div class="col-md-12">
						<input class="form-control" type="number" value="" name="breadth"
							id="breadth" placeholder="breadth" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
				<div class="col-md-8">
					<input class="form-control" type="text" value="{{ (old('color')) ? old('color') : '#000000'}}"
						name="color" required id="color" placeholder="Color">
				</div>
				<div class="col-md-2">
					<div id="colorpicker"></div>
				</div>
			</div>
			<div class="form-group">
				<hr>
				<div class="col-md-10">
					<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Add_Vehicle_Type')</button>
					<a href="{{route('admin.vehicleType.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
				</div>
			</div>
		</form>
	</div>

</div>
<link rel="stylesheet" type="text/css"
	href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
@endsection