@extends('admin.layout.base')

@section('title', 'Presets ')

@section('content')

<!-- Highlighting rows and columns -->
	<div class="card">
		<div class="card-header bg-white header-elements-sm-inline">
					<h6 class="card-title">@lang('admin.preset.presets')</h6>
					<div class="header-elements">
						<a type="button" href="{{ route('admin.preset.create') }}"  class="btn btn-dark text-white">Add New Preset</a>
					</div>
				</div>
</div>
		
		
		<div class="row">
 @foreach($presets as $index => $preset)
 @php
	 $item_ids = explode(',', $preset->item_ids);
	 $item_quantities = explode(',', $preset->item_quantity);
	 $quantities = [];
	 foreach ($item_ids as $k => $id) {
		if (isset($item_quantities[$k])) {
			$quantities[$id] = ($item_quantities[$k] == '') ? 0 : $item_quantities[$k];
		} else {
			$quantities[$id] = 0;
		}
	 }
 @endphp
	
		<div class="col-md-4">
			<div class="card border-top-info ">
				<div class="card-header header-elements-inline bg-white">
					<span class="badge badge-flat border-primary text-danger-600 badge-icon"><i class="icon-box"></i></span>
					<h6 class="card-title font-weight-semibold">{{ $preset->name }}</h6>
					<ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
						<li class="list-inline-item dropdown">
							<a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>

							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ Route('admin.preset.edit', $preset->id) }}" class="dropdown-item"><i class="icon-pencil5 text-primary"></i> @lang('admin.edit')</a>
								<button data-toggle="modal" data-target="#delete_{{ $preset->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
							</div>
						</li>
					</ul>
				</div>

				<div class="card-body">
					<h6 class="mb-0">
						@foreach($preset->items as $item)
						<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-furniture"></i> {{$item->name}} - {{$quantities[$item->id]}}</span>
						@endforeach
					</h6>
				</div>
			</div>
		</div>
		
	<!-- Modal -->
	<div id="delete_{{ $preset->id }}" class="modal fade" role="dialog">
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
			<form action="{{ route('admin.preset.destroy', $preset->id) }}" method="POST">
				{{ csrf_field() }}
				<input type="hidden" name="_method" value="DELETE">
				<button type="submit" class="btn btn-success" >Yes</button>
			</form>
			<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
		  </div>
		</div>

	  </div>
	</div>
   @endforeach
   </div>
	
	<!-- /highlighting rows and columns -->

@endsection