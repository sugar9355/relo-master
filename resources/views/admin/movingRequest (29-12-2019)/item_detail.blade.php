<h3 class="form-section2 alert-info">Items Details</h3>

<div class="row">

<div class="col-md-12">
		<div class="form-group">
			<label class="control-label col-md-1">Name</label>
			<label class="control-label col-md-3">width * height * breadth = volume</label>
			<label class="control-label col-md-1">Flight </label>
			<label class="control-label col-md-2">Flight Types</label>
			<label class="control-label col-md-2">Averege Flight Time</label>
			<label class="control-label col-md-2">Disassemble Difficulty level</label>
			<label class="control-label col-md-1">Total Time</label>
		</div>
	</div>

@foreach($MovingItems as $item)

	@foreach($inventory_items as $inventory)
	
	@if($inventory->name == $item->name)
	<div class="col-md-12">
			
			<div class="col-md-1"><p class="form-control-static"> {{ $inventory->name }} </p></div>
			<div class="col-md-3"><p class="form-control-static">  {{ $inventory->width }} * {{  $inventory->height }} * {{  $inventory->breadth }}  = {{  $inventory->volume }} <strong>cm3</strong></p></div>
			
			<div class="col-md-1">
				
				@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
							{{  $loc->flight }} <hr class="m-0"> 
					@endif
				@endforeach
				
			</div>
			
			<div class="col-md-2">
			
			@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
						@if($loc->stair_type == 'windy')
							{{ $loc->stair_type }} : <strong>+0.1</strong> <br>
						@else
							{{ $loc->stair_type }} : <strong>+0.5</strong> <br>
						@endif
					@endif
				@endforeach
			
			</div>
			
			<div class="col-md-2">
				
				@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
							@php
						
								$flight = explode('to',$loc->flight)[1]; 
								$min = 'time_'.$flight.'_min';
								$med = "time_".$flight."_med";
								$max = "time_".$flight."_max";
								
								$min = str_replace(' ', '', $min);
								$med = str_replace(' ', '', $med);
								$max = str_replace(' ', '', $max);
								
							@endphp
							
							( {{$inventory->$min}} + {{$inventory->$min}} + {{$inventory->$min}} ) / {{$flight}} = <strong> {{round($inventory->avg_time)}} </strong> mins  <hr class="m-0">
							
					@endif
				@endforeach
				
			</div>
			
			<div class="col-md-2">
				
				@foreach($ranking as $rank)
				
						@if($rank->ranking_id == $item->ranking_id)
							
							@php $prop = 'R_'.$rank->alphabet @endphp
					
							Pick: {{$inventory->$prop}} mins
							<hr class="m-0">
							Drop: {{$inventory->$prop}} mins
							
						@endif
						
				@endforeach
				
			</div>
			
			
			<div class="col-md-12">
				<hr>
			</div>
			
			
	</div>
	@endif
	<!--/span-->
	@endforeach	
@endforeach
   
</div>