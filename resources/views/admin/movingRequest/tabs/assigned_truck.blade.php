<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered">
<thead>
	<tr>
		<th>Truck Name</th>
		<th>Truck Type</th>
		<th>Truck Color</th>
		<th>Truck Volume</th>
		
		
	</tr>
</thead>
<tbody>

<tr>

	<td>{{$booking->truck_name}}</td>
	<td>{{$booking->truck_type}}</td>
	<td><div style="width:20px;height:20px;background-color:{{$booking->color}};"></div></td>
	<td>{{$booking->truck_volume}}</td>
	
</tr>

</tbody>

</table>	
</div>
</div>
