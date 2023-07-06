<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered">

<tbody>

	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Start Time</label></td>
		<td width="80%">{{$booking->start_time}}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">End Time</label></td>
		<td width="80%">{{$booking->end_time}}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Primary Date</label></td>
		<td width="80%">{{$booking->primary_date}}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Secondary Date</label></td>
		<td width="80%">{{$booking->secondary_date}}</td>
	</tr>
	
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Travel Distance</label></td>
		<td width="80%">{{$booking->minutes}} mins</td>
	</tr>
	
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Over All Distance Time</label></td>
		<td width="80%">{{$booking->over_all_minutes}} mins</td>
	</tr>

</tbody>
</table>	

</div>
</div>

<!-- ---------------------------------------------------------------->
<!-- ---------------------------------------------------------------->
			

@section('scripts')

@endsection
                  