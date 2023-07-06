@extends('admin.layout.base')

@section('title', 'Update Profile ')

@section('content')

<div class="card">
    <div class="card-body">

			<h3>@lang('admin.account.update_profile')</h3>
			<hr>

            <form class="m-0" class="form-horizontal" action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}

            	<div class="form-row">

				<div class="form-group col-md-6">
					<label for="name" class="form-label">@lang('admin.name')</label>
						<input class="form-control" type="text" value="{{ Auth::guard('admin')->user()->name }}" name="name" required id="name" placeholder=" Name">
				</div>

				<div class="form-group col-md-6">
					<label for="email" class="form-label">@lang('admin.email')</label>
						<input class="form-control" type="email" required name="email" value="{{ isset(Auth::guard('admin')->user()->email) ? Auth::guard('admin')->user()->email : '' }}" id="email" placeholder="Email">
				</div>
				

				<div class="form-group col-md-6">
					<label for="picture" class="form-label">@lang('admin.picture')</label>						
						<input type="file" accept="image/*" name="picture" class=" dropify form-control-file" aria-describedby="fileHelp">
				</div>
				<div class="form-group col-md-6">
					@if(isset(Auth::guard('admin')->user()->picture))
                    	<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Auth::guard('admin')->user()->picture}}" class="img-thumbnail">
                    @endif
				</div>
				</div>

				<hr>
					<button type="submit" class="btn btn-primary">@lang('admin.account.update_profile')</button>
				
			</form>
    </div>
</div>

@endsection
