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
		@php $index = 0; @endphp
	
	@foreach ($selected_items as $k => $item)
	
	@php if ($k % 2 == 0){$even = true;}else{$even = false;} @endphp
	
	<div class="card-body d-flex">
	
	@if($even == true)
		<div class="media bg-dark rounded  overflow-hidden mx-1">
		<div class="media-body p-2 text-white align-self-center"><span class="align-center">{{$item->item_name}}</span></div>
			<span>
			  <a href="#" class="btn btn-link bg-warning btn-sm btn-block p-1 text-white rounded-0 shadow-lg small"><i class="icon-pencil3 text-primary"></i></a> 
			  <a href="#" class="btn btn-link bg-warning btn-sm btn-block p-1 text-dark rounded-0 mt-0 small"><i class="far fa-trash-alt shadow text-danger"></i></a>
			</span>
		</div>
	@else
		<div class="media bg-dark rounded  overflow-hidden mx-1">
		<div class="media-body p-2 text-white align-self-center"><span class="align-center">{{$item->item_name}}</span></div>
			<span>
			  <a href="#" class="btn btn-link bg-warning btn-sm btn-block p-1 text-white rounded-0 shadow-lg small"><i class="icon-pencil3 text-primary"></i></a> 
			  <a href="#" class="btn btn-link bg-warning btn-sm btn-block p-1 text-dark rounded-0 mt-0 small"><i class="far fa-trash-alt shadow text-danger"></i></a>
			</span>
		</div>
	@endif	
	</div> 
	
		
  @endforeach
	
  @endif
  

</div>
