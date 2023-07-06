<div class="card mt-4">
<div class="card-header bg-dark text-white">
<h3 class="m-0"><i class="fas fa-boxes mr-2"></i> Inventory Items</h3>
</div>
<div class="card-body pt-2 px-2">



<table class="table">
  <thead class="small bg-dark text-white">
	<tr>
	  <th class="p-2">Items</th>
	  <th class="p-2" width="250">Name</th>
	  <th class="p-2">Quantity</th>
	  <th class="p-2">Edit</th>
	  <th class="p-2 text-center">Remove</th>
	</tr>
  </thead>
  <tbody>
	@foreach($selected_items as $k => $added_item )
	
	<tr>
	  <td><img src="{{$added_item->file_path}}" height="50" width="50" alt=""></td>
	  <td>{{$added_item->item_name}}</td>
	  <td>{{$added_item->quantity}}</td>
	  <td><a class="text-dark" href="#" data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}"><i class="icon-pencil3 text-primary"></i></a></td>
	  <td class="text-center"><a class="text-dark" href="#" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}"><i class="far fa-trash-alt shadow text-danger"></i></a></td>
	</tr>
	@endforeach
  </tbody>
</table>

</div>
</div>

@foreach($selected_items as $k => $added_item )
	@include('booking.includes.item_info')													
	@include('booking.includes.item_delete')
@endforeach