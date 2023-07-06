@extends('admin.layout.base')

@section('title', 'Workers ')

@section('content')
<!-- Highlighting rows and columns -->
	<div class="card">
<div class="card-header bg-white header-elements-sm-inline">
	<h6 class="card-title"> Workers</h6>
	<div class="header-elements">
		<a type="button" href="{{ route('admin.worker.create') }}"  class="btn btn-dark text-white">Add New Workers</a>
	</div>
</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
				<tr class="bg-dark text-white">
					   <th>@lang('admin.id')</th>
                        <th>@lang('admin.provides.full_name')</th>
                        <th>@lang('admin.email')</th>
                        <th>@lang('admin.mobile')</th>
                        <th>@lang('admin.provides.total_requests')</th>
                        <th>@lang('admin.provides.accepted_requests')</th>
                        <th>@lang('admin.provides.cancelled_requests')</th>
                        <th>@lang('admin.provides.online')</th>
						<th>Enable</th>
                        <th class="text-center">@lang('admin.action')</th>
				</tr>
			</thead>
			 <tbody>
                      @foreach($providers as $index => $provider)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $provider->first_name }} {{ $provider->last_name }}</td>
                        <td>{{ $provider->email }}</td>
                        <td>{{ $provider->mobile }}</td>
{{--                        <td>{{ Provider_total_requests_count($provider->id) }}</td>--}}
                        <td>0</td>
{{--                        <td>{{ Provider_accepted_requests_count($provider->id) }}</td>--}}
                        <td>0</td>
{{--                        <td>{{ Provider_total_requests_count($provider->id) - Provider_accepted_requests_count($provider->id) }}</td>--}}
                        <td>0</td>
                        <td>
                            @if($provider->device)
                                @if($provider->device->status == 'active')
                                    <label class="btn btn-block btn-primary">Yes</label>
                                @else
                                    <label class="btn btn-block btn-warning">No</label>
                                @endif
                            @else
                                <label class="btn btn-block btn-danger">N/A</label>
                            @endif
                        </td>
                        <td>
							@if($provider->status == 'approved')
								<a class="btn btn-danger btn-block" href="{{ route('admin.worker.status', $provider->id ) }}">@lang('Disable')</a>
							@else
								<a class="btn btn-success btn-block" href="{{ route('admin.worker.status', $provider->id ) }}">@lang('Enable')</a>
							@endif
						</td>
						<td>						
						<div class="btn-group ml-2">
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<a href="{{ route('admin.provider.request', $provider->id) }}" class="dropdown-item"><i class="icon-history text-info"></i> @lang('admin.History')</a>
								<a href="{{ route('admin.provider.statement', $provider->id) }}" class="dropdown-item"><i class="icon-file-text3 text-teal"></i> @lang('admin.Statements')</a>
								<a href="{{ route('admin.worker.edit', $provider->id) }}" class="dropdown-item"><i class="icon-pencil text-primary"></i> @lang('admin.edit')</a>
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
									 <form action="{{ route('admin.worker.destroy', $provider->id) }}" method="POST">
										{{ csrf_field() }}
										<input type="hidden" name="_method" value="DELETE">
										<button type="submit" class="btn btn-success" >Yes</button>
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
	<!-- /highlighting rows and columns -->

@endsection