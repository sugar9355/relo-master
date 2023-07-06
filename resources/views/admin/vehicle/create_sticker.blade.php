@extends('admin.layout.base')

@section('title', 'Update Vehicle Sticker')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Update_Vehicle_Sticker')</h5>

				<form class="form-horizontal" action="{{route('admin.vehicle.stickerStore', $id)}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}

					<div class="form-group">
						<label for="sticker_number" class="col-md-12 col-form-label">@lang('admin.sticker_number')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('sticker_number') }}" autocomplete="off" name="sticker_number" required id="sticker_number" placeholder="Sticker Number">
						</div>
					</div>
					<div class="form-group">
						<label for="sticker_date" class="col-md-12 col-form-label">@lang('admin.sticker_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('sticker_date') }}" autocomplete="off" name="from" required id="sticker_date" placeholder="Last Sticker Changed Date">
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-md-12 col-form-label">@lang('admin.description')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('description') }}" autocomplete="off" name="description" required id="description" placeholder="Description">
						</div>
					</div>
					<div class="form-group">
						<label for="sticker_due_date" class="col-md-12 col-form-label">@lang('admin.sticker_due_date')</label>
						<div class="col-md-10">
							<input class="form-control" type="text" value="{{ old('sticker_due_date') }}" autocomplete="off" name="to" required id="sticker_due_date" placeholder="Next Sticker Changed Date">
						</div>
					</div>
					<div class="form-group">
						<hr>
						<div class="col-md-10">
							<button type="submit" class="btn btn-primary">@lang('admin.vehicle.Update_Vehicle_Sticker')</button>
							<a href="{{route('admin.vehicle.index')}}" class="btn btn-default">@lang('admin.cancel')</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />

@endsection
