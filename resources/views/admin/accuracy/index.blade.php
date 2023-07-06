@extends('admin.layout.base')

@section('title', 'Accuracy ')

@section('content')

	<!-- Highlighting rows and columns -->
	<div class="card">
		<div class="card-header bg-white header-elements-sm-inline">
					<h6 class="card-title">Accuracys</h6>
					
				</div>

		<div class="card-body">
			<table class="table table-striped table-bordered">
			<thead>
			<tr class="bg-dark text-white">
				<th>@lang('admin.id')</th>
				<th>@lang('admin.name')</th>
				<th>Label</th>
				<th class="text-center">Minimum Value</th>
				<th class="text-center">Maximum Value</th>
				<th class="text-center">@lang('admin.action')</th>
			</tr>
			</thead>
			 <tbody>
                    @foreach($accuracys as $index => $accuracy)
					<tr>
						<td>{{ $index + 1 }}</td>
						<td>{{ $accuracy->name }}</td>
						<td>{{ $accuracy->label }}</td>
						<td class="text-center">{{ $accuracy->min }}</td>
						<td class="text-center">{{ $accuracy->max }}</td>
						<td class="text-center">
						<div class="btn-group ml-2 ">
							<a class="btn btn-primary" href="{{ Route('admin.accuracy.edit', $accuracy->id) }}" class="dropdown-item"><i class="icon-pencil"></i> @lang('admin.edit')</a>
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
