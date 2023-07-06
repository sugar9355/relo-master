@extends('admin.layout.base')

@section('title', 'Update Role ')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.role.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

				<h5 style="margin-bottom: 2em;">Update Role</h5>

				<form class="form-horizontal" action="{{route('admin.role.update', $role->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}

					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group">
						<label for="name" class="col-md-6 col-form-label">@lang('admin.name')</label>
						<div class="col-md-6">
							<input class="form-control" type="text" value="{{ $role->name  }}" name="name" required id="name" placeholder="Name">
						</div>
					</div>

					<div class="form-group">
						<label for="label" class="col-md-6 col-form-label">Label</label>
						<div class="col-md-6">
							<input class="form-control" type="text" value="{{ $role->label }}" name="label" required id="label" placeholder="Label">
						</div>
					</div>
					
					<div class="form-group">
						<label for="label" class="col-md-6 col-form-label">Payout Rate</label>
						<div class="col-md-6">
							<input class="form-control" type="text" value="{{ $role->hourly_rate }}" name="hourly_rate" required id="hourly_rate" placeholder="Hourly Rate">
						</div>
					</div>

					<div class="form-group">
						<label for="label" class="col-md-6 col-form-label">Charging Customer</label>
						<div class="col-md-6">
							<input class="form-control" type="text" value="{{ $role->charging_customer }}" name="charging_customer" required id="charging_customer" placeholder="Charging Customer">
						</div>
					</div>

					<div class="row">
						@foreach ($demand_types as $demand)
						<div class="col-md-2">
							<label for="" class="col-md-12 col-form-label">{{$demand->demand_name}} Rate</label>
							<div class="col-md-10">
								<input class="form-control demand_rate" type="text" value="{{$demand->rate}}" required data-id="{{$demand->id}}">
							</div>
						</div>
						@endforeach
					</div>

					<input type="hidden" name="demand_rates" id="demand_rates" />

					<div class="form-group">
						<label for="zipcode" class="col-md-2 col-form-label"></label>
						<div class="col-md-6">
							<button type="submit" class="btn btn-primary">Update Role</button>
							<a href="{{route('admin.role.index')}}" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
<script src="{{asset('assets_admin/js/main/jquery.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		var demand_rates = {
		@foreach ($demand_types as $c)
			"{{$c->id}}": { "demand_id": "{{ $c->id }}", "rate": "{{ $c->rate }}" }, 
		@endforeach
		};
		$('#demand_rates').val(JSON.stringify(demand_rates))

		$('.demand_rate').keyup(function() {
			var demand_id = $(this).data('id');
			demand_rates[demand_id].rate = $(this).val();
			$('#demand_rates').val(JSON.stringify(demand_rates));
			console.log($('#demand_rates').val())
		})
	})
</script>
