@extends('admin.layout.base')

@section('title', 'Update Account Manager ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
    	    <a href="{{ route('admin.account-manager.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.account-manager.update_account_manager')</h5>

            <form class="form-horizontal" action="{{route('admin.account-manager.update', $account->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				
				<div class="form-group">
					<label for="name" class="col-md-2 col-form-label">@lang('admin.account-manager.full_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $account->name }}" name="name" required id="name" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-md-2 col-form-label">@lang('admin.email')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $account->email }}" readonly="true" name="email" required id="email" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-md-2 col-form-label">@lang('admin.mobile')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ $account->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-2 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.account-manager.update_account_manager')</button>
						<a href="{{route('admin.account-manager.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
