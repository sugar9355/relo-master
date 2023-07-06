@extends('admin.layout.base')

@section('title', 'Update User ')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.user.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

				<h5 style="margin-bottom: 2em;">Update User</h5>

				<form class="form-horizontal" action="{{route('admin.user.update', $user->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label for="first_name" class="col-md-2 col-form-label">First Name</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $user->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
						</div>
					</div>

					<div class="form-group">
						<label for="last_name" class="col-md-2 col-form-label">Last Name</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ $user->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
						</div>
					</div>


					<div class="form-group">

						<label for="picture" class="col-md-2 col-form-label">Picture</label>
						<div class="col-md-10">
							@if(isset($user->picture))
								<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$user->picture}}">
							@endif
							<input type="file" accept="image/*" name="picture" class="dropify form-control-file" id="picture" aria-describedby="fileHelp">
						</div>
					</div>

					<div class="form-group">
						<label for="mobile" class="col-md-2 col-form-label">Mobile</label>
						<div class="col-md-10">
							<input class="form-control" type="number" value="{{ $user->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
						</div>
					</div>

					<div class="form-group">
						<label for="zipcode" class="col-md-2 col-form-label"></label>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">Update User</button>
							<a href="{{route('admin.user.index')}}" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
