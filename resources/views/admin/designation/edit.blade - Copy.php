@extends('admin.layout.base')

@section('title', 'Update Designation ')

@section('content')

	<div class="content-area py-1">
		<div class="container-fluid">
			<div class="box box-block bg-white">
				<a href="{{ route('admin.designation.index') }}" class="btn btn-default pull-right"><i class="fa fa-angle-left"></i> Back</a>

				<h5 style="margin-bottom: 2em;">Update Badge</h5>

				<form class="form-horizontal" action="{{route('admin.designation.update', $designation->id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<div class="form-group row">
						<label for="name" class="col-xs-2 col-form-label">@lang('admin.name')</label>
						<div class="col-xs-10">
							<input class="form-control" type="text" value="{{ $designation->name }}" name="name" required id="name"
								   placeholder="Name">
						</div>
					</div>

					<div class="form-group row">
						<label for="bonus" class="col-xs-2 col-form-label">Bonus Amount</label>
						<div class="col-xs-10">
							<input class="form-control" type="text" required name="bonus" value="{{ $designation->bonus }}" id="bonus" placeholder="Bonus Amount">
						</div>
					</div>
					
					<div class="form-group row">
						<label for="bonus" class="col-xs-2 col-form-label">Badge Type</label>
						<div class="col-xs-10">
							<select class="form-control" id="badge_type" name="badge_type" onchange="bedge_level();">
								
							</select>
						</div>
					</div>

					<div id="div_level" class="form-group row">
						<label for="bonus" class="col-xs-2 col-form-label">Level</label>
						<div class="col-xs-10">
							<select class="form-control" name="level">
							@foreach($levels as $lvl)
								<option value="{{$lvl->id}}" @if($designation->level == $lvl->id) selected  @endif >{{$lvl->name}}</option>
							@endforeach
						</select>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-xs-10">
							<button type="submit" class="btn btn-primary">Update Badge</button>
							<a href="{{route('admin.designation.index')}}" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection

<script type="text/javascript">
function bedge_level() 
{
	var badge_type = $("#badge_type").val();
	if(badge_type == 'hourly')
	{
		$("#div_level").show();
	}
	else
	{
		$("#div_level").hide();
	}
	
}

</script>
