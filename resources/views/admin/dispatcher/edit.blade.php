@extends('admin.layout.base')

@section('title', 'Update Dispatcher ')

@section('content')

<div class="card">
    <div class="card-body">
    	<div >
    	    <a href="{{ route('admin.dispatch-manager.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">@lang('admin.dispatcher.update_dispatcher')</h5>

            <form class="form-horizontal" action="{{route('admin.dispatch-manager.update', $dispatcher->id )}}" method="POST" enctype="multipart/form-data" role="form">
            	{{csrf_field()}}
            	<input type="hidden" name="_method" value="PATCH">
				
				<div class="form-group">
					<label for="name" class="col-md-2 col-form-label">@lang('admin.account-manager.full_name')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $dispatcher->name }}" name="name" required id="name" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="email" class="col-md-2 col-form-label">@lang('admin.email')</label>
					<div class="col-md-10">
						<input class="form-control" type="text" value="{{ $dispatcher->email }}" readonly="true" name="email" required id="email" placeholder="Full Name">
					</div>
				</div>

				<div class="form-group">
					<label for="mobile" class="col-md-2 col-form-label">@lang('admin.mobile')</label>
					<div class="col-md-10">
						<input class="form-control" type="number" value="{{ $dispatcher->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
					</div>
				</div>

				<div class="form-group">
					<label for="zipcode" class="col-md-2 col-form-label"></label>
					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">@lang('admin.dispatcher.update_dispatcher')</button>
						<a href="{{route('admin.dispatch-manager.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>

@endsection
