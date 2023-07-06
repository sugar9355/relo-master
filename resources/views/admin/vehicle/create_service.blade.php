@extends('admin.layout.base')

@section('title', 'Update Vehicle Service')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Update_Vehicle_Service')</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle.serviceStore', $id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}

					<div class="form-group">
						<label for="service_date" class="col-md-12 col-form-label">@lang('admin.service_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('service_date') }}" name="from" required id="service_date" autocomplete="off" placeholder="Last Service Changed Date">
						</div>
					</div>
					<div class="form-group">
						<label for="miles" class="col-md-12 col-form-label">@lang('admin.current_miles')</label>
						<div class="col-md-10">
							<input type="text" name="miles" id="miles" value="{{ $currentMiles }}" readonly class="form-control" placeholder="Miles">
						</div>
					</div>
					<div class="form-group">
						<label for="next_miles" class="col-md-12 col-form-label">@lang('admin.very_next_miles')</label>
						<div class="col-md-10">
							<input type="text" name="next_miles" id="next_miles" class="form-control" placeholder="Very Next Miles">
						</div>
					</div>
					<div class="form-group">
						<label for="always_miles" class="col-md-12 col-form-label">@lang('admin.always_miles')</label>
						<div class="col-md-10">
							<input type="text" name="always_miles" id="always_miles" class="form-control" placeholder="Always Miles">
						</div>
					</div>
					<div class="form-group">
						<label for="service_due_date" class="col-md-12 col-form-label">@lang('admin.service_due_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('service_due_date') }}" name="to" required id="service_due_date" autocomplete="off" placeholder="Next Service Changed Date">
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle_Service')</button>
							<a href="{{route('admin.vehicle.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />

@endsection
