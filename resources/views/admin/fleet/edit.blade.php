@extends('admin.layout.base')

@section('title', 'Update Fleet ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
    	    <a href="{{ route('admin.fleet.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.fleet.update_fleet')</h5>

            <form class="form-horizontal" action="{{route('admin.fleet.update', $fleet->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label for="name" class="col-md-2 col-form-label">@lang('admin.account-manager.full_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $fleet->name }}" name="name" required id="name" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="company" class="col-md-2 col-form-label">@lang('admin.fleet.company_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $fleet->company }}" name="company" required id="company" placeholder="Company Name">
					</div>
				</div>


				<div class="form-group">
					
					<label for="logo" class="col-md-2 col-form-label">@lang('admin.fleet.company_logo')</label>
					<div class="col-md-10">
					@if(isset($fleet->logo))
                    	<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{img($fleet->logo)}}">
                    @endif
						<input type="file" accept="image/*" name="logo" class="dropify form-control-file" id="logo" aria-describedby="fileHelp">
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-md-2 col-form-label">@lang('admin.mobile')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ $fleet->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-2 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.fleet.update_fleet_owner')</button>
						<a href="{{route('admin.fleet.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
