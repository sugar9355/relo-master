@extends('admin.layout.base')

@section('title', 'Add Backend User ')

@section('content')

<div class="card">
	<div class="card-header border-bottom">
		<h3 class="m-0">Add Backend User
        <a href="{{ route('admin.system_user.index') }}" class="btn btn-outline-dark pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a></h3>
	</div>
    <div class="card-body pt-3">

            <form  action="{{route('admin.system_user.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<div class="form-row">
					<div class="form-group col-md-6">
						<label for="first_name">@lang('admin.first_name')</label>						
							<input class="form-control" type="text" value="{{ old('first_name') }}" name="first_name" required id="first_name" placeholder="First Name">						
					</div>

					<div class="form-group col-md-6">
						<label for="last_name">@lang('admin.last_name')</label>						
							<input class="form-control" type="text" value="{{ old('last_name') }}" name="last_name" required id="last_name" placeholder="Last Name">						
					</div>

					<div class="form-group col-md-4">
						<label for="email">@lang('admin.email')</label>						
							<input class="form-control" type="email" required name="email" value="{{old('email')}}" id="email" placeholder="Email">						
					</div>

					<div class="form-group col-md-4">
						<label for="password">@lang('admin.password')</label>						
							<input class="form-control" type="password" name="password" id="password" placeholder="Password">						
					</div>

					<div class="form-group col-md-4">
						<label for="password_confirmation">@lang('admin.account.password_confirmation')</label>						
							<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">						
					</div>

					<div class="form-group col-md-6">
						<label for="mobile">@lang('admin.mobile')</label>						
							<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">						
					</div>

					<div class="form-group col-md-6">
						<label for="role">Role</label>						
							<select name="role" class="form-control" id="role">
								@foreach($roles as $role)
									<option value="{{ $role->name }}">{{ $role->label }}</option>
								@endforeach
							</select>						
					</div>

					<div class="form-group col-md-12">

					<hr>					
							<a href="{{route('admin.system_user.index')}}" class="btn btn-outline-dark">@lang('admin.cancel')</a>
							<button type="submit" class="btn btn-primary">Add System User</button>						
					</div>
				</div>
			</form>
		</div>
    
</div>

@endsection
