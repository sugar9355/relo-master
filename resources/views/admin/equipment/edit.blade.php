@extends('admin.layout.base')

@section('title', 'Edit Material ')

@section('content')

<!-- Left aligned buttons -->
		<div class="card">
			<div class="card-header header-elements-inline">
				<h6 class="card-title">Update Equipment</h6>
				<div class="header-elements">
					
				</div>
			</div>

			<div class="card-body">
				<form class="form-horizontal" action="{{route('admin.equipment.update', $equipment->id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					
					<div class="form-group">
						<label>Name:</label>
						<input class="form-control" type="text" value="{{ $equipment->name }}" name="name" required id="name" placeholder="Name">
					</div>
					
					<div class="d-flex justify-content-start align-items-center">
						<a href="{{ route('admin.equipment.index') }}" class="btn btn-light">Cancel</a>
						<button type="submit" class="btn bg-blue ml-3">Update <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>
		</div>
		<!-- /left aligned buttons -->

	<script>
		$(document).ready(function() {
			let selector = $('.select2');
			selector.select2();
			let selected = $('#itemIdsVal').html().split(",");
			selector.val(selected);
			selector.change();
		});
	</script>


@endsection
