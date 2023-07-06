
<!-- Modal2 -->
<div class="modal fade" id="insurance-pop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
  <h3 class="modal-title" id="staticBackdropLabel">Insurance ($50)</h3>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body bg-light">
	<div class="row text-center">
		@foreach($insuranceCategories as $insurance)
		<div class="col-md-3 mb-3" onclick="update_insurance({{$insurance->amount}})">
			<div id="insurance_type_{{$insurance->amount}}" class="card border border-warning hvr-sweep-to-right text-dark w-100 shadow @if($booking->insurance == $insurance->amount) bg-warning @else bg-white @endif text-dark w-100 shadow">
				<div class="card-header text-warning bg-transparent">
					<i id="icon_{{$insurance->amount}}" class="{{$insurance->icon}} @if($booking->insurance == $insurance->amount) text-dark @else text-warning @endif"></i>
				</div>
				<div class="card-body text-dark text-left px-2 py-2">
					<h6 class="m-0">{{$insurance->name}} <span class="float-right text-dark rounded bg-white px-2">${{$insurance->amount}}</span></h6>
				</div>
			</div>
		</div>
		@endforeach

		<div class="col-md-3 mb-3">
			<div class="card border border-warning bg-white hvr-sweep-to-right text-dark w-100 shadow">
				<div class="card-header text-warning bg-transparent">
					<i class="fas fa-sliders-h fa-2x"></i>
				</div>
				<div class="card-body text-dark text-left px-2 py-2">
						<h6 class="m-0">Ala Caret
						<span class="float-right text-dark rounded bg-white px-2">-</span></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="card mt-3">
		<div class="card-header bg-white">
			<h4><i class="fas fa-boxes mr-2"></i> Items <span class="float-right"><input type="text" class="form-control" placeholder="Search"></span></h4> 
		</div>
		<div class="card-body">
			<div class="row">
			@foreach($selected_items as $i)
				<div class="col">
					<div class="bg-light border border-warning p-2 rounded mb-2 mt-2 p-3 shadow">
						<div class="d-flex mb-2">
						  <span><i class="fas fa-chair fa-2x mr-3"></i></span>  <span class="lead">{{$i->item_name}}</span> 
						</div>
						<div class="w-50 text-left float-left">$0</div> <div id="amount_{{$i->booking_item_id}}" class="w-50 text-right float-left">${{$i->you_pay}}</div>
						 <div class="text-center font-weight-bold">
						   <input type="range" class="custom-range" min="0" max="100" step="1" id="item_{{$i->booking_item_id}}" onchange="update_item_insurance({{$i->booking_item_id}})" value="{{$i->you_pay}}">
						 </div>
					  </div>
				</div>
			@endforeach	
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>