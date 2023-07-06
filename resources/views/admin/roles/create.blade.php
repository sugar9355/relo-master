@extends('admin.layout.base')

@section('title', 'Add Role ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
            <a href="{{ route('admin.role.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">Add Role</h5>

            <form class="form-horizontal" action="{{route('admin.role.store')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
				<div class="form-group">
					<label for="name" class="col-md-6 col-form-label">@lang('admin.name')</label>
					<div class="col-md-6">
						<input class="form-control" type="text" value="{{ old('name') }}" name="name" required id="name" placeholder="Name">
					</div>
				</div>

				<div class="form-group">
					<label for="label" class="col-md-6 col-form-label">Label</label>
					<div class="col-md-6">
						<input class="form-control" type="text" value="{{ old('label') }}" name="label" required id="label" placeholder="Label">
					</div>
				</div>
				
				<div class="form-group">
						<label for="label" class="col-md-6 col-form-label">Hourly Rate</label>
						<div class="col-md-6">
							<input class="form-control" type="text" value="" name="hourly_rate" required id="hourly_rate" placeholder="Hourly Rate">
						</div>
					</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-6 col-form-label"></label>
					<div class="col-md-6">
						<button type="submit" class="btn btn-primary">Add Role</button>
						<a href="{{route('admin.role.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
