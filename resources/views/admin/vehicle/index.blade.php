@extends('admin.layout.base')

@section('title', 'Vehicle ')

@section('content')

	<!-- Highlighting rows and columns -->
	<div class="card">
		<div class="card-header bg-white header-elements-sm-inline">
					<h6 class="card-title">Vehicles</h6>
					<div class="header-elements">
						<a type="button" href="{{ route('admin.vehicle.create') }}"  class="btn btn-dark text-white">Add New Vehicle</a>
					</div>
				</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
			<tr class="bg-dark text-white">
				<th>@lang('admin.id')</th>
				<th>@lang('admin.name')</th>
				<th>@lang('admin.type')</th>
				<th>@lang('admin.color')</th>
				<th>@lang('admin.fuel_percentage')</th>
				<th>@lang('admin.current_miles')</th>
				<th>@lang('admin.fuel_volume')</th>
				<th>@lang('admin.fuel_type')</th>
				<th>@lang('admin.volume')</th>
				<th class="text-center">@lang('admin.action')</th>
			</tr>
			</thead>
			 <tbody>
                    @foreach($vehicles as $index => $vehicle)
					<tr>
						<td>{{ $index + 1 }}</td>
						<td>{{ $vehicle->name }}</td>
						<td>{{ $vehicle->type }}</td>
						<td>{{ $vehicle->color }}</td>
						
							<td>
							@if(isset($vehiclesPetrolArray[$vehicle->samsara_id]))
								{{ $vehiclesPetrolArray[$vehicle->samsara_id] }}
							@endif
							</td>
						
						
						<td>{{ isset($vehicle->serviceLogs->miles) ? (int)$vehicle->serviceLogs->miles : NULL }}</td>
						<td>{{ $vehicle->fuel_volume }}</td>
						<td>{{ $vehicle->fuel_type }}</td>
						<td>{{ $vehicle->volume }}</td>
						<td>
						<div class="btn-group ml-2">
						
							<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

							<div class="dropdown-menu">
								<a href="{{ Route('admin.vehicle.service', $vehicle->id) }}" class="dropdown-item"><i class="icon-gear"></i> @lang('admin.vehicle_service')</a>
								<a href="{{ Route('admin.vehicle.sticker', $vehicle->id) }}" class="dropdown-item"><i class="icon-ticket"></i> @lang('admin.sticker')</a>
								<a href="{{ Route('admin.vehicle.document', $vehicle->id) }}" class="dropdown-item"><i class="icon-files-empty"></i> @lang('admin.document.document')</a>
								<a href="{{ Route('admin.vehicle.edit', $vehicle->id) }}" class="dropdown-item"><i class="icon-pencil"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $vehicle->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</div>

								<!-- Modal -->
								<div id="delete_{{ $vehicle->id }}" class="modal fade" role="dialog">
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
										<form action="{{ route('admin.vehicle.destroy', $vehicle->id) }}" method="POST">
											{{ csrf_field() }}
											<input type="hidden" name="_method" value="DELETE">
											<button type="submit" name="delete_vehicle" value="true" class="btn btn-success" >Yes</button>
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
