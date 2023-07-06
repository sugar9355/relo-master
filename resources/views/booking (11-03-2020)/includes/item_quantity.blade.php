<!-- Modal -->
<div id="quantity_{{ $added_item->booking_item_id }}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
	<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Item Quantity</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		
		
			{{csrf_field()}}

			<input type="hidden" name="booking_item_id" value="{{ $added_item->booking_item_id }}">
			<input type="hidden" name="truck_id" value="{{ $added_item->truck_id }}">
			<input type="hidden" name="update_quantity" value="true">
			<input type="hidden" name="quantity_limit" value="{{ $added_item->quantity }}">
			@if($limit_execeed == false)
			<input type="hidden" name="truck_limit" value="open">
			@else
			<input type="hidden" name="truck_limit" value="close">
			
			@endif
			
			<div class="form-row">
				<div class="form-group col-md-4"></div>
				<div class="form-group col-md-4 text-center">
					<strong>Quantity</strong> 
					<input class="form-control text-center" min=0 type="number" name="quantity" value="{{ $added_item->quantity }}">
				</div>
				<div class="form-group col-md-4"></div>					
			</div>
			<span class="text-danger">It looks like Truck limit Execeeded Cannot Increase Quantity any more </span>
      </div>
	  
      <div class="modal-footer">
		<button name ="btn_submit" type="submit" class="btn btn-success" value="5">Update</button>
        <button type="button" class="btn border-dark btn-default" data-dismiss="modal">Close</button>
      </div>
	  
    </div>
	</form>

  </div>
</div>