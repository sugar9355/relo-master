@extends('admin.layout.base')

@section('title', 'Providers ')

@section('content')
<div class="card">

<div class="card-header bg-white header-elements-sm-inline">
	<h6 class="card-title"> Employee</h6>
	<div class="header-elements">
		@if(Setting::get('demo_mode') == 1)<div class="col-md-12" style="height:50px;color:red;">** Demo Mode : No Permission to Edit and Delete.</div>@endif
		<h5 class="mb-1">@if(Setting::get('demo_mode', 0) == 1) <span class="pull-right">(*personal information hidden in demo)</span> @endif</h5>
		
		<a type="button" href="{{ route('admin.provider.create') }}"  class="btn btn-dark text-white">Add Employee</a>
		<a href="assign_badges" style="margin-left: 1em;" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Cron</a>		
		
	</div>
</div>

<div class="card-body">
<table class="table table-striped table-bordered">
	<thead class="bg-dark">
		<tr>
			<th>@lang('admin.id')</th>
			<th>Role</th>
			<th>@lang('admin.provides.full_name')</th>
			<th>@lang('admin.email')</th>
			<th>@lang('admin.mobile')</th>
			<th>Hourly Rate</th>
			<th>Payment Claim</th>
			
			<th>@lang('admin.provides.accepted_requests')</th>
			<th>@lang('admin.provides.cancelled_requests')</th>
			
			
			<th class="text-center">@lang('admin.action')</th>
		</tr>
	</thead>
	<tbody>
	@foreach($employees as $index => $provider)
		<tr>
			<td>{{ $index + 1 }}</td>
			<td>{{ $provider->role_name }}</td>
			<td>{{ $provider->first_name }} {{ $provider->last_name }}</td>
			@if(Setting::get('demo_mode', 0) == 1)
			<td>{{ substr($provider->email, 0, 3).'****'.substr($provider->email, strpos($provider->email, "@")) }}</td>
			@else
			<td>{{ $provider->email }}</td>
			@endif
			@if(Setting::get('demo_mode', 0) == 1)
			<td>+919876543210</td>
			@else
			<td>{{ $provider->mobile }}</td>
			@endif
			<td>
			@if(!empty($provider->hourly_rate))${{$provider->hourly_rate}}@endif
			</td>
			<td> 
			@if($provider->hours != '')
				
				hours: {{$provider->hours }} <br>
				amount: {{ ($provider->hours * $provider->hourly_rate) }} <br>
				
			@else
			 <span class="badge bg-danger-400">Not Claimed</span>
			@endif
				
			</td>
			<td>{{ total_accepted_jobs_count(array('captain_id' => $provider->id)) }}</td>
			<td></td>
		   
			<td>
			
			<div class="btn-group ml-2">
				<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

				<div class="dropdown-menu">
					<a href="{{ Route('admin.provider.request', $provider->id) }}" class="dropdown-item"><i class="icon-history text-info"></i> @lang('admin.History')</a>
					<a href="{{ Route('admin.provider.statement', $provider->id) }}" class="dropdown-item"><i class="icon-file-pdf  text-teal"></i> @lang('admin.Statements')</a>
					@if( Setting::get('demo_mode') == 0)
						<a href="{{ Route('admin.provider.edit', $provider->id) }}" class="dropdown-item"><i class="icon-pencil text-primary"></i> @lang('admin.edit')</a>
					@endif
					<button data-toggle="modal" data-target="#delete_{{ $provider->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
				</div>
			</div>
			<!-- Modal -->
			<div id="delete_{{ $provider->id }}" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header text-center">
					<h4 class="modal-title">Are You Sure ?</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>
				  <div class="modal-body  text-center">
					<hr>
						Do you want to delete Selected Row ?
					<hr>
				  </div>
				  <div class="modal-footer">
					 <form action="{{ route('admin.provider.destroy', $provider->id) }}" method="POST">
						{{ csrf_field() }}
						<input type="hidden" name="_method" value="DELETE">
						@if( Setting::get('demo_mode') == 0)
							<button type="submit" class="btn btn-success" >Yes</button>
						@endif
					</form>
					
					<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
				  </div>
				</div>

			  </div>
			</div>
			
			</td>
		</tr>
	@endforeach
	</tbody>
  
</table>
</div>
<div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center"></div>
</div>
@endsection