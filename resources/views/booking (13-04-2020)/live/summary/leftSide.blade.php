<div class="col-md-3">
  <div class="card card-body">
  
	<h5 class="border-bottom pb-2">Crew Required</h5>
	<div id="div_crew_1" class="@if($booking->crew_count == 1) bg-warning @else bg-light @endif p-2 rounded mb-3">
	<div class="custom-control custom-radio">
	  <input type="radio" class="custom-control-input" name="man" id="man1" onclick="update_crew(1);" @if($booking->crew_count == 1) checked @endif>
	  <label class="custom-control-label w-100" for="man1">1 Man <span class="float-right"><img src="/worker.svg" alt="" height="25" width="20" class="position-relative mb-1"></span></label>
	</div>
  </div>
  <div id="div_crew_2" class="@if($booking->crew_count == 2) bg-warning @else bg-light @endif p-2 rounded mb-3">
	<div class="custom-control custom-radio">
	  <input type="radio" class="custom-control-input" name="man" id="man2" onclick="update_crew(2);" @if($booking->crew_count == 2) checked @endif>
	  <label class="custom-control-label w-100 text-dark" for="man2">2 Man <span class="float-right"><i class="fas fa-people-carry fa-lg"></i></span></label>
	</div>
  </div>
  <div id="div_crew_3" class="@if($booking->crew_count == 3) bg-warning @else bg-light @endif p-2 rounded mb-2">
  <div class="custom-control custom-radio">
	<input type="radio" class="custom-control-input" name="man" id="man3" onclick="update_crew(3);" @if($booking->crew_count == 3) checked @endif>
	<label class="custom-control-label w-100 text-dark" for="man3">3 Man <span class="float-right"><img src="/worker.svg" alt="" height="25" width="20" class="position-relative mb-1"> <i class="fas fa-people-carry fa-lg"></i></span></label>
  </div>
</div>
<div id="div_crew_4" class="@if($booking->crew_count == 4) bg-warning @else bg-light @endif p-2 rounded mb-2">
  <div class="custom-control custom-radio">
	<input type="radio" class="custom-control-input" name="man" id="man4" onclick="update_crew(4);" @if($booking->crew_count == 4) checked @endif>
	<label class="custom-control-label w-100 text-dark" for="man4">4 Man <span class="float-right"><img src="/worker.svg" alt="" height="25" width="20" class="position-relative mb-1"> <i class="fas fa-people-carry fa-lg"></i> <i class="fas fa-people-carry fa-lg"></i></span></label>
  </div>
</div>

<hr>
<h5 class="border-bottom pb-2 mt-3">Insurance</h5>

	@foreach($insuranceCategories as $insurance)
	<div class="bg-light p-2 rounded mb-3">
	<div class="custom-control custom-radio">
	<input type="radio" class="custom-control-input" name="insurance" id="insurance{{$insurance->id}}" onchange="update_insurance({{$insurance->id}})" @if($booking->insurance == $insurance->id) checked @endif >
	<label class="custom-control-label w-100 text-{{$insurance->color}}" for="insurance{{$insurance->id}}">{{$insurance->name}} (${{$insurance->amount}}) <i class="fas fa-info-circle text-muted"></i></label>
	</div>
	</div>
	@endforeach
  
  <div class="custom-control custom-checkbox mt-5 mb-2">
	<input type="checkbox" class="custom-control-input" id="customCheck1" >
	<label class="custom-control-label w-100 text-dark" for="customCheckDisabled1">Ala Caret</label>
  </div> 
  <input type="text" class="form-control" placeholder="Search">
  <div class="bg-light p-2 rounded mb-2 mt-2 p-3">
	<div class="d-flex mb-2">
	  <span><i class="fas fa-chair fa-2x mr-3"></i></span>  <span class="lead">Chair</span> 
	</div>
	<div class="w-50 text-left float-left">$0</div> <div class="w-50 text-right float-left">$50</div>
	 <div class="text-center font-weight-bold">
	   <input type="range" class="custom-range" min="0" max="5" step="0.5" id="customRange3">
	 </div>
  </div>
  <div class="bg-light p-2 rounded mb-2 mt-2 p-3">
	<div class="d-flex mb-2">
	  <span><i class="fas fa-couch fa-2x mr-3"></i></span>  <span class="lead">Chair</span> 
	</div>
	<div class="w-50 text-left float-left">$0</div> <div class="w-50 text-right float-left">$50</div>
	 <div class="text-center font-weight-bold">
	   <input type="range" class="custom-range" min="0" max="5" step="0.5" id="customRange3">
	 </div>
  </div>
  </div>
</div>
