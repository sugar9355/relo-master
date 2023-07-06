@extends('admin.layout.base')

@section('title', 'Update Vehicle Fuel')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Update_Vehicle_Fuel')</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle.fuelStore', $id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}

					<div class="form-group">
						<label for="fuel_date" class="col-md-12 col-form-label">@lang('admin.fuel_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('fuel_date') }}" autocomplete="off" name="fuel_date" required id="fuel_date" placeholder="Last Fuel Changed Date">
						</div>
					</div>
					<div class="form-group">
						<label for="fuel_due_date" class="col-md-12 col-form-label">@lang('admin.fuel_due_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('fuel_due_date') }}" autocomplete="off" name="fuel_due_date" required id="fuel_due_date" placeholder="Next Fuel Changed Date">
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle_Fuel')</button>
							<a href="{{route('admin.vehicle.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />

@endsection
