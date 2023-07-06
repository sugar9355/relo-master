@extends('admin.layout.base')

@section('title', 'Add Item ')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle_schedule.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">Update Vehicle Schedule</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle_schedule.update', $vehicleSchedule->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					
					<input type="hidden" name="_method" value="PATCH">
					
					<div class="form-group">
						<label for="assigned_on" class="col-md-12 col-form-label">Assigned Date</label>
						
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{ $vehicleSchedule->assigned_on }}" name="assigned_on" required id="assigned_on" placeholder="assigned on">
						</div>
						
					</div>
					
					<div class="form-group">
						<label for="assigned_on" class="col-md-12 col-form-label">Start Time</label>
						
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{ $vehicleSchedule->start_time }}" name="start_time" required id="start_time" placeholder="start time">
						</div>
						
					</div>
					
					<div class="form-group">
						<label for="assigned_on" class="col-md-12 col-form-label">End Time</label>
						
						<div class="col-md-8">
							<input class="form-control" type="text" value="{{ $vehicleSchedule->end_time }}" name="end_time" id="end_time" placeholder="end time">
						</div>
						
					</div>
					

					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle_Schedule')</button>
							<a href="{{route('admin.vehicle_schedule.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
