<div class="card mt-3" id="insurancebox">
<div class="card-header bg-dark text-white">
  <h3 class="m-0"><i class="fas fa-house-damage fa-large mr-2"></i> Insurance</h3>
</div>
<div class="card-body">

  <div class="media bg-dark rounded d-flex align-content-stretch flex-wrap mx-1">
	<span class="px-1 bg-warning text-dark d-flex align-self-stretch rounded-left h3">$25</span>
	<div class="media-body p-2 text-white align-self-center"><strong>Standard Insurance </strong>
	  <br>
	  All moving items and home damages are included.

	</div>
	<span class="align-self-stretch">
	  <a href="#" class="btn btn-link bg-warning btn-sm d-flex btn-block text-white rounded-0 shadow-lg small"><i class="fa fa-edit align-self-center"></i></a> 
	  <a href="#" class="btn btn-link bg-warning btn-sm d-flex btn-block text-dark rounded-0 mt-0 small"><i class="far fa-trash-alt shadow align-self-center"></i></a>
	</span>
  </div>

</div>


	@if(isset($selected_items[0]))
	
	<div class="card-body">
	<div class="row">
	@php $index = 0; @endphp
	
	@foreach ($selected_items as $k => $item)
	
	@php if ($k % 2 == 0){$even = true;}else{$even = false;} @endphp
	
	<div class="col-xl-4 col-sm-4">
	<div class="card card-body bg-light text-center p-2 mb-3">
		
		<small class="pt-2 bg-dark text-white">{{$item->item_name}}</small>	
		<div class="row ">
			
				<div class="col-md-6 m-0 pr-0">
				  <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" class="btn btn-link bg-warning btn-sm col-md-12"><i class="icon-pencil3 text-primary"></i></a> 
				</div>
				<div class="col-md-6 m-0 pl-0">
				  <a href="/booking/{{ ($booking->booking_id) ?: null }}/6" class="btn btn-link bg-warning btn-sm col-md-12" data-toggle="modal" data-target="#ins_{{$item->item_id}}"><i class="far fa-trash-alt shadow text-danger"></i></a>

					<!-- Modal -->
					<div id="ins_{{$item->item_id}}" class="modal fade" role="dialog">
					<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<h4 class="modal-title text-center">Are You Sure ?</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						
					  </div>
					  <div class="modal-body">
						<p>Do you want to Remove Item {{$item->item_name}} Insurance.</p>
					  </div>
					  <div class="modal-footer">
					  
						<form action="/booking/{{ ($booking->booking_id) ?: null }}" method="post" enctype="multipart/form-data">
							{{ csrf_field() }}
							<input type="hidden" name="insurance" value="{{$item->item_id}}">
							<button name="btn_submit" value="delete_insurance" type="submit" class="btn btn-success" >Yes</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
						</form>
					  </div>
					</div>

					</div>
					</div>
				</div>
			
		</div>
		
	</div>
	</div>	
  @endforeach
  </div>
	
  @endif
  

</div>
