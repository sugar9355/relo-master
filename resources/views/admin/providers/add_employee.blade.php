<div class="card card-body">

	  
	<h4 class="m-0">Employee Details</h4>
  
	<hr>

<form action="{{route('admin.provider.store')}}" method="POST" enctype="multipart/form-data" role="form">
{{csrf_field()}}

<div class="form-row">
	<div class="form-group col-md-6">
		<label for="first_name" class="">@lang('admin.first_name')</label>
		<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="First Name">
	</div>

	<div class="form-group col-md-6">
		<label for="last_name" class="">@lang('admin.last_name')</label>
		<input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Last Name">
	</div>
	
	<div class="form-group col-md-6">
		<label for="mobile" class="">@lang('admin.mobile')</label>
		<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
	</div>

	<div class="form-group col-md-6">
		<label for="email" class="">@lang('admin.email')</label>
		<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">
	</div>
	
	<div class="form-group col-md-6">
		<label for="password" class="">@lang('admin.password')</label>
		<input class="form-control" type="password" name="password" id="password" placeholder="Password">
	</div>
	
	<div class="form-group col-md-6">
		<label for="password_confirmation" class="">@lang('admin.provides.password_confirmation')</label>
		<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
	</div>
	
	<div class="form-group col-md-12">
		<label for="picture" class="">@lang('admin.picture')</label>
		<input type="file" accept="image/*" name="avatar" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
	</div>

	<div class="form-group col-md-4">
		<label for="">Role</label>
		<select class="form-control" id="role" name="role">
			<option disabled selected>Role</option>
			@foreach ($roles as $role)
				<option value="{{$role->id}}">{{$role->name}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-md-4">
		<label for="">Level</label>
		<select class="form-control" id="level" name="level">
			<option disabled selected>Level</option>
			@foreach ($levels as $level)
				<option value="{{$level->id}}">Level - {{$level->level}}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group col-md-4">
		<label for="hourly_rate">Hourly Rate(Optional)</label>
		<input type="number" class="form-control" id="hourly_rate" name="hourly_rate" placeholder="ex: 15" />
	</div>

</div>

	<hr>
		<button type="submit" class="btn btn-outline-dark">Cancel</button>
		<button type="submit" class="btn btn-primary ml-3">Submit <i class="icon-paperplane ml-2"></i></button>

	
</form>


</div>

