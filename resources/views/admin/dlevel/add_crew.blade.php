@extends('admin.layout.base')

@section('title', 'Add Difficulty Level ')

@section('content')


<!-- Theme JS files -->	
<script src="{{asset('assets_admin/js/demo_pages/form_select2.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/form_multiselect.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/forms/styling/uniform.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/inputs/touchspin.min.js')}}"></script>

<script src="{{asset('assets_admin/js/demo_pages/form_input_groups.js')}}"></script>
<!-- /theme JS files -->

<!-- Theme JS files -->
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/widgets.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/extensions/jquery_ui/touch.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/sliders/slider_pips.min.js')}}"></script>
<script src="{{asset('assets_admin/js/plugins/forms/styling/switchery.min.js')}}"></script>
<script src="{{asset('assets_admin/js/demo_pages/jqueryui_sliders.js')}}"></script>
<!-- /theme JS files -->


<div class="card">

<div class="card-header bg-dark ">
<h4 class="card-title">Crew Combination</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">


	<form action="{{route('admin.AddCrew', $dlevel->id)}}" method="POST" enctype="multipart/form-data" role="form">
	
		{{csrf_field()}}
		
		<strong>Add Crew Ratio: </strong>
		<input name="crew_ratio" class="form-control" value="@if(isset($control['crew_ratio'])) {{$control['crew_ratio']}} @endif" >
		<bR>

	<table class="table table-striped table-bordered">
	<thead>
		<tr class="bg-dark text-white">
			<th>Role</th>
			<th>Level</th>
			<th>Action</th>
		</tr>
		<tbody>
		@for($i=1; $i <= $control['count'];$i++)
		<tr>
			<td>
				<select name="roles[{{$i}}]" class="form-control select" data-placeholder="Select a Roles..." data-container-css-class="bg-info-400 text-white">
				<option value="0" >Select Role</option>
					@foreach($roles as $r)
						<option value="{{$r->id}}" @if(isset($control['roles'][$i]) && $control['roles'][$i] == $r->id) selected @endif >{{$r->name}}</option>
					@endforeach
				</select>
			</td>
			<td>
				<select name="level[{{$i}}]" class="form-control select" data-container-css-class="bg-orange-400">
				<option value="0" >Select Level</option>
				@foreach($levels as $level)
					<option value="{{$level->id}}" @if(isset($control['level'][$i]) && $control['level'][$i] == $level->id) selected @endif >{{$level->name}}</option>
				@endforeach
				</select>
			</td>
			<td>
				<button type="submit" name="add_control" value="{{$control['count']}}" class="btn btn-primary"><i class="icon-plus3"></i> Add More</button>
				
			</td>
		</tr>
		@endfor
		</tbody>
	</thead>
	</table>


	<div class="form-group">
		<hr>
		<div class="col-md-10">
			<button type="submit" name="add_crew" value ="true" class="btn btn-primary">Add <i class="icon-paperplane"></i></button>
			
		</div>
	</div>
	
	</form>	
</div>


<div class="col-md-6">

	<table class="table table-striped table-bordered">
	<thead>
		<tr class="bg-dark text-white">
			<th>S.N#</th>
			<th>Crew Combination</th>
			<th>Crew Count</th>
			<th>Ratio</th>
			<th width="5%" class="text-center">@lang('admin.action')</th>
		</tr>
	</thead>
	<tbody>
		@foreach($crew as $k => $c)
		<tr>
			<td><span class="badge bg-danger mb-2">{{ $k + 1 }}</span></td>
			<td>
				@php $levels = explode(',',$c->levels) @endphp
				@foreach(explode(',',$c->roles) as $k => $c_role)
					@foreach($roles as $role)
						@if($role->id == $c_role)
						<span class="badge bg-info mb-2 ">{{$role->name}}-lvl-{{$levels[$k]}}</span>
						@endif
					@endforeach
				@endforeach
			</td>
			<td><span class="badge bg-info mb-2">{{ count(explode(',',$c->roles)) }}</span></td>
			<td><span class="badge bg-info mb-2">{{ $c->crew_ratio}}</span></td>
			<td class="text-center">
				<a class="btn bg-transparent" href="{{route('admin.edit_crews', [$dlevel->id, $c->id])}}"><i class="icon-pencil text-info"></i></a>
				<button type="button" class="btn bg-transparent" data-toggle="modal" data-target="#delete_{{ $c->id }}"><i class="icon-trash text-danger"></i></button>
				<!-- Modal -->
				<div id="delete_{{ $c->id }}" class="modal fade" role="dialog">
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
							<input type="hidden" name="delete_crew" value="{{$c->id}}">
							<button type="submit" name="btn_delete_crew"  class="btn btn-success" value="true">Yes</button>
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



</div>

<!-- /optgroups, filtering and select all -->
</div>

</div>

@endsection