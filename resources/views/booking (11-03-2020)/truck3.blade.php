@if($selected_items)
<!-- Grid -->
<div class="row">
@foreach($selected_items as $added_item)
@if($added_item->truck_id == $truck->truck_id)
<div class="col-xl-2 col-sm-3">
<div class="card">
	
	<a href="{{ $added_item->file_path }}" class="p-0 m-0 text-center">
		<span class="badge badge-danger badge-pill pull-right">{{$added_item->quantity}}</span>
		<img src="{{ $added_item->file_path }}" class="card-img-top" width="60" height="60" alt="">
	</a>

	<div class="card-body bg-light text-center p-0">			

		<small class="py-2 d-block">{{ ucfirst($added_item->item_name) }}</small>

	<div class="btn-group" role="group">
		<button  class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}"><i class="far fa-eye"></i></button>
		<button  class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}"><i class="far fa-trash-alt"></i></button>
	</div>		
	
	<div class="btn-group w-100 text-center">
		{{$added_item->width * $added_item->height * $added_item->breadth}} cm3
	</div>		

	</div>

</div>
</div>

@include('booking.includes.item_info')													
@include('booking.includes.item_delete')
@endif
@endforeach
@endif
</div>
