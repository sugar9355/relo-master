@extends('admin.layout.base')

@section('title', 'Add User ')

@section('content')

<div class="card">
	<div class="card-header">
		<h5>@lang('admin.users.Add_User')</h5>
 		<a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>
	</div>
    <div class="card-body">
            <form class="form-horizontal" action="{{route('admin.user.store')}}" method="POST" enctype="multipart/form-data" role="form">
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
					<label for="password_confirmation" class="col-md-12 col-form-label">@lang('admin.account.password_confirmation')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group">
					<label for="picture" class="col-md-12 col-form-label">@lang('admin.picture')</label>
					<div class="col-md-10">
						<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-md-12 col-form-label">@lang('admin.mobile')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ old('mobile') }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-12 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.users.Add_User')</button>
						<a href="{{route('admin.user.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
	
    </div>
</div>

@endsection
