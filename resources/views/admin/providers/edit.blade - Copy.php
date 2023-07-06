@extends('admin.layout.base')

@section('title', 'Update Provider ')

@section('content')

<div class="card">
    <div class="card-body">
        <div >
            <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

            <h5 style="margin-bottom: 2em;">Update Employee</h5>

            <form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group">
                    <label for="first_name" class="col-md-2 col-form-label text-right">@lang('admin.first_name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $employee->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-md-2 col-form-label text-right">@lang('admin.last_name')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ $employee->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
                    </div>
                </div>


                <div class="form-group">
                    
                    <label for="picture" class="col-md-2 col-form-label text-right">@lang('admin.picture')</label>
                    <div class="col-md-10">
                    @if(isset($employee->avatar))
                        <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$employee->avatar}}">
                    @endif
                        <input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
                    </div>
                </div>

                <div class="form-group">
                    <label for="mobile" class="col-md-2 col-form-label text-right">@lang('admin.mobile')</label>
                    <div class="col-md-10">
                        <input class="form-control" type="number" value="{{ $employee->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
                    </div>
                </div>
			
				<div class="form-group">
					<label for="last_name" class="col-md-2 col-form-label text-right"></label>
					<div class="col-md-10">
						<button type="submit" name="update_employee" value="true"  class="btn btn-primary">Update Employee Details</button>
					</div>
				</div>
				
            </form>
				
				<div class="form-group">
					<div class="col-md-10"><hr></div>
					<label for="mobile" class="col-md-12 col-form-label">Banking Information</label>
					<div class="col-md-10">
						<hr>
					</div>
				</div>

@include('admin.providers.payment_info')

<div class="form-group">
	<div class="col-md-10"><hr></div>
	<label for="mobile" class="col-md-12 col-form-label">Referal Bonus Details</label>
	<div class="col-md-10">
		<hr>
	</div>
</div>
@include('admin.providers.referal_bonus') 

<div class="form-group">
<div class="col-md-10"><hr></div>
<label for="mobile" class="col-md-12 col-form-label">My Badges</label>
<div class="col-md-10">
	<hr>
</div>
</div>
@include('admin.providers.my_badges') 

@include('admin.providers.working_hours') 


 
				
			<form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="PATCH">
				
				<div class="form-group">
					<div class="col-md-10"><hr></div>
					<label for="mobile" class="col-md-12 col-form-label">Captain Schedule</label>
					<div class="col-md-10"><hr></div>
				</div>
				
					<div class="form-group">
				
					<div class="col-md-12 mb-1">
						<div class="col-md-2">
							<label for="Monday" class="col-form-label">Select Start Hours</label>
							
						</div>
						
						
						<div class="col-md-2">
							<select class="form-control" name="start_time" required id="start_time" placeholder="hours">
							
								@for ($i = 1; $i <= 12; $i++)
									<option value="{{ $i }}:00" @if(isset($schedule) && $schedule->start_time == $i.':00') selected @endif >{{ $i }}:00</option>
								@endfor
								
							</select>
						</div>
						
						<div class="col-md-2">
							<select class="form-control" name="start_unit" required id="start_unit" placeholder="unit">
								
								<option value="AM" @if(isset($schedule) && $schedule->start_unit == "AM") selected @endif >AM</option>
								<option value="PM" @if(isset($schedule) && $schedule->start_unit == "PM") selected @endif >PM</option>
								
							</select>
						</div>
						
					</div>
					<div class="col-md-12">	
						<div class="col-md-2">
							<label for="Monday" class="col-form-label">Select End Hours</label>
							
						</div>
						
						
						<div class="col-md-2">
							<select class="form-control" name="end_time" required id="end_time" placeholder="hours">
								
								@for ($i = 1; $i <= 12; $i++)
									<option value="{{ $i }}:00" @if(isset($schedule) && $schedule->end_time == $i.':00') selected @endif > {{ $i }}:00</option>
								@endfor
								
							</select>
						</div>
						
						<div class="col-md-2">
							<select class="form-control" name="end_unit" required id="end_unit" placeholder="unit">
								
								<option value="AM" @if(isset($schedule) && $schedule->end_unit == "AM") selected @endif >AM</option>
								<option value="PM" @if(isset($schedule) && $schedule->end_unit == "PM") selected @endif >PM</option>
								
							</select>
						</div>
						
					</div>
				</div>
				
				
				<div class="form-group">
					<div class="col-md-12">
					
					<div class="col-md-2">
							<label for="Monday" class="col-form-label">Select Days</label>
					</div>
					
						@foreach ($weeks as $key => $week)
							<div class="col-md-1">
								<label for="{{$week}}" class="col-md-1 col-form-label">{{$week}}</label>
								<input class="form-control" type="checkbox" value="1" name="{{strtolower($week)}}"  id="{{strtolower($week)}}"  @if(isset($schedule) && $schedule->$key == 1) checked @endif  placeholder="{{$week}}">
							</div>
						@endforeach
					
					</div>
				</div>
				
				<div class="form-group">
					<label for="last_name" class="col-md-2 col-form-label text-right"></label>
					<div class="col-md-10">
						<button type="submit" name="update_schedule" value="true" class="btn btn-primary">Update Employee Schedule</button>
					</div>
				</div>
				
				</form>
				
				<!--=================Referal Details==============-->
				<!--==============================================-->
				
				@include('admin.providers.referal_details') 
				
				<!--==============================================-->
             
        </div>
    </div>
</div>

@endsection
