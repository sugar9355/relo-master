<div class="row row-md">
<div class="col-lg-2 col-md-4 col-xs-6">
	<div class="box box-block bg-white tile tile-1 mb-2">
		<div class="t-icon right"><span class="bg-danger"></span><i class="ti-rocket"></i></div>
		<div class="t-content">
			<h1 class="mb-1">{{$all}}</h1>
			<h6 class="text-uppercase">@lang('admin.dashboard.Rides')</h6>
			
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-4 col-xs-6">
	<div class="box box-block bg-white tile tile-1 mb-2">
		<div class="t-icon right"><span class="bg-success"></span><i class="ti-bar-chart"></i></div>
		<div class="t-content">
			<h1 class="mb-1">{{$pending}}</h1>
			<h6 class="text-uppercase">@lang('admin.dashboard.Revenue')</h6>
			
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-4 col-xs-6">
	<div class="box box-block bg-white tile tile-1 mb-2">
		<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
		<div class="t-content">
			<h1 class="mb-1">{{$unAssigned}}</h1>
			<h6 class="text-uppercase">@lang('admin.dashboard.service')</h6>
			
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-4 col-xs-6">
	<div class="box box-block bg-white tile tile-1 mb-2">
		<div class="t-icon right"><span class="bg-warning"></span><i class="ti-archive"></i></div>
		<div class="t-content">
			<h1 class="mb-1">{{$assigned}}</h1>
			<h6 class="text-uppercase">@lang('admin.dashboard.total_rides')</h6>
			
		</div>
	</div>
</div>
<div class="col-lg-2 col-md-4 col-xs-6">
	<div class="box box-block bg-white tile tile-1 mb-2">
		<div class="t-icon right"><span class="bg-primary"></span><i class="ti-view-grid"></i></div>
		<div class="t-content">
			<h1 class="mb-1">{{$completed}}</h1>
			<h6 class="text-uppercase">@lang('admin.dashboard.rides')</h6>
			
		</div>
	</div>
</div>
</div>
