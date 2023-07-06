<h3 class="form-section2 alert-info">Items Details</h3>

<div class="form-group">
<div class="col-md-12">   

<table class="table table-striped table-bordered dataTable">
<thead>
	<tr>
		<th>Items No</th>
		<th>Name</th>
		<th>width * height * breadth = volume</th>
		<th>Flight </th>
		<th>Flight Types</th>
		<th>Averege Flight Time</th>
		<th>Disassemble Difficulty level</th>
		<th align="center">Total Time</th>
		
	</tr>
</thead>
<tbody>
@foreach($MovingItems as $k => $item)

	@foreach($inventory_items as $inventory)
	
	@if($inventory->name == $item->name)
	
	<tr>
	<td>{{$k+1}}</td>
		<td><p class="form-control-static"> {{ $inventory->name }} </p></td>
		<td><p class="form-control-static">  {{ $inventory->width }} * {{  $inventory->height }} * {{  $inventory->breadth }}  = {{  $inventory->volume }} <strong>cm3</strong></p></td>
		<td>	
			@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
							{{  $loc->flight }} <hr class="m-0"> 
					@endif
			@endforeach
		</td>
		<td>
		@foreach($location as $loc)
					@if($loc->user_moving_request_id == $item->user_moving_request_id)
						@if($loc->stair_type == 'windy')
							{{ $loc->stair_type }} : <strong>+0.1</strong> <br>
						@else
							{{ $loc->stair_type }} : <strong>+0.5</strong> <br>
						@endif
					@endif
				@endforeach
		</td>
		<td>
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
		</td>
		<td>
			@foreach($ranking as $rank)
				
						@if($rank->ranking_id == $item->ranking_id)
							
							@php $prop = 'R_'.$rank->alphabet @endphp
					
							Pick: {{$inventory->$prop}} mins
							<br>
							Drop: {{$inventory->$prop}} mins
							
						@endif
						
				@endforeach
		</td>
		<td align="center">
		{{$inventory->total_time}} mins
		</td>
		
	</tr>
		@endif
	<!--/span-->
	@endforeach	
@endforeach

<tr>
<td colspan="7" align="right"><strong>Distance time :{{$request->minutes}} mins + </strong></td>
<td align="center"><strong>{{$total_time}} mins</strong></td>
</tr>

<tr>
<td colspan="7" align="right"><strong>Total Time</strong></td>
<td align="center"><strong>{{$request->minutes + $total_time}} mins</strong></td>
</tr>

</tbody>

</table>

</div>
</div>