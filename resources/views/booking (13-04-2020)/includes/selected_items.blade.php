@if($selected_items)

<!-- Grid -->
<div class="row">

@foreach($selected_items as $added_item)
@if($added_item->truck_id == $truck->truck_id)
<div class="col-xl-2 col-sm-3">

<div id="quantity_item" class="card" style="display:none;">
	<div id="div_item_quantity" class="card-box bg-success text-white text-center">s</div>
</div>

<div id="div_item_{{ $added_item->booking_item_id }}" class="card">

	<div class="btn-group w-100" role="group">
	
		<form id="ajaxform{{ $added_item->booking_item_id }}" action="/quantity/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
		
			{{ csrf_field() }}
			
			<input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
			<input type="hidden" name="btn_submit" value="5">
			<input type="hidden" name="booking_item_id" value="{{$added_item->booking_item_id}}">
			<input type="hidden" id="quantity_{{ $added_item->booking_item_id }}" name="quantity" value="{{$added_item->quantity}}">
			<input type="hidden" id="action{{ $added_item->booking_item_id }}" name="action" value="">
		
			<div class="col-md-12 text-center">
			
				<button type="button" class="border-0 bg-white text-success far fa-plus-square p-0" name="update_quantity" onclick="quantity_update('{{ $added_item->booking_item_id }}','+');"></button>
				<button type="button" class="border-0 bg-white text-info far fa-eye p-0"  data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}"></button>
				<button type="button" class="border-0 bg-white text-danger far fa-trash-alt p-0" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}"></button>
				<button type="button" class="border-0 bg-white text-success far fa-minus-square p-0" name="update_quantity" onclick="quantity_update('{{ $added_item->booking_item_id }}','-');"></button>
			</div>
			
		</form>	
	</div>		

	<a href="{{ $added_item->file_path }}" class="p-0 m-0 text-center">
		<img src="{{ $added_item->file_path }}" class="card-img-top" width="60" height="60" alt="">
	</a>

	<div class="card-body bg-light text-center p-0">			

		<!-- <small class="py-2 d-block">{-- ucfirst($added_item->item_name) --}</small> -->

	<div class="btn-group w-100 text-center">
	<form id="ajaxpkg{{ $added_item->booking_item_id }}" action="/packaging/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">
		
		{{ csrf_field() }}
		
		<input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
		<input type="hidden" name="booking_item_id" value="{{$added_item->booking_item_id}}">
	
		<div class="form-group m-0 mt-1">
			<div class="custom-control custom-switch">
			  <input type="checkbox" 
			  onclick="add_packaging('{{ $added_item->booking_item_id }}','pkg');" 
			  class="custom-control-input" 
			  id="{{ $added_item->booking_item_id }}pkg" 
			  @if($added_item->Pakaging == 1 )checked @endif
			  name="packaging" value="1">
			  <label class="custom-control-label" for="{{ $added_item->booking_item_id }}pkg"><div class="mt-1" style="font-size:10px;">Packaging</div></label>
			</div>
		</div>
		<div class="form-group m-0 mt-1">
			<div class="custom-control custom-switch">
			  <input type="checkbox" 
			  onclick="add_packaging('{{ $added_item->booking_item_id }}','jnk');" 			  
			  class="custom-control-input" 
			  id="{{ $added_item->booking_item_id }}jnk" 
			  @if($added_item->junk_removal == 1 )checked @endif
			  name="junkremoval" value="1">
			  <label class="custom-control-label" for="{{ $added_item->booking_item_id }}jnk"><div class="mt-1" style="font-size:10px;">Junk Removal</div></label>
			</div>
		</div>
	</form>		
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
