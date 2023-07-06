<h3 class="form-section2 alert-info">Item details</h3>
@foreach($request->userMovingRequestItems as $item)
	<hr class=" form-section4 col-md-11">
	{{--                        <span ></span>--}}
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-6">Name :</label>
				<div class="col-md-6">
					<p class="form-control-static"> {{ $item->name }} </p>
				</div>
			</div>
		</div>
	</div>

	<span class="col-md-12">Q/As</span>

	<?php $cartOptions = json_decode($request->userMovingRequestItems[0]->options); ?>
	@foreach($cartOptions->answersArray as $option)
		@php $questionAnswerArray = explode('_', $option); @endphp
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Question :</label>
					<div class="col-md-6">
						<p class="form-control-static"> {{ \App\Question::find($questionAnswerArray[0])->title }} </p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-6">Answer :</label>
					<div class="col-md-6">
						<p class="form-control-static"> {{ $questionAnswerArray[1] }} </p>
					</div>
				</div>
			</div>
		</div>


	@endforeach

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-6">Additional Information :</label>
				<div class="col-md-6">
					<p class="form-control-static"> {{ $cartOptions->additional_info }} </p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-6">Pickup Location :</label>
				<div class="col-md-6">
					<p class="form-control-static"> {{ (isset($cartOptions->pickup)) ? $cartOptions->pickup : 'N/A' }} </p>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label col-md-6">Drop Locations :</label>
				<div class="col-md-6">
					<p class="form-control-static"> {{ (isset($cartOptions->drop)) ? $cartOptions->drop : 'N/A' }} </p>
				</div>
			</div>
		</div>
	</div>

@endforeach