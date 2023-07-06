@extends('admin.layout.base')

@section('title', 'Add User user_schedule')

@section('content')

    	<div class="card">
    		<div class="card-header">
    		<h3 class="mb-1">@lang('admin.users.Add_User') Schedule <a href="{{ route('admin.user_schedule.index') }}" class="btn btn-outline-dark pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a></h3>
            <hr class="mt-2 mb-0">
			</div>
			<div class="card-body">
            <form class="form-horizontal" action="{{route('admin.user_schedule.store')}}" method="POST" enctype="multipart/form-data" role="form">
			
            	{{csrf_field()}}
				
				<div class="form-row">				
					<div class="form-group col-md-6">						
						<label for="Monday" class="w-100 col-form-label">Select Hours</label>							
						<div class="row">
							<div class="col-md-8">
								<select class="form-control" name="hours" required id="hours" placeholder="hours">
								<option value="1:00">1:00</option>
								<option value="2:00">2:00</option>
								<option value="3:00">3:00</option>
								<option value="4:00">4:00</option>
								<option value="5:00">5:00</option>
								<option value="6:00">6:00</option>
								<option value="7:00">7:00</option>
								<option value="8:00">8:00</option>
								<option value="9:00">9:00</option>
								<option value="10:00">10:00</option>
								<option value="11:00">11:00</option>
								<option value="12:00">12:00</option>
							</select>						
							</div>
							<div class="col-md-4">
								<select class="form-control" name="unit" required id="unit" placeholder="unit">	
								<option value="AM">AM</option>
								<option value="PM">PM</option>								
							</select>
							</div>
						</div>							
					
					</div>
				</div>

				
				
				<div class="form-row col-8">

					<div class="form-group col">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" value="{{ old('monday') }}" name="monday" required id="monday" placeholder="Monday">
					  <label class="custom-control-label" for="monday">Monday</label>
					</div>
					</div>
					<div class="form-group col">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" value="{{ old('tuesday') }}" name="tuesday" required id="tuesday" placeholder="Tuesday">
					  <label class="custom-control-label" for="tuesday">Tuesday</label>
					</div>
					</div>
					<div class="form-group col">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" value="{{ old('wednesday') }}" name="wednesday" required id="wednesday" placeholder="Tuesday">
					  <label class="custom-control-label" for="wednesday">Wednesday</label>
					</div>
					</div>
					<div class="form-group col">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" value="{{ old('thursday') }}" name="thursday" required id="thursday" placeholder="Thursday">
					  <label class="custom-control-label" for="thursday">Thursday</label>
					</div>
					</div>
					<div class="form-group col">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" value="{{ old('friday') }}" name="friday" required id="friday" placeholder="Friday">
					  <label class="custom-control-label" for="friday">Friday</label>
					</div>
					</div>
					
				</div>
				

				<hr>
					
						<button type="submit" class="btn btn-primary">@lang('admin.users.Add_User') Schedule</button>
						<a href="{{route('admin.user_schedule.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
				
				
			</form>
			</div>
		</div>

@endsection
