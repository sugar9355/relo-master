@extends('admin.layout.base')

@section('title', 'Vehicle Documents')

@section('content')
	<div class="card">
		<div class="card-body">
			<div >
				<h5 class="mb-1">
					@lang('admin.include.document_view')
				</h5>
				<form class="form-horizontal" action="{{ Route('admin.vehicle.searchDocument') }}" method="POST" role="form">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="type" class="col-md-12 col-form-label">@lang('admin.selectVehicle')</label>
						<div class="col-md-10">
							<select class="form-control" name="vehicle" id="vehicle">
								<option value="">Select Vehicle</option>
								@foreach($vehicles as $vehicle)
									<option value="{{ $vehicle->id }}">{{ $vehicle->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.search')</button>
						</div>
					</div>
				</form>
				@if(isset($vehicleDocuments) && $vehicleDocuments)
					<table class="table table-striped table-bordered dataTable" id="table-2">
						<thead>
						<tr>
							<th>@lang('admin.sr')</th>
							<th>@lang('admin.document.document')</th>
						</tr>
						</thead>
						<tbody>
						<?php $i = 1; ?>
						@foreach($vehicleDocuments as $vehicleDocument)
							<tr>
								<td> {{ $i++ }} </td>
								<td><a href="{{ $vehicleDocument->image }}" class="btn btn-info" target="_blank">view</a></td>
							</tr>
						@endforeach
						</tbody>
						<tfoot>
						<tr>
							<th>@lang('admin.sr')</th>
							<th>@lang('admin.document.document')</th>
						</tr>
						</tfoot>
					</table>
				@endif
			</div>
		</div>
	</div>
@endsection
