
	

		@if($selected_items)
		
		<!-- Grid -->
		<div class="row">
		@foreach($selected_items as $added_item)
		@if($added_item->truck_id == $truck->truck_id)
		<div class="col-xl-2 col-sm-3">
		<div class="card">
			<a href="{{ $added_item->file_path }}" class="p-0 m-0 text-center">
				<img src="{{ $added_item->file_path }}" class="card-img-top" width="60" height="60" alt="">
			</a>

			<div class="card-body bg-light text-center p-0">			

				<small class="py-2 d-block">{{ ucfirst($added_item->item_name) }}</small>

			<div class="btn-group w-100" role="group">
			
				<form id="ajaxform{{ $added_item->booking_item_id }}"  
				
				action="/booking/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" 
				method="post" enctype="multipart/form-data">
				
					{{ csrf_field() }}
					<input type="hidden" name="booking_id" value="{{$booking->booking_id}}">
					<input type="hidden" name="btn_submit" value="5">
					<input type="hidden" name="booking_item_id" value="{{$added_item->booking_item_id}}">
					<input type="hidden" name="quantity" value="{{$added_item->quantity}}">
					<input type="hidden" id="action{{ $added_item->booking_item_id }}" name="action" value="">
					
					
				
					<button class="btn btn-info btn-sm"  type="button" data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}"><i class="far fa-eye"></i></button>
					<button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}"><i class="far fa-trash-alt"></i></button>
					<br>
					<input name="action" onclick="submitform('{{ $added_item->booking_item_id }}','+');"
					type="submit" value="+" class="btn btn-warning btn-sm fas fa-plus">
					<input name="action" onclick="submitform('{{ $added_item->booking_item_id }}','-');"  
					type="submit" class="btn btn-warning btn-sm fas fa-plus" value="-" type="button" >
				
				</form>	
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
	