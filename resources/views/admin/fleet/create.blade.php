@extends('admin.layout.base')

@section('title', 'Add Fleet Owner ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
            <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.fleet.add_fleet_owner')</h5>

            <form class="form-horizontal" action="{{route('admin.fleet.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group">
					<label for="name" class="col-md-12 col-form-label">@lang('admin.account-manager.full_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="company" class="col-md-12 col-form-label">@lang('admin.fleet.company_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ old('company') }}" name="company" required id="company" placeholder="Company Name">
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
					<label for="password_confirmation" class="col-md-12 col-form-label">@lang('admin.account-manager.password_confirmation')</label>
					<div class="col-md-10">
						<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-type Password">
					</div>
				</div>

				<div class="form-group">
					<label for="logo" class="col-md-12 col-form-label">@lang('admin.fleet.company_logo')</label>
					<div class="col-md-10">
						<input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo" aria-describedby="fileHelp">
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
						<button type="submit" class="btn btn-primary">@lang('admin.fleet.add_fleet_owner')</button>
						<a href="{{route('admin.fleet.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
