@extends('admin.layout.base')

@section('title', 'Change Password ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >

			<h5 style="margin-bottom: 2em;">@lang('admin.account.change_password')</h5>

            <form class="form-horizontal" action="{{route('admin.password.update')}}" method="POST" role="form">
            	{{csrf_field()}}

            	<div class="form-group">
					<label for="old_password" class="col-md-12 col-form-label">@lang('admin.account.old_password')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="old_password" id="old_password" placeholder="Old Password">
					</div>
				</div>

				<div class="form-group">
					<label for="password" class="col-md-12 col-form-label">@lang('admin.account.password')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password" id="password" placeholder="New Password">
					</div>
				</div>

				<div class="form-group">
					<label for="password_confirmation" class="col-md-12 col-form-label">@lang('admin.account.password_confirmation')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type New Password">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-12 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.account.change_password')</button>
					</div>
				</div>

			</form>
		</div>
    </div>
</div>

@endsection
