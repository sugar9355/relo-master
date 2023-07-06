<style> 
.cursor-pointer{
  cursor: pointer;
  
}
</style> 
<div class="col mt-4">
<div class="card pb-0">
<div class="card-header bg-dark text-white pb-0">
	<div class="form-inline">
	<i class="icon-stats-bars2 icon-2x text-warning pb-2"></i>&nbsp;&nbsp;
	<h5 class="card-title">Please select inventory accuracy : <h5>
	</div>
</div>
<div class="card-body ">
	<form id="accuracyform" action="/accuracy/{{ isset($booking->booking_id) ? $booking->booking_id : null }}" method="post" enctype="multipart/form-data">

	<input type="hidden" name="accuracy" id="accuracy" value="">
	
	{{ csrf_field() }}

	<div class="row">
	
		@foreach($accuracy as $k => $acc)
		<div class="col-md-3">
			<div id="div_{{$acc->id}}" class="card hvr-shadow cursor-pointer @if($acc->id == $booking->accuracy) alert-success @endif" onclick="add_accuracy('{{$acc->id}}');" @if($booking->accuracy == $acc->id) checked @endif style="border-radius:20px;">
				<div class="card-header  w-100 text-center pb-0">
				<h6 class="card-title">{{$acc->name}}<h6>
				</div>
				<div class="card-body text-center">
					<font size="2">{{$acc->label}}</font>
				</div>
			</div>
		</div>
		@endforeach

	</div>
</form>
</div>
<div class="card-footer alert bg-info text-white alert-dismissible mb-0">
			Please be as helpful as possible in this category.
			We understand that estimating is hard so image estimating your job from your estimate. <strong>NOT EASY!</strong>
	</div>	
</div>
</div>

	
		