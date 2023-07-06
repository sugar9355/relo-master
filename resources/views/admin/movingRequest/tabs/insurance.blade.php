<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered">
<thead>
	<tr>
		<th>Insurance Type</th>
		<th>Category</th>
		<th>Quatity</th>
		<th>Ratio</th>
		
		
	</tr>
</thead>
<tbody>
@foreach($insurance as $insuranceDetails)	
<tr>

	<td>{{ $insuranceDetails->name }}</td>
	<td>{{ $insuranceDetails->item_name }}</td>
	<td>{{ $insuranceDetails->quantity }}</td>
	<td>{{ $insuranceDetails->ratio }}</td>
	
</tr>
@endforeach
</tbody>

</table>	


</div>
</div>