<div class="row mb-4">
	<div class="col">
		<!-- Members online -->
		<div class="card bg-primary-800 mb-0">
			<div class="card-body">
				<div class="d-flex">
					<h2 class="mb-0 w-50 h1">{{$all}}</h2><i class="fa fa-globe mr-3 fa-2x ml-5"></i>				
				</div>
				<div>
					@lang('admin.dashboard.Rides')
					<div class="font-size-sm opacity-75">489 avg</div>
				</div>
			</div>
		</div>
		<!-- /members online -->
	</div>
	
	<div class="col">
		<!-- Members online -->
		<div class="card bg-orange-800 mb-0">
			<div class="card-body">
				<div class="d-flex">
					<h2 class="mb-0 w-50 h1">{{$pending}}</h2> <i class="mi-alarm ml-5 mi-2x"></i>					
				</div>
				<div>
					@lang('admin.dashboard.Revenue')
					<div class="font-size-sm opacity-75">489 avg</div>
				</div>
			</div>
		</div>
		<!-- /members online -->
	</div>
	
	<div class="col">
		<!-- Members online -->
		<div class="card bg-danger-800 mb-0">
			<div class="card-body">
				<div class="d-flex">
					<h2 class="mb-0 w-50 h1">{{$unAssigned}}</h2> <i class="fa fa-stop-circle ml-5 fa-2x"></i>					
				</div>
				<div>
				@lang('admin.dashboard.service')
					<div class="font-size-sm opacity-75">489 avg</div>
				</div>
			</div>
		</div>
		<!-- /members online -->
	</div>
	
	<div class="col">
		<!-- Members online -->
		<div class="card bg-violet-800 mb-0">
			<div class="card-body">
				<div class="d-flex">
					<h2 class="mb-0 w-50 h1">{{$assigned}}</h2> <i class="mi-timelapse ml-5 mi-2x"></i>					
				</div>
				<div>
					@lang('admin.dashboard.total_rides')
					<div class="font-size-sm opacity-75">489 avg</div>
				</div>
			</div>
		</div>
		<!-- /members online -->
	</div>
	
	<div class="col">
		<!-- Members online -->
		<div class="card bg-teal-800 mb-0">
			<div class="card-body">
				<div class="d-flex">
					<h2 class="mb-0 w-50 h1">{{$completed}}</h2> <i class="icon-trophy2 ml-5 icon-2x"></i>					
				</div>
				<div>
					@lang('admin.dashboard.rides')
					<div class="font-size-sm opacity-75">489 avg</div>
				</div>
			</div>
		</div>
		<!-- /members online -->
	</div>
	

</div>
