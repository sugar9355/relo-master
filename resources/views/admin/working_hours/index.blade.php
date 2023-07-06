@extends('admin.layout.base')

@section('title', 'Accuracy ')

@section('content')

	@foreach($weeks as $day)
	<!-- Highlighting rows and columns -->
	<div class="card">
		<div class="card-header bg-dark header-elements-sm-inline"><h6 class="card-title">{{ucwords($day)}}</h6></div>

		<div class="card-body">
			<div class="form-inline">
			@foreach($working_hours as $hour)
				<button id="btn_{{$hour->id}}_{{$day}}" type="button" onclick='update_hour("{{$hour->id}}","{{$day}}")' value="{{$hour->$day}}" class="btn @if($hour->$day == 1) bg-success @else bg-danger @endif m-1" >{{ $hour->time }}</button>
			@endforeach
			</div>
	</div>
	
	<div class="card-footer bg-white d-sm-flex justify-content-sm-between align-items-sm-center"></div>
	
	</div>
	<!-- /highlighting rows and columns -->
	@endforeach

@endsection

@section("scripts")
<script>

function update_hour(id,day)
{
	var time = $("#btn_"+id+"_"+day).val();
	console.log(id);
	if(time == 1)
	{
		
		$("#btn_"+id+"_"+day).removeClass('bg-success');	
		$("#btn_"+id+"_"+day).addClass('bg-danger');	
		$("#btn_"+id+"_"+day).val(0);
	}
	else if(time == 0)
	{
		$("#btn_"+id+"_"+day).removeClass('bg-danger');	
		$("#btn_"+id+"_"+day).addClass('bg-success');	
		$("#btn_"+id+"_"+day).val(1);
	}
	
	$.ajax(
	{
		url : "working_hours/"+id+"/"+day+"/"+time,
		type: "Get",
		success:function(data, textStatus, jqXHR) 
		{
			if(textStatus === 'success')
			{
				console.log(data);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) 
		{
			//console.log(textStatus)
		}
	});
	
	 return false;
}

</script>
@endsection