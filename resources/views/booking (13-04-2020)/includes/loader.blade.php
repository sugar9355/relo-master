
<div class="card border-info mt-1 mb-0 h-100 ">
		
	<div class="card-body ">
		@if($selected_items)
		<!-- Grid -->
		<div class="row">
		@foreach($selected_items as $added_item)

		<div class="col-xl-2 col-sm-3">
		<div class="card">


			<div class="card-body p-0">
			<div class="card-img-actions">

			
			<a href="/no_item.jpg" data-popup="lightbox">
				<img src="/no_item.jpg" class="card-img" width="80" height="40" alt="">
			<span class="card-img-actions-overlay card-img">
			<i class="icon-zoomin3"></i>
			</span>
			</a>
			
			</div>
			</div>


			<div class="card-body bg-light text-center pt-1 pb-0">
			<div class="mb-2">

			<font size="1">{{ ucfirst($added_item->item_name) }}</font>

			</div>

			</div>

				<div class="card-footer bg-white d-flex justify-content-between align-items-center p-0">
					<button  class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#item_info_{{ $added_item->booking_item_id }}"><i class="far fa-eye"></i></button>
					<button  class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#item_delete{{ $added_item->booking_item_id }}"><i class="far fa-trash-alt"></i></button>
				</div>

		</div>
		</div>

		@include('booking.includes.item_info')													
		@include('booking.includes.item_delete')

		@endforeach
		@endif
		</div>

	</div>
	
	

</div>

