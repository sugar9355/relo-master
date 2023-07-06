@extends('admin.layout.base')

@section('title', 'Update Accuracy')

@section('content')


<div class="card">
	<div class="card-body">
		<div>
			<a href="{{ route('admin.accuracy.index') }}" class="btn btn-default pull-right"><i
					class="fa fa-angle-left"></i> @lang('admin.back')</a>

			<h5 style="margin-bottom: 2em;">Update Accuracy ({{ $accuracy->name }})</h5>

			<form class="form-horizontal" action="{{route('admin.accuracy.update', $accuracy->id)}}" method="POST"
				enctype="multipart/form-data" role="form">
				{{csrf_field()}}
				<input type="hidden" name="_method" value="PATCH">

				<div class="form-group">


					<div class="col-md-3">
						<label for="Label" class="col-md-12 col-form-label">Label</label>
						<div class="col-md-12">
							<input class="form-control" type="text" value="{{ $accuracy->label }}" name="label" required
								id="label" placeholder="label">
						</div>
					</div>

					<div class="col-md-3">
						<label for="value" class="col-md-12 col-form-label">Min Value</label>
						<div class="col-md-12">
							<input class="form-control" type="text" value="{{ $accuracy->min }}" name="min" required
								id="min" placeholder="value">
						</div>
					</div>

					<div class="col-md-3">
						<label for="value" class="col-md-12 col-form-label">Max Value</label>
						<div class="col-md-12">
							<input class="form-control" type="text" value="{{ $accuracy->max }}" name="max" required
								id="max" placeholder="value">
						</div>
					</div>
				</div>


				<div class="form-group">

					<div class="col-md-10">
						<button type="submit" class="btn btn-primary">Update Accuracy</button>
						<a href="{{route('admin.accuracy.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection