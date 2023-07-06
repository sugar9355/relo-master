@extends('admin.layout.base')

@section('title', 'Update Level ')

@section('content')

<div class="card card-body">

				<h3 class="m-0">Update Level 
					<a href="{{ route('admin.level.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>
				</h3>

				<hr>

				<form action="{{route('admin.level.update', $level->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<div class="form-row">
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group col-md-6">
						<label for="name" class="form-label">@lang('admin.name')</label>
						<input class="form-control" type="text" value="{{ $level->name }}" name="name" required id="name"
								   placeholder="Name">
					</div>

					<div class="form-group col-md-6">
						<label for="bonus" class="form-label">Bonus Amount</label>
						<input class="form-control" type="text" required name="bonus" value="{{ $level->bonus }}" id="bonus" placeholder="Bonus Amount">
					</div>

					<div class="form-group col-md-6">
						<label for="level" class="form-label">Level</label>
						<input class="form-control" type="text" name="level" id="level" value="{{ $level->level }}" placeholder="Level">
					</div>

					<div class="form-group col-md-6">
						<label for="hours" class="form-label">Hours</label>
						<input class="form-control" type="text" name="hours" id="hours" value="{{ $level->hours }}" placeholder="Hours">
					</div>
					<!--div class="form-group">
                        <label for="time" class="col-md-2 col-form-label">Time in Min</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ $level->time }}" name="time" required id="time"
                                   placeholder="5">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-2 col-form-label">Time in Med</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ $level->time_med }}" name="time_med" required id="time_med"
                                   placeholder="7">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="time" class="col-md-2 col-form-label">Time in Max</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  value="{{ $level->time_max }}" name="time_max" required id="time_max"
                                   placeholder="10">
                        </div>

                    </div>
					<div class="form-group">
						<label for="days" class="col-md-2 col-form-label">Consecutive days</label>
						<div class="col-md-10">
							<input class="form-control" type="text" name="days" id="days" value="{{ $level->days }}" placeholder="Consecutive days">
						</div>
					</div-->
					</div>

					<hr>

					<button type="submit" class="btn btn-primary">Update Level</button>
					<a href="{{route('admin.level.index')}}" class="btn btn-outline-dark">Cancel</a>
				</form>

	</div>

@endsection
outline