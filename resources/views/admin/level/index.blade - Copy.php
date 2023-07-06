@extends('admin.layout.base')

@section('title', 'Level')

@section('content')
<!-- Highlighting rows and columns -->
	<div class="card">
		<div class="card-header bg-white header-elements-sm-inline">
					<h6 class="card-title"> @lang('admin.vehicle.Vehicle_Schedule')</h6>
					<div class="header-elements">
						<a type="button" href="{{ route('admin.level.create') }}"  class="btn btn-dark text-white">Add New Level</a>
					</div>
				</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
				<tr class="bg-dark text-white">
					 <th>@lang('admin.id')</th>
                        <th>@lang('admin.name')</th>
                        <th>Bonus</th>
						<th>Referal Bonus</th>
                        <th>Level</th>
                        <th>Badges Required</th>
                        <th>@lang('admin.action')</th>
				</tr>
			</thead>
			 <tbody>
                      @foreach($levels as $index => $level)
					<tr>
						     <td>{{ $index + 1 }}</td>
                        <td>{{ $level->name }}</td>
                        <td>{{ $level->bonus }}</td>
						<td>{{ $level->ref_bonus }}</td>
                        <td>{{ $level->level }}</td>
                        <td>
							@foreach($designation as $factor)
								@if($factor->level_id == $level->id)
									{{ $factor->factor_name }}<br> 
								@endif
							@endforeach
						</td>
						<td class="text-center">
						<div class="btn-group ml-2">
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<a href="{{ Route('admin.vehicle_schedule.edit', $level->id) }}" class="dropdown-item"><i class="icon-pencil"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $level->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</div>

							<!-- Modal -->
							<div id="delete_{{ $level->id }}" class="modal fade" role="dialog">
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
									 <form action="{{ route('admin.level.destroy', $level->id) }}" method="POST">
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
