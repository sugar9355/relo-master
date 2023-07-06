

	<!-- Modal -->
	
	<div id="item_delete{{ $added_item->booking_item_id }}" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
		<h3>{{ $added_item->item_name }}</h3>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		
	</div>
	<div class="modal-body">
	

			<input type="hidden" name="booking_item_id" value="{{ $added_item->booking_item_id }}">
			
			<div class="border rounded p-3 text-danger text-center">
				
					 <h3>Are you sure do you want to delete this item ? <i class="far fa-trash-alt"></i></h3>
			
			
			</div>
			<div class="modal-footer text-center">
				<button name ="btn_delete" type="submit" class="btn btn-danger" value="5">Yes</button>
				<button type="button" class="btn btn-default border border-secondary" data-dismiss="modal">No</button>
			</div>
		
	</div>
	</div>

	</div>
	</div>

