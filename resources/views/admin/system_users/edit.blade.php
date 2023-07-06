@extends('admin.layout.base')

@section('title', 'Update Backend User ')

@section('content')

	<div class="card">
		<div class="card-body">
							

				<h3 class="m-0">Update Backend User <a href="{{ route('admin.system_user.index') }}" class="btn btn-outline-dark pull-right"><i class="fa fa-angle-left"></i> Back</a></h3>
				<hr>

				<form class="form-horizontal" action="{{route('admin.system_user.update', $systemUser->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">

					<div class="form-row">
					<div class="form-group col-md-6">
						<label for="first_name" class="form-label">First Name</label>
						
							<input class="form-control" type="text" value="{{ $systemUser->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
						
					</div>

					<div class="form-group col-md-6">
						<label for="last_name" class="form-label">Last Name</label>
						
							<input class="form-control" type="text" value="{{ $systemUser->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
						
					</div>

					<div class="form-group col-md-6">
						<label for="mobile" class="form-label">Mobile</label>
						
							<input class="form-control" type="number" value="{{ $systemUser->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
						
					</div>

					<div class="form-group col-md-6">
						<label for="role" class="form-label">Roles</label>				
							<select name="role" class="form-control" id="role">
								<option value="">Admin</option>
								<option value="">Fleet Manager</option>
								<option value="">Hauler</option>
								<option value="">Sales Rep</option>
							</select>
					</div>
					</div>

					<hr>

						<button type="submit" class="btn btn-primary">Update User</button>
						<a href="{{route('admin.system_user.index')}}" class="btn btn-outline-dark">Cancel</a>
				</form>
			</div>

	</div>

@endsection
