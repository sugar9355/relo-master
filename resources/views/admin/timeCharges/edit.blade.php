@extends('admin.layout.base')

@section('title', 'Update Worker ')

@section('content')

    <div class="card">
        <div class="card-body">
            
		<a href="{{ route('admin.timecharges.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')
		</a>

		<h5 style="margin-bottom: 2em;">Update Time Charges</h5>

		<form class="form-horizontal" action="{{route('admin.timecharges.update', $timecharges->id )}}" method="POST" enctype="multipart/form-data"
			  role="form">
			{{ csrf_field() }}
			{{ method_field('PATCH') }}
		  <div class="col-md-6">
		<div class="row mb-3">
		<div class="col-md-3">s
		<label>Start Time</label>	
		<select name="start_time" class="form-control ">
		@foreach($time_range as $range)
		@foreach($interval as $int)
		<option value="{{$range}}{{$int}} AM" @if($timecharges->start_time == $range.':'.$int.' AM') selected @endif>{{$range}}{{$int}} AM</option>
		@endforeach
		@endforeach
		</select>
		</div>
		<div class="col-md-3">
		<label>End Time</label>	
		<select name="end_time" class="form-control ">
		@foreach($time_range as $range)
		@foreach($interval as $int)
		<option value="{{$range}}{{$int}} AM">{{$range}}{{$int}} AM</option>
		@endforeach
		@endforeach
		</select>
		</div>
		<div class="col-md-3">
		<label>dollar value</label>
		<input type="number" name="value" class="form-control" value="{{$timecharges->value}}" placeholder="$">
		</div>
		</div>

		</div>


			<div class="form-group">
				<label for="zipcode" class="col-md-2 col-form-label"></label>
				<div class="col-md-10">
					<button type="submit" class="btn btn-primary">Update Time Charges</button>
					<a href="{{route('admin.timecharges.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
				</div>
			</div>
		</form>
		</div>

    </div>

@endsection
