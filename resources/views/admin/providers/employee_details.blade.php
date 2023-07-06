<div class="modal-content  modal-lg">

	  <div class="modal-header">
		<h4 class="modal-title">Update Employee Details</h4>
	  </div>
	  
	  <div class="modal-body">
	  
			<form class="form-horizontal" action="{{route('admin.provider.update', $employee->id )}}" method="POST" enctype="multipart/form-data" role="form">
			{{csrf_field()}}
			<input type="hidden" name="_method" value="PATCH">
			<div class="form-group">
				<label>@lang('admin.first_name')</label>
				<input class="form-control" type="text" value="{{ $employee->first_name }}" name="first_name" required id="first_name" placeholder="First Name">
			</div>

			<div class="form-group">
				<label>@lang('admin.last_name')</label>
				<input class="form-control" type="text" value="{{ $employee->last_name }}" name="last_name" required id="last_name" placeholder="Last Name">
			</div>

			<div class="form-group">
				<label>@lang('admin.picture')</label>
				@if(isset($employee->avatar))
					<img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{$employee->avatar}}">
				@endif
					<input type="file" accept="image/*" name="avatar" class="dropify form-control" id="picture" aria-describedby="fileHelp">
			</div>

			<div class="form-group">
				<label>@lang('admin.mobile')</label>
				<input class="form-control" type="number" value="{{ $employee->mobile }}" name="mobile" required id="mobile" placeholder="Mobile">
			</div>

			<div class="form-group">
				<label>Role</label>
				<select class="form-control" name="role" id="role">
					@foreach ($roles as $role)
						<option value="{{$role->id}}" @if($role->id == $employee->role_id)) selected @endif>{{$role->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label>Level</label>
				<select class="form-control" name="level" id="level">
					@foreach ($levels as $level)
						<option value="{{$level->id}}" @if($level->id == $employee->level_id)) selected @endif>Level - {{$level->level}}</option>
					@endforeach
					</select>
			</div>

			<div class="d-flex justify-content-start align-items-center">
				<button type="submit" class="btn bg-blue" name="update_employee" >Update Employee Details <i class="icon-paperplane ml-2"></i></button>
			</div>
			</form>
	</div>
</div>			