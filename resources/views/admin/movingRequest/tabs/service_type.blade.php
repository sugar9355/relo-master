<div class="form-group">
<div class="col-md-12">   

@if(isset($booking->booking_id))
<table class="table table-striped table-bordered">

<tbody>

	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">User Name</label></td>
		<td width="80%">{{ $user->first_name . ' ' . $user->last_name }}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Booking Date</label></td>
		<td width="80%">{{ $booking->booking_date }}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Accuracy</label></td>
		<td width="80%">{{ $booking->accuracy }}</td>
	</tr>
	<tr>
		<td width="20%"><label for="Monday" class="col-form-label">Packaging</label></td>
		<td width="80%">{{ $booking->packaging }}</td>
	</tr>
	
</tbody>
</table>	
@endif
</div>
</div>
