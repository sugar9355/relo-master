@extends('admin.layout.base')

@section('title', 'Difficulty Levels')

@section('content')

<!-- Highlighting rows and columns -->
<div class="card">
<div class="card-header bg-white header-elements-sm-inline">
<h6 class="card-title"> Difficulty Levels</h6>
<div class="header-elements">
<a type="button" href="{{ route('admin.dlevel.create') }}"  class="btn btn-dark text-white">Add Difficulty Level</a>
</div>
</div>

<div class="card-body">
<table class="table table-striped table-bordered">
<thead>
<tr class="bg-dark text-white">
<th><i class="icon-list-numbered"></i></th>
<th>@lang('admin.category_name')</th>
<th>Stairs Type</th>
<th>Elevator</th>
<th>@lang('admin.item_ids')</th>
<th>Crew</th>
<th width="5%" class="text-center">@lang('admin.action')</th>
</tr>
</thead>
<tbody>
@foreach($dlevels as $index => $dlevel)
<tr>
<td><span class="badge bg-danger mb-2">{{ $index + 1 }}</span></td>
<td>
	<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-stack3"></i> {{ $dlevel->dlevel }}</span>
</td>
<td>
	<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-stairs"></i> {{ $dlevel->stairs_type }}</span>
</td>
<td>

@php $elevators = explode(',',$dlevel->elevator); @endphp
@foreach($elevators as $elevator)
<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2">
@if($elevator == 'cargo')<i class="icon-codepen"></i>@endif
@if($elevator == 'passanger')<i class="icon-people"></i>@endif
 {{ $elevator }}</span>
@endforeach	
</td>
<td>
@php $items = explode(',',$dlevel->items); @endphp
@foreach($items as $item)
<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-furniture"></i> {{ $item }}</span>
@endforeach
</td>
<td>

@foreach($crew as $ck => $c)
	@if($dlevel->id == $c->dlevel_id)
		@if(!empty($c->roles))
			@php $crew_roles = explode(',',$c->roles); @endphp
			@foreach($crew_roles as $role)
				@foreach($roles as $r)
					@if($role == $r->id)
						<span class="badge badge-flat border-info text-info-600 badge-icon mb-2 mr-2"><i class="icon-users4"></i> {{$r->name}}</span>
					@endif
				@endforeach
			@endforeach
		@endif
	@endif
@endforeach

</td>
<td class="text-center">						
<div class="btn-group ml-2">
<button type="button" class="btn btn-info btn-icon dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></button>

<div class="dropdown-menu">
	<a href="{{ route('admin.dlevel.edit', $dlevel->id) }}" class="dropdown-item"><i class="icon-pencil text-primary"></i> @lang('admin.edit')</a>
	<button data-toggle="modal" data-target="#delete_{{ $dlevel->id }}" class="dropdown-item"><i class="icon-trash text-danger"></i> @lang('admin.delete')</button>
</div>
</div>

<!-- Modal -->
<div id="delete_{{ $dlevel->id }}" class="modal fade" role="dialog">
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
		 <form action="{{ route('admin.dlevel.destroy', $dlevel->id) }}" method="POST">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="DELETE">
			<button type="submit" name="delete_dlevel" value="true" class="btn btn-success" >Yes</button>
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
