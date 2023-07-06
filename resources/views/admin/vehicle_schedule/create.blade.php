@extends('admin.layout.base')

@section('title', 'Add Vehicle ')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle_schedule.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Add_Vehicle_Schedule')</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle_schedule.store')}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<div class="form-group">
						<label for="name" class="col-md-12 col-form-label">@lang('admin.name')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('name') }}" name="name" id="name" placeholder="Name">
						</div>
					</div>
					<div class="form-group">
						<label for="color" class="col-md-12 col-form-label">@lang('admin.color')</label>
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{ (old('color')) ? old('color') : '#000000'}}" name="color" required id="color" placeholder="Color">
						</div>
						<div class="col-md-2">
							<div id="colorpicker"></div>
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Add_Vehicle_Schedule')</button>
							<a href="{{route('admin.vehicle_schedule.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
