@extends('admin.layout.base')

@section('title', 'Add Item ')

@section('content')

<div class="card">
	<div class="card-body">
		<div>
			<a href="{{ route('admin.vehicleType.index') }}" class="btn btn-default pull-right"><i
					class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">Update Vehicle Type</h5>

			<form class="form-horizontal" action="{{route('admin.vehicleType.update', $vehicleType->id)}}" method="POST"
				enctype="multipart/form-data" role="form">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $vehicleType->name }}" name="name" required
							id="name" placeholder="Name">
					</div>
				</div>

				<div class="form-group">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.abbreviation')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $vehicleType->abbreviation }}"
							name="abbreviation" id="abbreviation" placeholder="abbreviation">
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-md-12 col-form-label">Additional Charges</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ $vehicleType->add_charges }}" name="add_charges" id="add_charges"
							placeholder="additional charges" required>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.width')</label>
						<div class="col-md-12">
							<input class="form-control" type="number" value="{{ $vehicleType->width }}" name="width" id="width"
								placeholder="width" required>
						</div>
					</div>
					<div class="col-md-3">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.height')</label>
						<div class="col-md-12">
							<input class="form-control" type="number" value="{{ $vehicleType->height }}" name="height" id="height"
								placeholder="height" required>
						</div>
					</div>
					<div class="col-md-3">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.breadth')</label>
						<div class="col-md-12">
							<input class="form-control" type="number" value="{{ $vehicleType->breadth }}" name="breadth" id="breadth"
								placeholder="breadth" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
					<div class="col-md-8">
						<input class="form-control" type="text" value="{{ $vehicleType->color }}" name="color" required
							id="color" placeholder="Color">
					</div>
					<div class="col-md-2">
						<div id="colorpicker"></div>
					</div>
				</div>

				<div class="form-group">
					<hr>
					<div class="col-md-10">
						<button type="submit"
							class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle_Type')</button>
						<a href="{{route('admin.vehicleType.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection