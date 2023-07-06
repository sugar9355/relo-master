
<div class="card border-info mt-1 mb-0">
	<div class="card-header bg-white header-elements-sm-inline">
	<button type="button" class="btn btn-outline bg-pink-400 text-pink-400 border-pink-400 btn-icon border-2">
				<i class="icon-cube3"></i> Truck Capacity
			</button>
			<div class="header-elements">
			<div class="d-flex align-items-center justify-content-center mb-2">
				<a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon mr-3">
					<i class="icon-cube2"></i>
				</a>
				<div>
					<div class="font-weight-semibold">Total Items</div>
					<span class="text-muted"><span class="badge badge-mark border-success mr-2"></span> {{count($selected_items)}}</span>
				</div>
			</div>
			</div>
		
	</div>
					
	<div class="card-body">
		@if($selected_items)
		<!-- Grid -->
		<div class="row">
		@foreach($selected_items as $added_item)

		<div class="col-xl-2 col-sm-3">
		<div class="card">


			<div class="card-body">
			<div class="card-img-actions">

			
			<a href="/no_item.jpg" data-popup="lightbox">
				<img src="/no_item.jpg" class="card-img" width="80" height="60" alt="">
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

				<div class="card-footer bg-white d-flex justify-content-between align-items-center">
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
	
	<div class="card-footer bg-white d-flex justify-content-between align-items-center">
		<div class="pace-demo col-md-12 w-auto h-auto p-3 pb-4" style="padding-bottom: 30px;">
				<div class="theme_bar"><div class="pace_progress" data-progress-text="60%" data-progress="60" style="width: 60%;"><i class="icon-truck"></i> 60%</div></div>
			</div>
	
	</div>

</div>

