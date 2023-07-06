@extends('admin.layout.base')

@section('title', 'Add Vehicle Document')

@section('content')

	<div class="card">
		<div class="card-body">
			<div >
				<a href="{{ route('admin.vehicle.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> @lang('admin.back')</a>

				<h5 style="margin-bottom: 2em;">@lang('admin.vehicle.Add_Vehicle_Document')</h5>
				<form method="post" action="{{route('admin.vehicle.documentStore', $id)}}" enctype="multipart/form-data"
					  class="dropzone" id="dropzone">
					{{csrf_field()}}
				</form>
			</div>
		</div>
	</div>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
@endsection
