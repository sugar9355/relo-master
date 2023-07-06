
<div class="form-group">
<div class="col-md-12">   

<h4>Assigned Captain</h4>
<table class="table table-striped table-bordered">
<thead>
	<tr>
		<th>Captain Name</th>
		<th>Phone no</th>
		<th>Badges</th>
		<th width="20%" class="text-center">Action</th>
		
	</tr>
</thead>
<tbody>


@if(isset($captains))
	
	@foreach($captains as $captain)
	@if($captain->id ==  $booking->captain_id )
<tr>	
	<td>{{$captain->first_name}} {{$captain->last_name}}</td>
		<td>{{$captain->mobile}} </td>
		<td>{{trim(rtrim($captain->badge_name,','),',')}} </td>
		<td class="text-center">
				<form class="form-horizontal" action="{{route('admin.user_request.update', $booking->booking_id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<button type="submit" class="btn btn-danger" name="un_assign_captain" value="{{$captain->id}}">Un Assign Captain</button>
				
			</form>
		</td>
</tr>	
	@php break; @endphp
	@endif		
@endforeach
	
@endif	

</tbody>
</table>	

<h4>Available Captain</h4>
<table class="table table-striped table-bordered">
<thead>
	<tr>
		<th>Captain Name</th>
		<th>Phone no</th>
		<th>Badges</th>
		<th width="20%" class="text-center">Action</th>
		
	</tr>
</thead>
<tbody>


@if(isset($captains))
	
	@foreach($captains as $captain)
<tr>	
	<td>{{$captain->first_name}} {{$captain->last_name}}</td>
		<td>{{$captain->mobile}} </td>
		<td>{{trim(rtrim($captain->badge_name,','),',')}} </td>
		<td class="text-center">
				<form class="form-horizontal" action="{{route('admin.user_request.update', $booking->booking_id )}}" method="POST" enctype="multipart/form-data" role="form">
					{{csrf_field()}}
					<input type="hidden" name="_method" value="PATCH">
					<button type="submit" class="btn btn-success" name="assign_captain" value="{{$captain->id}}">Assign Captain</button>
				
			</form>
		</td>
</tr>		
	@endforeach
	
@endif	


</tbody>

</table>	
</div>
</div>
