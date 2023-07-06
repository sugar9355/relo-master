@extends('admin.layout.base')

@section('title', 'Add Provider ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
            <a href="{{ route('admin.provider.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.provides.add_provider')</h5>

            <form class="form-horizontal" action="{{route('admin.provider.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group">
					<label for="first_name" class="col-md-12 col-form-label">@lang('admin.first_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="First Name">
					</div>
				</div>

				<div class="form-group">
					<label for="last_name" class="col-md-12 col-form-label">@lang('admin.last_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Last Name">
					</div>
				</div>



				<div class="form-group">
					<label for="email" class="col-md-12 col-form-label">@lang('admin.email')</label>
					<div class="col-md-10">
						<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-md-12 col-form-label">@lang('admin.password')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password" id="password" placeholder="Password">
					</div>
				</div>

				<div class="form-group">
					<label for="password_confirmation" class="col-md-12 col-form-label">@lang('admin.provides.password_confirmation')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group">
					<label for="picture" class="col-md-12 col-form-label">@lang('admin.picture')</label>
					<div class="col-md-10">
						<input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-md-12 col-form-label">@lang('admin.mobile')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>
				
				<div class="form-group">
					<label for="mobile" class="col-md-12 col-form-label">Captain Schedule</label>
					<div class="col-md-10">
						<hr>
					</div>
				</div>
				
					<div class="form-group">
				
					<div class="col-md-12">
						<div class="col-md-1">
							<label for="Monday" class="col-md-1 col-form-label">Select Hours</label>
							
						</div>
						
						
						<div class="col-md-2">
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
						
						<div class="col-md-2">
							<select class="form-control" name="unit" required id="unit" placeholder="unit">
								
								<option value="AM">AM</option>
								<option value="PM">PM</option>
								
							</select>
						</div>
					</div>
				</div>
				
				<div class="form-group">
				
					<div class="col-md-12">
							<div class="col-md-1">
								<label for="Monday" class="col-md-1 col-form-label">Monday</label>
								<input class="form-control" type="checkbox" value="1" name="monday"  id="monday" placeholder="Monday">
							</div>
							<div class="col-md-1">
								<label for="Monday" class="col-md-12 col-form-label">Tuesday</label>
								<input class="form-control" type="checkbox" value="1" name="tuesday"  id="tuesday" placeholder="Tuesday">
							</div>
							<div class="col-md-1">
								<label for="Monday" class="col-md-12 col-form-label">Wednesday</label>
								<input class="form-control" type="checkbox" value="1" name="wednesday"  id="wednesday" placeholder="Tuesday">
							</div>
							<div class="col-md-1">
								<label for="Monday" class="col-md-12 col-form-label">Thursday</label>
								<input class="form-control" type="checkbox" value="1" name="thursday"  id="thursday" placeholder="Thursday">
							</div>
							<div class="col-md-1">
								<label for="Monday" class="col-md-12 col-form-label">Friday</label>
								<input class="form-control" type="checkbox" value="1" name="friday"  id="friday" placeholder="Friday">
							</div>
					</div>
				</div>


				<div class="form-group">
					<label for="zipcode" class="col-md-12 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.provides.add_provider')</button>
						<a href="{{route('admin.provider.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
